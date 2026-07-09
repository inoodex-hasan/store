@extends('frontend.layouts.app')
@section('content')
    <style>
        #item_name ~ .select2-container .select2-selection__arrow,
        #vendor ~ .select2-container .select2-selection__arrow { display: none; }
    </style>
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Purchase Report</h5>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('purchase.report.get') }}" method="GET" class="row g-2">
                        <div class="col-md-3 p-1">
                            <label class="form-label mb-0 small">Product</label>
                            <select name="item_name" id="item_name" class="form-select form-select-sm">
                                <option value="">All Products</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ request('item_name') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 p-1">
                            <label class="form-label mb-0 small">Vendor</label>
                            <select name="vendor" id="vendor" class="form-select form-select-sm">
                                <option value="">All Vendors</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ request('vendor') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 p-1">
                            <label class="form-label mb-0 small">From Date</label>
                            <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                        </div>
                        <div class="col-md-2 p-1">
                            <label class="form-label mb-0 small">To Date</label>
                            <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('purchase.report') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name (প্রোডাক্ট নাম)</th>
                                <th>Total Quantity (মোট পরিমাণ)</th>
                                <th>Total Amount (মোট এমাউন্ট)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $index => $purchase)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $purchase->product->name ?? 'N/A' }}</td>
                                    <td><span class="badge-status info">{{ $purchase->total_qty }}</span></td>
                                    <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="{{ asset('assets') }}/plugins/select2/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
                jQuery('#item_name').select2({ placeholder: 'All Products', allowClear: false, width: '100%' });
                jQuery('#vendor').select2({ placeholder: 'All Vendors', allowClear: false, width: '100%' });
            }
        });
    </script>
@endpush
