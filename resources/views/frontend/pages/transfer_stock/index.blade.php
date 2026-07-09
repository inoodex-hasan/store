@extends('frontend.layouts.app')
@section('content')
    <style>
        #product_id ~ .select2-container .select2-selection__arrow { display: none; }
    </style>
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Transfer Stock</h5>
                <a href="{{ route('transfer_stock.create') }}" class="btn btn-light btn-sm text-dark"><i class="fa fa-plus-circle"></i> Create Transfer Stock</a>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('transfer_stock.index') }}" method="GET" class="row g-2">
                        <div class="col-md-3 p-1">
                            <select name="product_id" id="product_id" class="form-select form-select-sm">
                                <option value="">All Products</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 p-1">
                            <select name="stock_from" class="form-select form-select-sm">
                                <option value="">All Warehouses (Stock from)</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ request('stock_from') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 p-1">
                            <select name="stock_to" class="form-select form-select-sm">
                                <option value="">All Shops (Stock to)</option>
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}" {{ request('stock_to') == $shop->id ? 'selected' : '' }}>{{ $shop->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 p-1">
                            <input type="number" name="quantity" value="{{ request('quantity') }}" class="form-control form-control-sm" placeholder="Min Qty">
                        </div>
                        <div class="col-md-3 d-flex gap-1 p-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('transfer_stock.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date & Time</th>
                                <th>Stock From</th>
                                <th>Stock To</th>
                                <th>Product</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transfer_stocks as $transfer_stock)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transfer_stock->created_at->timezone('Asia/Dhaka')->format('d M Y, h:i A') }}</td>
                                    <td>{{ $transfer_stock->fromWarehouse->location ?? 'N/A' }}</td>
                                    <td>{{ $transfer_stock->toShop->location ?? 'N/A' }}</td>
                                    <td>{{ $transfer_stock->product->name ?? 'N/A' }}</td>
                                    <td><span class="badge-status info">{{ $transfer_stock->quantity }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modern-pagination">
                    {{ $transfer_stocks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#product_id').select2({
                placeholder: 'All Products',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
