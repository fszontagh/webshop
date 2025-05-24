@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Generate Order Report</h1>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
            <div class="divider mb-4"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.orders.generate-report') }}" method="POST" id="reportForm">
                        @csrf

                        <div class="mb-3">
                            <label for="report_type" class="form-label">Report Type</label>
                            <select class="form-select" name="report_type" id="report_type" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" class="form-control" name="date_from" id="date_from" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" class="form-control" name="date_to" id="date_to" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection