@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card shadow">
                    @if ($errors->any())
                        <div class="alert alert-danger" id="validation-error-alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <script>
                            // Set a timeout to hide the alert after 2000 milliseconds (2 seconds)
                            setTimeout(function() {
                                document.getElementById('validation-error-alert').style.display = 'none';
                            }, 3000);
                        </script>
                    @endif
                    <div class="card-header cat-head align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1 fw-bold"> Create New Transfer-Stock </h5>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <a href="{{ route('transfer_stock.index') }}" class="btn create-btn-outline"> Transfer Stock List</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="fw-bold text-success  "> {{Session::get('message')}} </p>
                                <div class="live-preview">
                                    <div class="row gy-3">
                                        <form action="{{route('transfer_stock.new')}}" method="post">
                                            @csrf


                                            <div class="row g-3">

                                                <div class="mb-3">
                                                    <label for="stock_from" class="form-label"> Stock From (Warehouse)</label>
                                                    <select name="stock_from" id="stock_from" class="form-select" required>
                                                        <option value="">-- Select Warehouse Location --</option>
                                                        @foreach($warehouses as $warehouse)
                                                            <option value="{{ $warehouse->id }}">{{ $warehouse->location }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>



{{--                                                <div class="mb-3">--}}
{{--                                                    <label for="stock_to" class="form-label">Stock To (Shop)</label>--}}
{{--                                                    <select name="stock_to" id="stock_to" class="form-select" required>--}}
{{--                                                        @if($user_shop)--}}
{{--                                                            <option value="{{ $user_shop->id }}" selected>{{ $user_shop->location }}</option>--}}
{{--                                                        @else--}}
{{--                                                            <option value="" disabled selected>-- No Shop Assigned --</option>--}}
{{--                                                        @endif--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}




                                                <div class="mb-3">
                                                    <label for="stock_to" class="form-label"> Stock To (Shop) </label>
                                                    <select name="stock_to" id="stock_to" class="form-select" required
                                                            {{ !$user_shop ? 'disabled' : '' }} > 
                                                            <!-- Disable if no shop is assigned -->
                                                    @if($user_shop)
                                                        <!-- Show the user's only assigned shop as a pre-selected option -->
                                                            <option value="{{ $user_shop->id }}" selected>
                                                                {{ $user_shop->location }}  (Your Managed Shop)
                                                            </option>
                                                    @else
                                                        <!-- Fallback if no shop is assigned -->
                                                            <option value="" selected disabled>
                                                                -- No Shop Assigned (Contact Super Admin) --
                                                            </option>
                                                        @endif
                                                    </select>
                                                </div>




                                                <div class="mb-3">
                                                    <label for="product_id" class="form-label">Product</label>
                                                    <select name="product_id" id="product_id" class="form-select" required>
                                                        <option value="">-- Select Product --</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="opening_stock" class="form-label"> Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                                                </div>

                                            </div>



                                            <div class="mt-4 text-end">
                                                <button type="submit" class="btn create-btn px-4">Submit</button>
                                            </div>


                                        </form>
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
@endsection