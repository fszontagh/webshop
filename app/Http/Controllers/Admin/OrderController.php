<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use App\Exports\OrderReportExport;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'orderItems.item'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Export orders to Excel.
     */
    public function export()
    {
        return Excel::download(new OrdersExport, 'orders_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Show the order report form.
     */
    public function showReportForm()
    {
        return view('admin.orders.report-form');
    }

    /**
     * Generate and download the order report.
     */
    public function generateReport(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'report_type' => 'required|in:pdf,excel',
        ]);

        $dateFrom = Carbon::parse($request->date_from);
        $dateTo = Carbon::parse($request->date_to);

        // Generate the report based on the selected format
        if ($request->report_type == 'pdf') {
            $pdf = \PDF::loadView('admin.orders.report-pdf', [
                'orders' => Order::with('user', 'orderItems.item')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->get(),
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ]);

            return $pdf->download('order_report_' . date('Y-m-d') . '.pdf');
        } else {
            return Excel::download(new OrderReportExport($dateFrom, $dateTo), 'order_report_' . date('Y-m-d') . '.xlsx');
        }
    }
}