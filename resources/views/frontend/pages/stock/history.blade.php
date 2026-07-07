@extends('frontend.layouts.app')
@section('content')
<style>
    .page-wrapper .content { padding: 14px !important; }
    .badge-movement {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 12px;
        font-weight: 500;
    }
    .badge-in { background: #d4edda; color: #155724; }
    .badge-out { background: #f8d7da; color: #721c24; }
    .badge-neutral { background: #e2e3e5; color: #383d41; }
    .change-positive { color: #28a745; font-weight: 600; }
    .change-negative { color: #dc3545; font-weight: 600; }
    .change-zero { color: #6c757d; }
    .summary-card {
        /* border-left: 4px solid #0d6efd; */
        transition: transform 0.2s;
    }
    .summary-card:hover {
        transform: translateY(-2px);
    }
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

<div class="content container-fluid">
    <div class="card shadow">
        <div class="card-header cat-head d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Stock History</h5>
        </div>

        <div class="card-body">
            <!-- Filter Form -->
            <form action="{{ route('stock.history') }}" method="GET" class="row align-items-end mb-3">
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
                <div class="col-md-2 w-350">
                    <label>Product</label>
                    <select name="product_id" id="product_id" class="form-control">
                        <option value="">All Products</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-md-2">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="">All Locations</option>
                        <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>Shop</option>
                        <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>Warehouse</option>
                    </select>
                </div> --}}
                <div class="col-md-2">
                    <label>Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('stock.history') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <!-- Summary Cards -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card summary-card bg-primary text-white p-3">
                        <h6>Total Movements</h6>
                        <h3>{{ $totalMovements }}</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card summary-card bg-secondary text-white p-3">
                        <h6>Net Quantity Change</h6>
                        <h3 class="{{ $totalQuantityChanged >= 0 ? 'text-white' : 'text-warning' }}">
                            {{ $totalQuantityChanged >= 0 ? '+' : '' }}{{ $totalQuantityChanged }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Movements Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="table-layout: auto; width: 100%;">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Product</th>
                            {{-- <th>Location</th> --}}
                            <th>Brand</th>
                            <th>Previous</th>
                            <th>Change</th>
                            <th>New</th>
                            {{-- <th>By</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $index => $movement)
                            <tr>
                                <td>{{ $movements->firstItem() + $index }}</td>
                                <td>{{ $movement->created_at->timezone('Asia/Dhaka')->format('d M Y') }}</td>
                                <td>{{ $movement->product->name ?? 'N/A' }}</td>
                                {{-- <td>
                                    <span class="badge-movement badge-neutral">{{ $movement->type_label }}</span>
                                    @if($movement->type == 1 && $movement->location > 0)
                                        {{ $movement->shop?->location ?? '' }}
                                    @elseif($movement->type == 2 && $movement->location > 0)
                                        {{ $movement->warehouse?->location ?? '' }}
                                    @endif
                                </td> --}}
                                <td>
                                    {{ $movement->product->brand->name ?? 'N/A' }}
                                </td>
                                <td>{{ $movement->quantity_before }}</td>
                                <td>
                                    @if($movement->quantity_change > 0)
                                        <span class="change-positive">+{{ $movement->quantity_change }}</span>
                                    @elseif($movement->quantity_change < 0)
                                        <span class="change-negative">{{ $movement->quantity_change }}</span>
                                    @else
                                        <span class="change-zero">0</span>
                                    @endif
                                </td>
                                <td>{{ $movement->quantity_after }}</td>
                                {{-- <td>{{ $movement->user->name ?? 'System' }}</td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No stock movements found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {!! $movements->withQueryString()->links('pagination::bootstrap-5') !!}
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
    $('#brand_id').select2({
        placeholder: 'All Brands',
        allowClear: false,
        width: '100%'
    });
</script>
<script>
    // Auto-hide select2 arrow
    document.querySelectorAll('.select2-container--default .select2-selection--single .select2-selection__arrow b').forEach(el => {
        el.style.display = 'none';
    });
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
