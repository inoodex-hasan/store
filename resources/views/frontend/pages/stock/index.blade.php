@extends('frontend.layouts.app')
@section('content')
    <style>
        #product_id ~ .select2-container .select2-selection__arrow,
        #brand_id ~ .select2-container .select2-selection__arrow { display: none; }
    </style>
    @php
        $shopLocations = $shops->pluck('location')->unique()->values();
        $warehouseLocations = $warehouses->pluck('location')->unique()->values();
    @endphp
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Stock</h5>
                <a class="btn btn-light btn-sm text-dark" href="javascript:void(0)" data-bs-toggle="modal"
                    data-bs-target="#add-stock-modal">
                    <i class="fa fa-plus-circle"></i> Add Opening Stock
                </a>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('stock.index') }}" method="GET" class="row g-2">
                        <div class="col-md-3 p-1">
                            <select name="product_id" id="product_id" class="form-select form-select-sm">
                                <option value="">All Products</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 p-1">
                            <select name="brand_id" id="brand_id" class="form-select form-select-sm">
                                <option value="">All Brands</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('stock.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name (প্রোডাক্ট নাম)</th>
                                <th>Brand (ব্র্যান্ড)</th>
                                <th>Quantity (পরিমাণ)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $stock->product->name ?? 'N/A' }}</td>
                                    <td>{{ $stock->product->brand->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($stock->quantity == 0)
                                            <span class="badge-status danger">{{ $stock->quantity }}</span>
                                        @else
                                            <span class="badge-status success">{{ $stock->quantity }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="openEditModal({{ $stock->id }}, {{ $stock->product_id }}, {{ $stock->quantity }}, {{ $stock->type }}, '{{ $stock->shop?->location ?? ($stock->warehouse?->location ?? '') }}')">
                                                    <i class="far fa-edit"></i> Edit
                                                </a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                    onclick="deleteStock({{ $stock->id }})">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                                <form id="deleteForm{{ $stock->id }}"
                                                    action="{{ route('stock.delete', $stock->id) }}"
                                                    method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Opening Stock Modal --}}
    <div id="add-stock-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #e94134; color: #fff;">
                    <h5 class="modal-title" style="color: #fff;">Add Opening Stock</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('stock.new') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="add_product_id" class="form-select" required>
                                <option value="" disabled selected>-- Select Product --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Select Type</option>
                                <option value="1">Shop</option>
                                <option value="2">Warehouse</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Location</label>
                            <select class="form-select" id="location" name="location">
                                <option value="">Select Location</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Shared Edit Modal --}}
    <div id="edit-stock-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #e94134; color: #fff;">
                    <h5 class="modal-title" style="color: #fff;">Edit Stock</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editStockForm" method="POST" action="">
                        @csrf
                        <input type="hidden" id="edit-stock-id">
                        <div class="mb-3">
                            <label class="form-label">Select Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="edit-product-id" class="form-select" required>
                                <option value="" disabled>-- Select Product --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="edit-quantity" class="form-control" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Type</label>
                            <select class="form-select" id="edit-type" name="type" onchange="updateEditLocations()">
                                <option value="">Select Type</option>
                                <option value="1">Shop</option>
                                <option value="2">Warehouse</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Location</label>
                            <select class="form-select" id="edit-location" name="location">
                                <option value="">Select Location</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="{{ asset('assets') }}/plugins/select2/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const shopLocations = @json($shopLocations);
        const warehouseLocations = @json($warehouseLocations);

        function populateLocations(selectEl, locations, selectedLocation) {
            selectEl.innerHTML = '<option value="">Select Location</option>';
            locations.forEach(location => {
                const opt = document.createElement('option');
                opt.value = location;
                opt.text = location;
                if (selectedLocation && location === selectedLocation) opt.selected = true;
                selectEl.appendChild(opt);
            });
        }

        // Add form location
        const typeEl = document.getElementById('type');
        const locEl = document.getElementById('location');
        if (typeEl && locEl) {
            typeEl.addEventListener('change', function() {
                if (this.value === '1') populateLocations(locEl, shopLocations);
                else if (this.value === '2') populateLocations(locEl, warehouseLocations);
                else locEl.innerHTML = '<option value="">Select Location</option>';
            });
        }

        // Edit modal
        let currentEditLocation = '';

        function openEditModal(stockId, productId, quantity, type, location) {
            document.getElementById('editStockForm').action = '/stock/update/' + stockId;
            document.getElementById('edit-stock-id').value = stockId;
            document.getElementById('edit-product-id').value = productId;
            document.getElementById('edit-quantity').value = quantity;
            document.getElementById('edit-type').value = type;
            currentEditLocation = location;
            updateEditLocations();
            new bootstrap.Modal(document.getElementById('edit-stock-modal')).show();
        }

        function updateEditLocations() {
            const type = document.getElementById('edit-type').value;
            const loc = document.getElementById('edit-location');
            if (type === '1') populateLocations(loc, shopLocations, currentEditLocation);
            else if (type === '2') populateLocations(loc, warehouseLocations, currentEditLocation);
            else loc.innerHTML = '<option value="">Select Location</option>';
        }

        function deleteStock(stockId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This stock will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
                if (result.isConfirmed) document.getElementById('deleteForm' + stockId).submit();
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
                jQuery('#product_id').select2({ placeholder: 'All Products', allowClear: false, width: '100%' });
                jQuery('#brand_id').select2({ placeholder: 'All Brands', allowClear: false, width: '100%' });
                jQuery('#add_product_id').select2({
                    dropdownParent: jQuery('#add-stock-modal'),
                    placeholder: '-- Select Product --',
                    allowClear: true,
                    width: '100%'
                });
                jQuery('#edit-product-id').select2({
                    dropdownParent: jQuery('#edit-stock-modal'),
                    placeholder: '-- Select Product --',
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>
@endpush
