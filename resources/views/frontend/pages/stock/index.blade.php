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
        <div class="card shadow">
            <div class="card-header cat-head">
                <div class="page-header">
                    <div class="content-page-header">
                        <h5> Stock </h5>
                        <div class="list-btn">
                            <ul class="filter-list">
                                <li>
                                    <a class="btn create-btn" href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#add-product-modal">
                                        <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Opening Stock
                                    </a>
                                </li>
                            </ul>

                            <!-- Add Product Modal -->
                            <div id="add-product-modal" class="modal fade" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="add-purchase-modal"> Add Opening Stock </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mt-2 mb-4">
                                                <div class="auth-logo">
                                                    <a href="{{ route('stock.index') }}" class="logo logo-dark">
                                                        <span class="logo-lg">
                                                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo"
                                                                height="42">
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>


                                            <form method="post" action="{{ route('stock.new') }}" class="px-3">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="product_id" class="form-label"> Select Product <span
                                                            class="text-danger">*</span></label>
                                                    <select name="product_id" id="product_id" class="form-select" required>
                                                        <option value="" disabled selected>-- Select Product --
                                                        </option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->name }}
                                                                {{--  ({{ $product->model ?? 'N/A' }}) --}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="opening_stock" class="form-label"> Quantity <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="quantity" id="quantity"
                                                        class="form-control" value="1" min="1" required>
                                                </div>


                                                @php
                                                    $shopLocations = $shops->pluck('location')->unique()->values(); // Get only unique locations
                                                    $warehouseLocations = $warehouses
                                                        ->pluck('location')
                                                        ->unique()
                                                        ->values();
                                                @endphp

                                                <!-- Type Selection -->
                                                <div class="mb-3">
                                                    <label for="type" class="form-label fw-semibold">Type</label>
                                                    <select class="form-control" id="type" name="type">
                                                        <option value="">Select Type</option>
                                                        <option value="1"> Shop </option>
                                                        <option value="2"> Warehouse </option>
                                                    </select>
                                                </div>

                                                <!-- Location Selection -->
                                                <div class="mb-3">
                                                    <label for="location" class="form-label fw-semibold">Location</label>
                                                    <select class="form-control" id="location" name="location">
                                                        <option value="">Select Location</option>
                                                        <!-- Options will be populated by JavaScript -->
                                                    </select>
                                                </div>


                                                <div class="mb-3 mt-3">
                                                    <button type="submit" class="btn create-btn">Submit</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- End Add Modal -->

                        </div>
                    </div>
                </div>

            </div>

            <div class="card mb-3 p-3">
                <form action="{{ route('stock.index') }}" method="GET" class="row g-2 mb-3">

                    <div class="col-md-2">
                        <select name="product_id" class="form-select">
                            <option value="">All Products</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="location" class="form-select">
                            <option value="">All Locations</option>
                            @foreach ($locations as $loc)
                                <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                                    {{ $loc }}
                                </option>
                            @endforeach
                        </select>
                    </div>




                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="quantity" value="{{ request('quantity') }}" class="form-control"
                            placeholder="Quantity">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <a href="{{ route('stock.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </form>

            </div>

            <!-- Stock Table -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="productTable" class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th> Product Name (প্রোডাক্ট নাম) </th>
                                            <th> Location (লোকেশন)</th>
                                            <th> Type (টাইপ)</th>
                                            <th> Quantity (পরিমাণ) </th>
                                            <th class="no-sort">Actions (একশন)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $stock)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $stock->product->name ?? 'N/A' }}</td>

                                                <td>
                                                    @if ($stock->type == 1)
                                                        {{ $stock->shop->location ?? 'N/A' }}
                                                    @elseif($stock->type == 2)
                                                        {{ $stock->warehouse->location ?? 'N/A' }}
                                                    @else
                                                        Unknown
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($stock->type == 1)
                                                        Shop
                                                    @elseif($stock->type == 2)
                                                        Warehouse
                                                    @else
                                                        Unknown
                                                    @endif
                                                </td>

                                                {{--                                        <td>{{ $stock->quantity }}</td> --}}

                                                {{--                                        <td class="{{ $stock->quantity == 0 ? 'text-danger' : '' }}"> --}}
                                                {{--                                            {{ $stock->quantity }} --}}
                                                {{--                                        </td> --}}


                                                <td>
                                                    @if ($stock->quantity == 0)
                                                        <span
                                                            class="text-danger fw-bold fs-5">{{ $stock->quantity }}</span>
                                                    @else
                                                        {{ $stock->quantity }}
                                                    @endif
                                                </td>




                                                <td>

                                                    <div class="dropdown dropdown-action">
                                                        <a href="{{ route('stock.edit', $stock->id) }}"
                                                            class="btn-action-icon" data-bs-toggle="dropdown"><i
                                                                class="fas fa-ellipsis-v"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-inventory-modal{{ $stock->id }}">
                                                                <i class="far fa-edit me-2"></i>Edit
                                                            </a>


                                                            {{--                                                    <a href="#" class="dropdown-item" --}}
                                                            {{--                                                       onclick="event.preventDefault(); if (confirm('Are you sure to delete this Stock?')) document.getElementById('deleteForm{{ $stock->id }}').submit();"> --}}
                                                            {{--                                                        <i class="far fa-trash-alt me-2"></i>Delete --}}
                                                            {{--                                                    </a> --}}



                                                            <a href="#" class="dropdown-item"
                                                                onclick="deleteStock({{ $stock->id }})">
                                                                <i class="far fa-trash-alt me-2"></i>Delete
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



                                            <!-- Edit inventory Modal -->
                                            <!-- Inventory Edit Modal -->
                                            <div id="edit-inventory-modal{{ $stock->id }}" class="modal fade"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="text-center mt-2 mb-4">
                                                                <div class="auth-logo">
                                                                    <a href="{{ route('stock.index') }}"
                                                                        class="logo logo-dark">
                                                                        <span class="logo-lg">
                                                                            <img src="{{ asset('assets/img/logo.png') }}"
                                                                                alt="Logo" height="42">
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>




                                                            <form method="POST"
                                                                action="{{ route('stock.update', $stock->id) }}"
                                                                class="px-3">
                                                                @csrf
                                                                {{--                                                      @method('PUT') --}}





                                                                <!-- Hidden values to help JavaScript know what's selected -->
                                                                <input type="hidden" class="current-type"
                                                                    value="{{ $stock->type }}">
                                                                <input type="hidden" class="current-location"
                                                                    value="{{ $stock->shop?->location ?? ($stock->warehouse?->location ?? '') }}">


                                                                <!-- Product select -->
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Select Product <span
                                                                            class="text-danger">*</span></label>
                                                                    <select name="product_id" class="form-select"
                                                                        required>
                                                                        <option value="" disabled>-- Select Product
                                                                            --</option>
                                                                        @foreach ($products as $product)
                                                                            <option value="{{ $product->id }}"
                                                                                {{ $product->id == $stock->product_id ? 'selected' : '' }}>
                                                                                {{ $product->name }}
                                                                                {{--                                                                            ({{ $product->model ?? 'N/A' }}) --}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>


                                                                <!-- Quantity -->
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Quantity <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" name="quantity"
                                                                        class="form-control" min="0"
                                                                        value="{{ $stock->quantity }}" required>
                                                                </div>


                                                                <!-- Type -->
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Type</label>
                                                                    <select class="form-control type-select"
                                                                        name="type">
                                                                        <option value="">Select Type</option>
                                                                        <option value="1"
                                                                            {{ $stock->type == 1 ? 'selected' : '' }}>Shop
                                                                        </option>
                                                                        <option value="2"
                                                                            {{ $stock->type == 2 ? 'selected' : '' }}>
                                                                            Warehouse</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Location -->
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Location</label>
                                                                    <select class="form-control location-select"
                                                                        name="location">
                                                                        <option value="">Select Location</option>
                                                                    </select>
                                                                </div>



                                                                <div class="mb-3">
                                                                    <button type="submit"
                                                                        class="btn create-btn">Update</button>
                                                                </div>


                                                            </form>



                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </tbody>

                                </table>

                                <div class="d-flex justify-content-end mt-4">
                                    {!! $stocks->links('pagination::bootstrap-5') !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




    {{-- only for store data  select shop or warehouse show auto location --}}


    {{--    <script> --}}
    {{--        const shopLocations = @json($shopLocations); --}}
    {{--        const warehouseLocations = @json($warehouseLocations); --}}

    {{--        const typeSelect = document.getElementById('type'); --}}
    {{--        const locationSelect = document.getElementById('location'); --}}

    {{--        function populateLocations(locations) { --}}
    {{--            locationSelect.innerHTML = '<option value="">Select Location</option>'; --}}
    {{--            locations.forEach(location => { --}}
    {{--                const option = document.createElement('option'); --}}
    {{--                option.value = location; --}}
    {{--                option.text = location; --}}
    {{--                locationSelect.appendChild(option); --}}
    {{--            }); --}}
    {{--        } --}}

    {{--        typeSelect.addEventListener('change', function () { --}}
    {{--            const selectedType = this.value; --}}
    {{--            if (selectedType === '1') { --}}
    {{--                populateLocations(shopLocations); --}}
    {{--            } else if (selectedType === '2') { --}}
    {{--                populateLocations(warehouseLocations); --}}
    {{--            } else { --}}
    {{--                locationSelect.innerHTML = '<option value=""> Select Location </option>'; --}}
    {{--            } --}}
    {{--        }); --}}
    {{--    </script> --}}






    {{--  Both like store and edit page  select shop or warehouse show auto location --}}

    <script>
        const shopLocations = @json($shopLocations);
        const warehouseLocations = @json($warehouseLocations);

        function populateLocations(selectEl, locations, selectedLocation = null) {
            selectEl.innerHTML = '<option value="">Select Location</option>';
            locations.forEach(location => {
                const option = document.createElement('option');
                option.value = location;
                option.text = location;
                if (selectedLocation && location === selectedLocation) {
                    option.selected = true;
                }
                selectEl.appendChild(option);
            });
        }

        //  1. Handle Index Page (Add Form)
        const indexType = document.getElementById('type');
        const indexLocation = document.getElementById('location');

        if (indexType && indexLocation) {
            indexType.addEventListener('change', function() {
                if (this.value === '1') {
                    populateLocations(indexLocation, shopLocations);
                } else if (this.value === '2') {
                    populateLocations(indexLocation, warehouseLocations);
                } else {
                    indexLocation.innerHTML = '<option value="">Select Location</option>';
                }
            });
        }

        //  2. Handle All Edit Modals
        document.querySelectorAll('.modal').forEach(modal => {
            const typeSelect = modal.querySelector('.type-select');
            const locationSelect = modal.querySelector('.location-select');
            const currentType = modal.querySelector('.current-type')?.value;
            const currentLocation = modal.querySelector('.current-location')?.value;

            if (typeSelect && locationSelect) {
                typeSelect.addEventListener('change', function() {
                    if (this.value === '1') {
                        populateLocations(locationSelect, shopLocations);
                    } else if (this.value === '2') {
                        populateLocations(locationSelect, warehouseLocations);
                    } else {
                        locationSelect.innerHTML = '<option value="">Select Location</option>';
                    }
                });
            }

            modal.addEventListener('show.bs.modal', () => {
                if (currentType === '1') {
                    populateLocations(locationSelect, shopLocations, currentLocation);
                } else if (currentType === '2') {
                    populateLocations(locationSelect, warehouseLocations, currentLocation);
                }
            });
        });
    </script>




    {{--    sweetAlert Delete() --}}

    <script>
        function deleteStock(stockId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Warning: This stock will be permanently deleted!\n" +
                    "Are you absolutely sure?!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + stockId).submit();
                }
            });
        }
    </script>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
