@extends('frontend.layouts.app')
@section('content')
    <link href="{{ asset('assets') }}/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <div class="content container-fluid">
        <div class="modern-card mb-3">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by Product Name" value="{{ request('search') }}">
                        </div>
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
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>


                    <div id="add-payment-modal" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background: #e94134; color: #fff;">
                                    <h5 class="modal-title" id="add-payment-modal" style="color: #fff;">Add Product</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
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

                                        <div class="col-md-12 col-lg-12">
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
                                            <button type="submit" class="btn btn-light">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-sm-12">
                <div class="modern-card">
                    <div class="card-header">
                        <h5>Products</h5>
                        <a class="btn btn-light btn-sm text-dark float-end" href="javascript:void(0)" data-bs-toggle="modal"
                            data-bs-target="#add-payment-modal">
                            <i class="fa fa-plus-circle"></i> Add Product </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productTable" class="modern-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Brand Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $brandRows = $products
                                            ->sortBy(function ($p) {
                                                return strtolower(optional($p->brand)->name ?? 'zzzzzz');
                                            })
                                            ->unique('brand_id')
                                            ->values();
                                    @endphp

                                    @foreach ($brandRows as $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                @if ($product->brand)
                                                    <a href="javascript:void(0)" class="fw-semibold"
                                                        onclick="showBrandProducts({{ $product->brand_id }}, '{{ $product->brand->name }}')">
                                                        {{ $product->brand->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: #e94134; color: #fff;">
                    <h5 class="modal-title" id="brand-modal-title" style="color: #fff;">Brand Products</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2 w-100" style="text-align: left !important;">
                        <span class="fw-semibold">Brand:</span>
                        <span id="brand-selected-name" class="text-primary d-inline-block"></span>
                    </div>
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
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
                <div class="modal-header" style="background: #e94134; color: #fff;">
                    <h5 class="modal-title" style="color: #fff;">Edit Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button type="submit" class="btn btn-light">Update</button>
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
                                <span class="badge-status ${product.status == 1 ? 'active' : 'inactive'}">
                                    ${product.status == 1 ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="openEditProductModalFromBrand(${product.id})">
                                            <i class="far fa-edit"></i>Edit
                                        </a>
                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                            onclick="deleteProductById(${product.id})">
                                            <i class="far fa-trash-alt"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }

            document.getElementById('brand-modal-title').textContent = brandName + ' - Products';
            document.getElementById('brand-selected-name').textContent = brandName;
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
