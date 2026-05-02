@extends('frontend.layouts.app')
@section('content')
    <link href="{{ asset('assets') }}/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-width: 0 !important;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        #productTable {
            width: 100%;
            table-layout: fixed;
            /* key: respects your % widths strictly */
            font-size: 0.82rem;
        }

        #productTable th,
        #productTable td {
            vertical-align: middle;
            padding: 7px 8px;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Allow product name to wrap if needed */
        #productTable td:nth-child(3) {
            white-space: normal;
            word-break: break-word;
            text-align: center;
        }

        @media (max-width: 1366px) {
            #productTable {
                font-size: 0.78rem;
            }

            #productTable th,
            #productTable td {
                padding: 5px 6px;
            }
        }

        @media (max-width: 1280px) {
            #productTable {
                font-size: 0.75rem;
            }
        }

        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #aaa;
            border-radius: 4px;
        }
    </style>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="content-page-header">
                <div class="list-btn">
                    <div class="card mb-3 p-3">
                        <form method="GET" action="{{ route('products.index') }}">
                            <div class="row g-2">
                                <!-- Search -->
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by Product Name" value="{{ request('search') }}">
                                </div>

                                <!-- Category Filter -->
                                <div class="col-md-2">
                                    <select name="category_id" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Brand Filter -->
                                <div class="col-md-3">
                                    <select name="brand_id" class="form-select">
                                        <option value="">All Brands</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-2">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter + Reset -->
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div id="add-payment-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header cat-head">
                                    <h5 class="modal-title" id="add-payment-modal">Add Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form class="px-3" method="post" action="{{ route('products.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <!-- Input for Product Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Brand Name <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="brand_id" id="brand_id" required>
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option {{ $brand->id == old('brand_id') ? 'selected' : '' }}
                                                        value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Product Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Enter product name" value="{{ old('name') }}" required>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <label for="category_image" class="form-label fw-semibold">Product Image</label>
                                            <input type="file" class="form-control" id="product_image"
                                                name="product_image" accept="image/*">
                                        </div>


                                        <div class="mb-3">
                                            <label for="name" class="form-label"> Category Name <span
                                                    class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control select2" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label for="category" class="form-label"> Unit <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="unit" id="unit" class="form-control"
                                                placeholder="Enter Unit name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select mb-3" name="status" required>
                                                <option selected="" value="1">Actve</option>
                                                <option value="0">InActve</option>
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <button type="submit" class="btn create-btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow">
                    <div class="card-header cat-head d-flex  justify-content-between align-items-center">
                        <h5 class="card-title mb-0  fw-bold">Products</h5>
                        <a class="btn create-btn-outline" href="javascript:void(0)" data-bs-toggle="modal"
                            data-bs-target="#add-payment-modal">
                            <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Product </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productTable" class="table table-center table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 4%;">#</th>
                                        <th style="width: 14%;">Brand <small class="d-block text-muted fw-normal"
                                                style="font-size:0.7rem;">ব্রান্ড নাম</small></th>
                                        {{-- <th style="width: 18%;">Product Name <small class="d-block text-muted fw-normal" style="font-size:0.7rem;">প্রোডাক্ট নাম</small></th>
        <th style="width: 12%;">Unit Price <small class="d-block text-muted fw-normal" style="font-size:0.7rem;">ইউনিট প্রাইস</small></th>
        <th style="width: 16%;">Category <small class="d-block text-muted fw-normal" style="font-size:0.7rem;">ক্যাটাগরি</small></th>
        <th style="width: 8%;">Unit <small class="d-block text-muted fw-normal" style="font-size:0.7rem;">ইউনিট</small></th> --}}
                                        <th style="width: 9%;">Status <small class="d-block text-muted fw-normal"
                                                style="font-size:0.7rem;">স্ট্যাটাস</small></th>
                                        {{-- <th style="width: 10%;" class="no-sort">Actions <small
                                                class="d-block text-muted fw-normal"
                                                style="font-size:0.7rem;">একশন</small></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                @if ($product->brand)
                                                    <a href="javascript:void(0)" class="text-decoration-none fw-semibold"
                                                        onclick="showBrandProducts({{ $product->brand_id }}, '{{ $product->brand->name }}')">
                                                        {{ $product->brand->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            {{-- <td title="{{ $product->name }}">{{ Str::limit($product->name, 28) }}</td>
            <td>{{ $product->latestPurchase->unit_price ?? '—' }}</td>
            <td title="{{ $product->category->category_name ?? 'N/A' }}">
                {{ Str::limit($product->category->category_name ?? 'N/A', 16) }}
            </td>
            <td>{{ $product->unit }}</td> --}}
                                            <td>
                                                @if ($product->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            {{-- <td class="text-center align-middle">
                                                <div class="dropdown dropdown-action d-inline-block">
                                                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="openEditProductModal({{ $product->id }}, {{ $product->brand_id }}, '{{ $product->name }}', '{{ $product->unit }}', {{ $product->status }}, {{ $product->category_id ?? 'null' }})">
                                                                    <i class="far fa-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a onclick="if (confirm('Are you sure to delete the product?')) { document.getElementById('serviceDelete{{ $product->id }}').submit(); }"
                                                                    class="dropdown-item" href="javascript:void(0)">
                                                                    <i class="far fa-trash-alt me-2"></i>Delete
                                                                </a>
                                                                <form id="serviceDelete{{ $product->id }}"
                                                                    action="{{ route('products.destroy', $product->id) }}"
                                                                    method="POST" style="display:none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Brand Products Modal --}}
    <div id="brand-products-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header cat-head">
                    <h5 class="modal-title" id="brand-modal-title">Brand Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Category</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="brand-products-tbody">
                                {{-- Populated by JavaScript --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shared Edit Product Modal --}}
    <div id="edit-product-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header cat-head">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" class="px-3" method="POST" action=""
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="brand_id" id="edit-brand-id" required>
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit-product-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" class="form-control" name="product_image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <select name="category_id" id="edit-category-id" class="form-control select2" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <input type="text" name="unit" id="edit-unit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="edit-status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn create-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @php
        $productsData = [];
        foreach ($products as $p) {
            $productsData[] = [
                'id' => $p->id,
                'name' => $p->name,
                'brand_id' => $p->brand_id,
                'category_id' => $p->category_id,
                'category_name' => $p->category ? $p->category->category_name : 'N/A',
                'unit' => $p->unit,
                'unit_price' => $p->latestPurchase->unit_price ?? '—',
                'status' => $p->status,
            ];
        }
    @endphp

    <script>
        // Products data for brand modal
        const productsData = @json($productsData);

        function showBrandProducts(brandId, brandName) {
            const tbody = document.getElementById('brand-products-tbody');
            tbody.innerHTML = '';

            const normalizedBrandId = String(brandId);
            const brandProducts = productsData.filter(p => String(p.brand_id) === normalizedBrandId);

            if (brandProducts.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">No products found for this brand</td></tr>';
            } else {
                brandProducts.forEach((product, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${product.name}</td>
                            <td>${product.unit_price ?? '—'}</td>
                            <td>${product.category_name}</td>
                            <td>${product.unit}</td>
                            <td>
                                <span class="badge ${product.status == 1 ? 'bg-success' : 'bg-danger'}">
                                    ${product.status == 1 ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropdown dropdown-action d-inline-block">
                                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="openEditProductModalFromBrand(${product.id})">
                                                    <i class="far fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="deleteProductById(${product.id})">
                                                    <i class="far fa-trash-alt me-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }

            document.getElementById('brand-modal-title').textContent = brandName + ' - Products';
            const modal = new bootstrap.Modal(document.getElementById('brand-products-modal'));
            modal.show();
        }

        function openEditProductModal(productId, brandId, name, unit, status, categoryId) {
            document.getElementById('editProductForm').action = '/products/' + productId;
            document.getElementById('edit-brand-id').value = brandId;
            document.getElementById('edit-product-name').value = name;
            document.getElementById('edit-unit').value = unit;
            document.getElementById('edit-status').value = status;
            document.getElementById('edit-category-id').value = categoryId || '';

            // Refresh select2 if initialized
            if ($.fn.select2) {
                $('#edit-brand-id, #edit-category-id').select2();
            }

            const modal = new bootstrap.Modal(document.getElementById('edit-product-modal'));
            modal.show();
        }

        function openEditProductModalFromBrand(productId) {
            const product = productsData.find(p => Number(p.id) === Number(productId));
            if (!product) return;
            openEditProductModal(
                product.id,
                product.brand_id,
                product.name,
                product.unit,
                product.status,
                product.category_id
            );
        }

        function deleteProductById(productId) {
            const deleteForm = document.getElementById('serviceDelete' + productId);
            if (!deleteForm) return;
            if (confirm('Are you sure to delete the product?')) {
                deleteForm.submit();
            }
        }
    </script>

    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 on brand dropdown in add product modal
            $('#brand_id').select2({
                placeholder: 'Select Brand',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#add-payment-modal')
            });
        });
    </script>
@endsection
