@extends('frontend.layouts.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #888 transparent;
            border-width: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 0 !important;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: -2px;
            position: absolute;
            top: 50%;
            width: 0;
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
                                        <th>#</th>
                                        <th>Brand Name (ব্রান্ড নাম)</th>
                                        <th>Product Name (প্রোডাক্ট নাম)</th>
                                        <th>Product Unit Price(প্রোডাক্ট ইউনিট প্রাইস)</th>
                                        <th>Product Image(প্রোডাক্ট ছবি)</th>
                                        <th>Category Name (ক্যাটাগরি নাম)</th>
                                        <th> Unit (ইউনিট)</th>
                                        <th>Status (স্ট্যাটাস)</th>
                                        <th class="no-sort">Actions (একশন)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $product->brand->name ?? 'N/A' }}</td>

                                            <td>{{ $product->name }}</td>
                                            <td>
                                                {{ $product->latestPurchase->unit_price ?? '—' }}
                                            </td>
                                            <td>
                                                <img class="t-img" src="{{ asset($product->product_image) }}"
                                                    alt="" height="150" width="150" />
                                            </td>

                                            <td>{{ $product->category->category_name ?? 'N/A' }}</td>

                                            <td>{{ $product->unit }}</td>


                                            <td>
                                                @if ($product->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="btn-action-icon"
                                                            data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#edit-product-modal{{ $product->id }}">
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
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-4">
                                {!! $products->links('pagination::bootstrap-5') !!}
                            </div>

                            <!-- Modals should be outside the table -->
                            @foreach ($products as $product)
                                <div id="edit-product-modal{{ $product->id }}" class="modal fade" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header cat-head">
                                                <h5 class="modal-title" id="edit-product-modal{{ $product->id }}">Edit
                                                    Product</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <form class="px-3" method="POST"
                                                    action="{{ route('products.update', $product->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Brand Name <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control select2" name="brand_id"
                                                            id="brand_id" required>
                                                            <option value="">Select Brand</option>
                                                            @foreach ($brands as $brand)
                                                                <option
                                                                    {{ $brand->id == $product->brand_id ? 'selected' : '' }}
                                                                    value="{{ $brand->id }}">{{ $brand->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Product Name -->
                                                    <div class="mb-3">
                                                        <label for="name{{ $product->id }}" class="form-label">Product
                                                            Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name"
                                                            id="name{{ $product->id }}" class="form-control"
                                                            placeholder="Enter product name"
                                                            value="{{ old('name', $product->name) }}" required>
                                                    </div>



                                                    <div class="col-md-6 col-lg-6">
                                                        <label for="category_image" class="form-label fw-semibold">Product
                                                            Image</label>
                                                        <input type="file" class="form-control" id="product_image"
                                                            name="product_image" accept="image/*">
                                                    </div>




                                                    <div class="mb-3">
                                                        <label for="name" class="form-label"> Category Name <span
                                                                class="text-danger">*</span></label>
                                                        <select name="category_id" class="form-control select2" required>
                                                            <option value="">-- Select Category --</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="category" class="form-label"> Unit <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="unit" id="unit"
                                                            value="{{ old('name', $product->unit) }}"
                                                            class="form-control" placeholder="Enter Unit name" required>
                                                    </div>



                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label for="status{{ $product->id }}"
                                                            class="form-label">Status</label>
                                                        <select class="form-select mb-3" name="status"
                                                            id="status{{ $product->id }}" required>
                                                            <option value="1"
                                                                {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="0"
                                                                {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                                                                Inactive</option>
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
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
