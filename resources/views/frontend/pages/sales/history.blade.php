@extends('frontend.layouts.app')
@section('content')
    <style>
        #product_id ~ .select2-container .select2-selection__arrow { display: none; }
    </style>
    <div class="content container-fluid">
        <!-- Stats Cards -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body p-3">
                        <h6 class="text-muted mb-1 small">Total Products Sold</h6>
                        <h3 style="color: #e94134;" class="fw-bold mb-0">{{ $totalProductsSold }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body p-3">
                        <h6 class="text-muted mb-1 small">Unique Products</h6>
                        <h3 style="color: #e94134;" class="fw-bold mb-0">{{ $sales->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="modern-card">
            <div class="card-header">
                <h5>Sales History</h5>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('sales.history') }}" method="GET" class="row g-2">
                        <div class="col-md-2">
                            <label class="form-label mb-0 small">Specific Date</label>
                            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small">From Date</label>
                            <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small">To Date</label>
                            <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-0 small">Product</label>
                            <select name="product_id" id="product_id" class="form-select form-select-sm">
                                <option value="">All Products</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('sales.history') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Total Qty Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $index => $item)
                                <tr>
                                    <td>{{ $sales->firstItem() + $index }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td><span class="badge-status success">{{ $item->total_qty }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No sales data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($sales->hasPages())
                    <div class="modern-pagination">
                        {{ $sales->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
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
                jQuery('#product_id').select2({
                    placeholder: 'All Products',
                    allowClear: false,
                    width: '100%'
                });
            }
        });
    </script>
@endpush
