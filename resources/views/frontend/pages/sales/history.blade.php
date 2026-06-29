@extends('frontend.layouts.app')
@section('content')
<style>
    .page-wrapper .content { padding: 14px !important; }
</style>
<div class="content container-fluid">
    <div class="card shadow">
        <div class="card-header cat-head d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Sales History</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('sales.history') }}" method="GET" class="row align-items-end mb-3">
                <div class="col-md-2">
                    <label>Specific Date</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-2">
                    <label>From Date</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-2">
                    <label>To Date</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
<<<<<<< HEAD
                <div class="col-md-2 w-350">
=======
                <div class="col-md-2">
>>>>>>> 388af89e6faa5553199f55ffc7839218b44e1e12
                    <label>Product</label>
                    <select name="product_id" id="product_id" class="form-control">
                        <option value="">All Products</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
<<<<<<< HEAD
                    <button type="submit" class="btn btn-primary w-60">Filter</button>
                    <a href="{{ route('sales.history') }}" class="btn btn-secondary w-60">Reset</a>
=======
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('sales.history') }}" class="btn btn-secondary w-100">Reset</a>
>>>>>>> 388af89e6faa5553199f55ffc7839218b44e1e12
                </div>
            </form>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card bg-info text-white p-3">
                        <h6>Total Products Sold</h6>
                        <h3>{{ $totalProductsSold }}</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success text-white p-3">
                        <h6>Unique Products</h6>
                        <h3>{{ $sales->total() }}</h3>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
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
                                <td>{{ $item->total_qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No sales data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {!! $sales->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#product_id').select2({
            placeholder: 'All Products',
            allowClear: false,
            width: '100%'
        });
    </script>
    <style>
    .select2-container--default .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
        right: 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #6c757d transparent transparent transparent !important;
        border-width: 6px 5px 0 5px !important;
        border-style: solid !important;
        height: 0 !important;
        width: 0 !important;
        padding: 0 !important;
        transform: none !important;
        margin-left: -5px !important;
        margin-top: -3px !important;
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
    }
    </style>
@endsection