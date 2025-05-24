@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Generate Order Report</div>

                <div class="card-body">
                    <form action="{{ route('admin.orders.generate-report') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="date_from" class="col-md-4 col-form-label text-md-right">From Date</label>

                            <div class="col-md-6">
                                <input id="date_from" type="date" class="form-control @error('date_from') is-invalid @enderror" name="date_from" value="{{ old('date_from', date('Y-m-01')) }}" required autocomplete="date_from" autofocus>

                                @error('date_from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_to" class="col-md-4 col-form-label text-md-right">To Date</label>

                            <div class="col-md-6">
                                <input id="date_to" type="date" class="form-control @error('date_to') is-invalid @enderror" name="date_to" value="{{ old('date_to', date('Y-m-d')) }}" required autocomplete="date_to">

                                @error('date_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="format" class="col-md-4 col-form-label text-md-right">Format</label>

                            <div class="col-md-6">
                                <select id="format" class="form-control @error('format') is-invalid @enderror" name="format" required>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                </select>

                                @error('format')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection