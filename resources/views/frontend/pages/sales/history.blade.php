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
                <div class="col-md-3">
                    <label>Specific Date</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('sales.history') }}" class="btn btn-secondary w-100">Reset</a>
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
@endsection