@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body p-3">
                        <h6 class="text-muted mb-1 small">Total Movements</h6>
                        <h3 style="color: #e94134;" class="fw-bold mb-0">{{ $totalMovements }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body p-3">
                        <h6 class="text-muted mb-1 small">Net Quantity Change</h6>
                        <h3 class="fw-bold mb-0 {{ $totalQuantityChanged >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $totalQuantityChanged >= 0 ? '+' : '' }}{{ $totalQuantityChanged }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="modern-card">
            <div class="card-header">
                <h5>Stock History</h5>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('stock.history') }}" method="GET" class="row g-2">
                        <div class="col-md-2">
                            <label class="form-label mb-0 small p-1">Specific Date</label>
                            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small p-1">From Date</label>
                            <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small p-1">To Date</label>
                            <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small p-1">Product</label>
                            <select name="product_id" id="product_id" class="form-select form-select-sm">
                                <option value="">All Products</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small p-1">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-select form-select-sm">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('stock.history') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Brand</th>
                                <th>Previous</th>
                                <th>Change</th>
                                <th>Current</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $index => $movement)
                                <tr>
                                    <td>{{ $movements->firstItem() + $index }}</td>
                                    <td>{{ $movement->created_at->timezone('Asia/Dhaka')->format('d M Y') }}</td>
                                    <td>{{ $movement->product->name ?? 'N/A' }}</td>
                                    <td>{{ $movement->product->brand->name ?? 'N/A' }}</td>
                                    <td>{{ $movement->quantity_before }}</td>
                                    <td>
                                        @if($movement->quantity_change > 0)
                                            <span class="badge-status success">+{{ $movement->quantity_change }}</span>
                                        @elseif($movement->quantity_change < 0)
                                            <span class="badge-status danger">{{ $movement->quantity_change }}</span>
                                        @else
                                            <span class="badge-status info">0</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->quantity_after }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No stock movements found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($movements->hasPages())
                    <div class="modern-pagination">
                        {{ $movements->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="{{ asset('assets') }}/plugins/select2/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <style>
        #product_id ~ .select2-container .select2-selection__arrow,
        #brand_id ~ .select2-container .select2-selection__arrow { display: none; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
                jQuery('#product_id').select2({ placeholder: 'All Products', allowClear: false, width: '100%' });
                jQuery('#brand_id').select2({ placeholder: 'All Brands', allowClear: false, width: '100%' });
            }
        });
    </script>
@endpush
