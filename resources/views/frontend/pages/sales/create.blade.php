@extends('frontend.layouts.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    select, input {
        border-color: #000 !important;
    }

    label {
        color: #000 !important;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #000 !important;
        border-radius: 6px;
        height: 40px !important;
        position: relative !important;
        /* SVG arrow as background */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23888' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #212529;
        line-height: 40px !important;
        padding-left: 12px !important;
        padding-right: 30px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;
    }

    /* Hide the default broken arrow */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none !important;
    }

</style>
    <!-- <style>
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

        select,
        input {
            border-color: #000 !important;
        }

        label {
            color: #000 !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
        }
    </style> -->
    @csrf
    <div class="content container-fluid pt-0">


        <div class="card mb-3 card-shadow mt-4">
            <div class="card-body">
                <!-- Page Header -->

                <!-- /Page Header -->
                <div class="row">
                    <div class="col-12 col-md-12">
                        <form action="{{ route('cart.store') }}" method="post">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-12"> --}}






                                {{-- <label>Category</label>
									<select onchange="filterProduct(this)" name="category" id="category" class="form-control" style="height: 30px; width:100% !important">
										<option value="">Select</option>
										@foreach ($categories as $category)
											<option value="{{ $category->id }}" class="">
												{{ $category->category_name  }}
											</option>
										@endforeach
									</select>
								</div>
								<div class="col-12 mt-3">
									<label>Product</label>
									{{-- <select onchange="loadSizeAndColor(event)" name="product" id="product" class="form-control" style="height: 30px; width:100% !important;" required> --}}
                                {{-- <select onchange="loadPurchasePrice(event)" name="product" id="product" class="form-control" style="height: 30px; width:100% !important;" required>

										<option value="">Select</option>
										@foreach ($products as $product)
											<option class="category category{{$product->category?->id}}" value="{{ $product->id }}" data-name="{{ $product->name }}({{$product->model}})" data-price="{{ $product->latestPurchase->unit_price??0 }}" data-warranty="{{ $product->warranty??0 }}">
												{{ $product->name }} --}}

                                {{--												({{$product?->unit?->name}}) --}}

                                {{-- </option> --}}
                                {{-- @endforeach --}}
                                {{-- </select> --}}
                                {{-- </div> --}}







                                <!-- Category Selection -->
                                <div class="col-md-4 mt-3">
                                    <label>Category (ক্যাটাগরি)</label>
                                    <select onchange="filterProduct(this)" name="category" id="category"
                                        class="form-control" style="height: 40px; width:100% !important">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                {{-- 
                                    <select name="product" id="product" class="form-control" onchange="setStock()">
                                    <option value=""> Select Product </option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-stock="{{ $stocks[$product->id] ?? 0 }}">
                                            {{ $product->name }}
                                    </option>
                                    @endforeach
                                    </select> --}}


                                {{-- 
<select id="product" class="form-control" onchange="setStock()">
    <option value="">Select Product</option>
    @foreach ($products as $product)
        <option value="{{ $product->id }}" data-stock="{{ $stocks[$product->id] ?? 0 }}">
            {{ $product->name }}
        </option>
    @endforeach
</select>


                      



<div class="mt-3">
    <label>Product Stock</label>
    <input type="text" id="product_stock" class="form-control" readonly>
</div> --}}





                                {{-- test stock qty --}}

                                {{-- <select id="product" class="form-control" onchange="setStock()">
    <option value="">Select Product</option>
    @foreach ($products as $product)
        <option value="{{ $product->id }}" data-stock="{{ $stocks[$product->id] ?? 0 }}">
            {{ $product->name }}
        </option>
    @endforeach
</select> --}}



                                <div class="col-md-4 mt-3">
                                    <label>Product (প্রোডাক্ট)</label>
                                    <select id="product" class="form-control select2" name="product" onchange="setStock()">
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-stock="{{ $stocks[$product->id] ?? 0 }}"
                                                data-category-id="{{ $product->category_id }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col-md-4 mt-3">
                                    <label>Product Stock (প্রোডাক্ট স্টক)</label>
                                    <input type="text" id="product_stock" name="product_stock" class="form-control"
                                        readonly>
                                </div>












                                <!-- Unit Price Input -->
                                <div class="col-12 col-md-4 mt-3">
                                    <label>Unit Price (ইউনিট প্রাইস)</label>
                                    <input onchange="calculateTotal()" type="number" class="form-control" name="unit_price"
                                        id="unit_price" placeholder="Unit Price" required>
                                </div>

                                <!-- Quantity Input -->
                                <div class="col-12 col-md-4 mt-3">
                                    <label>Qty (পরিমাণ)</label>
                                    <input onchange="calculateTotal()" type="number" class="form-control" name="qty"
                                        id="qty" placeholder="Qty" required>
                                </div>

                                <!-- Total Price Output -->
                                <div class="col-12 col-md-4 mt-3">
                                    <label>Total Price (টোটাল প্রাইস)</label>
                                    <input type="number" class="form-control" name="total_price" id="total_price"
                                        placeholder="Total Price" readonly>
                                </div>








                                {{-- <div class="col-12 col-md-6 mt-3">
									<label>Sizes</label>
									<select onchange="productDetails(event)" name="size" id="size" class="form-control" style="height: 30px; width:100% !important;" required>
										<option value="">Select Size</option>
									</select>
								</div>



								<div class="col-12 col-md-6 mt-3">
									<label>Colors</label>
									<select onchange="productDetails(event)" name="color" id="color" class="form-control" style="height: 30px; width:100% !important;" >
										<option value="">Select Color</option>
									</select>
								</div> --}}




                                {{-- old input field --}}

                                {{-- <div class="col-12 col-md-6 mt-3">
									<label>Purchase Price</label>
									<input type="number" class="form-control" name="purchase_price" id="purchase_price" placeholder="Purchase Price" readonly>
								</div> --}}




                                {{-- <div class="col-12 col-md-6 mt-3">
									<label>Unit Price</label>
									<input onchange="calculateTotal()" type="number" class="form-control" name="unit_price" id="unit_price" placeholder="Unit Price" required>
								</div>
								<div class="col-12 col-md-6 mt-3">
									<label>Qty</label>
									<input onchange="calculateTotal()" type="number" class="form-control" name="qty" id="qty" placeholder="Qty" required>
								</div>
								<div class="col-12 col-md-6 mt-3">
									<label>Total Price</label>
									<input type="number" class="form-control" name="total_price" id="total_price" placeholder="Total Price" readonly>
								</div> --}}

                                {{-- old input field --}}



                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn create-btn">Add To Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>






                {{--					start cart.blade.php --}}


                <div class="col-12  pt-3">
                    {!! $cartHtml !!}

                    @if (session('cart') && count(session('cart')) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>

                                    {{-- <th>Unit</th> --}}
                                    {{-- <th>Size</th> --}}
                                    {{-- <th>Color</th> --}}

                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach (session('cart') as $key => $item)
                                    <tr>
                                        <td>{{ $item['product_name'] }}</td>

                                        {{-- <td>{{ $item['unit_name'] }}</td> --}}
                                        {{-- <td>{{ $item['size_name'] }}</td>
                                    {{--  <td>{{ $item['color_name'] }}</td> --}}


                                        <td>{{ $item['quantity'] }}</td>
                                        <td>{{ $item['unit_price'] }}</td>
                                        <td>{{ $item['quantity'] * $item['unit_price'] }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove_item') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="cart_key" value="{{ $key }}">
                                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                            </form>
                                        </td>
                                        @php $total += ($item['quantity'] * $item['unit_price']); @endphp
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Sub Total</td>
                                    <td>{{ $total }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align: center; vertical-align: middle;">Discount</td>


                                    <td>
                                        <input onchange="orderCaculation({{ $total }})" id="discount_editable"
                                            class="form-control" type="number">
                                    </td>

                                    {{-- <td>
    <input onchange="applyDiscount()" id="discount_editable" class="form-control" type="number" min="0" max="100" placeholder="Enter discount" />
</td> --}}

                                </tr>
                                <tr class="d-none">
                                    <td colspan="5"></td>
                                    <td>Grand Total</td>
                                    <td id="grand_total_show">{{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <form action="{{ route('sales.store') }}" method="post">
                            @csrf
                            <input id="discount" name="discount" class="form-control" type="hidden">
                            <div class="row mt-5">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Grand Total <span class="text-danger">*</span></label>
                                        <input type="number" id="grand_total" name="grand_total" step="0.01"
                                            class="form-control p-2" value="{{ $total }}" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Paid Amount <span class="text-danger">*</span></label>
                                        <input onchange="orderCaculation({{ $total }})" type="number"
                                            id="paid_amount" name="paid_amount" class="form-control p-2"
                                            placeholder="Enter Paid Amount">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Due Amount <span class="text-danger">*</span></label>
                                        <input type="number" id="due_amount" name="due_amount" class="form-control p-2"
                                            value="{{ $total }}" placeholder="Enter Due Amount">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control p-2"
                                            placeholder="Enter Name" value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control p-2" name="phone" id="phone"
                                            pattern="[0-9]{11}" maxlength="11" placeholder="Enter phone number" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control p-2" placeholder="Enter Address"
                                            id="address" name="address" value="{{ old('address') }}" required>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn create-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p class="text-center display-4">No items in cart.</p>
                    @endif
                </div>


                {{--                end cart.blade.php --}}




            </div>
        </div>
    </div>





    <div class="card mb-3 d-none">
        <div class="card-body">
            <!-- Page Header -->

            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group-item mb-0 pb-0">
                        <h5 class="form-title d-none">Basic Details</h5>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control p-2"
                                        placeholder="Enter Name" value="{{ old('name') }}" required
                                        autocomplete="off">
                                </div>
                            </div>



                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control p-2" name="phone" id="phone"
                                        pattern="[0-9]{11}" maxlength="11" placeholder="Enter phone number" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control p-2" placeholder="Enter Address"
                                        id="address" name="address" value="{{ old('address') }}" required
                                        autocomplete="off">
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="card mb-0 d-none">
        <div class="card-body">
            <!-- Page Header -->

            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">







                    <div class="group-item" data-itemnumber="1" id="form-group-item1"
                        style="background:#198754; color:#fff !important; padding: 10px 5px;">
                        <!-- <table>
                                             <tr>
                                              <td><label style="color:#fff !important;">Product Name</label></td>
                                              <td><label style="color:#fff !important;">Warranty</label></td>
                                              <td><label style="color:#fff !important;"> Purchase Price</label></td>
                                              <td><label style="color:#fff !important;"> Unit Price</label></td>
                                              <td><label style="color:#fff !important;">Qty</label></td>
                                              <td><label style="color:#fff !important;">Total</label></td>
                                              <td></td>
                                             </tr>
                                             <tr>
                                              <td>
                                               <select onchange="selectProduct(1)" id="product1" class="form-control js-example-basic-single" style="height: 30px;" required>
                                                <option value=""></option>


                                {{-- now extra products --}}

                                {{--                @foreach ($products as $product) --}}
                                {{--                    --}}
                                {{--    <option value="{{ $product->id }}" data-name="{{ $product->name }}({{ $product->model }})" data-price="{{ $product->latestPurchase->unit_price ?? 0 }}"> --}}
                                {{--    --}}
                                {{--                  {{ $product->name }}({{ $product->model }}) --}}
                                {{--                 </option> --}}
                                {{--    @endforeach --}}

                                {{-- now extra products --}}


                                               </select>
                                              </td>
                                              <td>
                                               <input type="number" id="Warranty" style="height: 30px;" class="form-control Warranty" >
                                              </td>
                                              <td>
                                               <input type="number" id="purchase_price1" style="height: 30px;" class="form-control" readonly>
                                              </td>
                                              <td>
                                               <input onchange="calculateTotal()" type="number" id="unit_price1" style="height: 30px;" class="form-control unit-price" >
                                              </td>
                                              <td>
                                               <input onchange="calculateTotal()" type="number" id="qty1" style="height: 30px;" class="form-control qty" min="0">
                                              </td>
                                              <td>
                                               <input type="number" id="total1" style="height: 30px;" class="form-control total" readonly>
                                              </td>
                                              <td>
                                               <button onclick="addItem()"  type="button" class=" btn btn-primary addItemBtn">Add</button>
                                              </td>
                                             </tr>
                                            </table> -->

                        <style>
                            @media (min-width: 768px) {
                                .col-md-2 {
                                    width: 13% !important;
                                    padding-left: 5px;
                                    padding-right: 5px;
                                }
                            }
                        </style>

                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label style="color:#fff !important;">Product Name</label>
                                <select onchange="selectProduct(1)" id="product1"
                                    class="form-control js-example-basic-single" style="height: 30px;" required>
                                    <option value=""></option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            data-name="{{ $product->name }}({{ $product->model }})"
                                            data-price="{{ $product->latestPurchase->unit_price ?? 0 }}"
                                            data-warranty="{{ $product->warranty ?? 0 }}">
                                            {{ $product->name }}({{ $product->model }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label style="color:#fff !important;"> Warranty</label>
                                <input type="number" id="warranty1" style="height: 30px;" class="form-control"
                                    readonly>
                            </div>
                            {{-- <div class="col-md-2">
                                <label style="color:#fff !important;"> Purchase Price</label>
                                <input type="number" id="purchase_price1" style="height: 30px;" class="form-control"
                                    readonly>
                            </div> --}}
                            <div class="col-md-2">
                                <label style="color:#fff !important;"> Unit Price</label>
                                <input onchange="calculateTotal()" type="number" id="unit_price1" style="height: 30px;"
                                    class="form-control unit-price">
                            </div>
                            <div class="col-md-2">
                                <label style="color:#fff !important;">Qty</label>
                                <input onchange="calculateTotal()" type="number" id="qty1" style="height: 30px;"
                                    class="form-control qty" min="0">
                            </div>
                            <div class="col-md-2">
                                <label style="color:#fff !important;">Total</label>
                                <input type="number" id="total1" style="height: 30px;" class="form-control total"
                                    readonly>
                            </div>
                            <div class="col-md-1 text-end btn-holder">
                                <button onclick="addItem()" type="button"
                                    class=" btn btn-primary addItemBtn">Add</button>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="" style="color:#000 !important;">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label style="color:#000 !important;">Product Name</label>
                            </div>
                            <div class="col-md-2">
                                <label style="color:#000 !important;"> Unit Price</label>
                            </div>
                            <div class="col-md-2">
                                <label style="color:#000 !important;">Qty</label>
                            </div>
                            <div class="col-md-2">
                                <label style="color:#000 !important;">Total</label>
                            </div>
                            <div class="col-md-1 text-end btn-holder">
                            </div>
                        </div>
                    </div>
                    <div id="item_container">

                    </div>
                    <hr>

                    <br>
                    <div id="summerySection" class="row d-flef justify-content-end align-items-end d-none">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <label>Sub Total</label>
                            <input onchange="calculateTotal()" type="number" id="subTotal" name="subTotal"
                                style="height: 30px;" class="form-control total" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Discount</label>
                            <input onchange="calculateTotal()" type="number" id="discount" name="discount"
                                style="height: 30px;" class="form-control total">
                        </div>
                        <div class="col-md-2">
                            <label>Grand Total</label>
                            <input type="number" id="grandTotal" name="grandTotal" style="height: 30px;"
                                class="form-control total" readonly>
                        </div>
                        <div class="col-md-2 text-end btn-holder">

                        </div>
                    </div>

                    <div class="add-customer-btns text-left">
                        <button type="submit" class="btn customer-btn-save">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </div>





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        function reloadAfterSubmit() {
            setTimeout(function() {
                window.location.reload();
            }, 500); // give it some time to finish submission
        }
    </script>






    {{-- 

<script>

	function orderCaculation(total){
		var discount = document.getElementById('discount_editable').value;
		if(discount<0){
			discount = 0;
			document.getElementById('discount_editable').value = 0;
		}
		
		var paid_amount = document.getElementById('paid_amount').value;
		if(paid_amount<0){
			paid_amount = 0;
			document.getElementById('paid_amount').value = 0;
		}

		var grandTotal = Math.max((total - discount), 0);
		var due = Math.max((grandTotal - paid_amount), 0);

		document.getElementById('discount').value = discount;
		document.getElementById('grand_total').value = grandTotal;
		document.getElementById('due_amount').value = due;
		document.getElementById('grand_total_show').innerHTML = Math.max((total - discount), 0);
	}

function filterProduct(ele){
	var categoryId = ele.value;
	var eles = document.getElementsByClassName('category');

	for(var i=0; i<eles.length; i++){
		if(!eles[i].classList.contains('category'+categoryId)){
			eles[i].classList.add('d-none');
		}else{
			eles[i].classList.remove('d-none');
		}
	}
}

	// function loadSizeAndColor(e) {
	// 	e.preventDefault(); 
	// 	var product = document.getElementById('product').value;
	// 	if(product == ""){
	// 		document.getElementById('product').setCustomValidity("Product is required");
	// 		document.getElementById('product').reportValidity();
	// 		return;
	// 	}


		
	// 	$.get("{{ route('products.getSizeAndColor') }}", { product: product }, function(data) {
	// 		$('#size').empty().append('<option value="">Select Size</option>');
	// 		$('#color').empty().append('<option value="">Select Color</option>');

	// 		if (data.sizes && data.sizes.length > 0) {
	// 			data.sizes.forEach(function(size) {
	// 				$('#size').append('<option value="' + size.id + '">' + size.name + '</option>');
	// 			});
	// 		}

	// 		if (data.colors && data.colors.length > 0) {
	// 			data.colors.forEach(function(color) {
	// 				$('#color').append('<option value="' + color.id + '">' + color.name + '</option>');
	// 			});
	// 		}
	// 	});

		
	}






	function productDetails(e) {
		e.preventDefault(); 
		var product = document.getElementById('product').value;
		// var size = document.getElementById('size').value;
		// var color = document.getElementById('color').value;

		document.getElementById('purchase_price').value = 0;

		if (product === "") {
			// document.getElementById('product').setCustomValidity("Product is required");
			// document.getElementById('product').reportValidity();
			// alert("Product is required");
			return;
		}
		if (size === "") {
			// document.getElementById('size').setCustomValidity("Size is required");
			// document.getElementById('size').reportValidity();
			// alert("Size is required");
			return;
		}
		if (color === "") {
			// document.getElementById('color').setCustomValidity("Color is required");
			// document.getElementById('color').reportValidity();
			// alert("Color is required");
			// return;
		}

		// Submit or process data (AJAX or form submission)
		// console.log("Product:", product, "Size:", size, "Color:", color);

		// Example if you want to post via AJAX:
		$.get("{{ route('products.details') }}", {
			product_id: product,
			size_id: size,
			color_id: color
		}, function(data) {
			document.getElementById('purchase_price').value = data.lastPurchase.unit_price;
		});
	}

	function calculateTotal() {
		let unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
		let qty = parseInt(document.getElementById('qty').value) || 0;
		document.getElementById('total_price').value = (unitPrice * qty).toFixed(2);
	}

</script>

 --}}






















    {{-- Nayeem JavaScript Code --}}


    {{-- Start Auto-calculate total price based on unit price and qty --}}

    <script>
        // Calculate product total (unit price * quantity)
        function calculateTotal() {
            let unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
            let qty = parseInt(document.getElementById('qty').value) || 0;
            document.getElementById('total_price').value = (unitPrice * qty).toFixed(2);
        }

        // Set unit price automatically when product is selected
        function loadUnitPrice(event) {
            let selectedOption = event.target.selectedOptions[0];
            let price = selectedOption.getAttribute('data-price') || 0;
            document.getElementById('unit_price').value = price;
            calculateTotal(); // auto-calculate after price loads
        }

        // Filter products by selected category
        function filterProduct(ele) {
            let categoryId = ele.value;
            let options = document.getElementsByClassName('category');

            for (let i = 0; i < options.length; i++) {
                if (!options[i].classList.contains('category' + categoryId)) {
                    options[i].classList.add('d-none');
                } else {
                    options[i].classList.remove('d-none');
                }
            }
        }

        // Calculate order totals including discount and due amount
        function orderCaculation(total) {
            // Get input values
            let discount = parseFloat(document.getElementById('discount_editable').value) || 0;
            let paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;

            // Validate discount (can't be negative)
            if (discount < 0) {
                discount = 0;
                document.getElementById('discount_editable').value = 0;
            }

            // Validate paid amount (can't be negative)
            if (paidAmount < 0) {
                paidAmount = 0;
                document.getElementById('paid_amount').value = 0;
            }

            // Calculate grand total (subtotal - discount)
            let grandTotal = Math.max((total - discount), 0);

            // Calculate due amount (grand total - paid amount)
            let dueAmount = Math.max((grandTotal - paidAmount), 0);

            // Update all fields
            document.getElementById('discount').value = discount;
            document.getElementById('grand_total').value = grandTotal;
            document.getElementById('due_amount').value = dueAmount;
            document.getElementById('grand_total_show').innerHTML = grandTotal;
        }

        // Initialize calculation when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Get the initial subtotal from the cart table
            let subtotal = 0;
            const subtotalElement = document.querySelector('table tbody tr:last-child td:nth-child(4)');
            if (subtotalElement) {
                subtotal = parseFloat(subtotalElement.textContent) || 0;
            }

            // Set up event listeners for discount and payment fields
            document.getElementById('discount_editable')?.addEventListener('input', function() {
                orderCaculation(subtotal);
            });

            document.getElementById('paid_amount')?.addEventListener('input', function() {
                orderCaculation(subtotal);
            });
        });
    </script>

    {{-- End Auto-calculate total price based on unit price and qty --}}






    {{-- Start Filtering for when select category auto select category wise product --}}

    <script>
        function filterProduct(categorySelect) {
            const selectedCategoryId = categorySelect.value;
            const productSelect = document.getElementById('product');
            const productOptions = productSelect.options;
            const stockInput = document.getElementById('product_stock');

            let found = false;

            for (let i = 0; i < productOptions.length; i++) {
                const option = productOptions[i];
                const categoryId = option.getAttribute('data-category-id');

                // Always show the placeholder option
                if (option.value === "") {
                    option.hidden = false;
                    continue;
                }

                // Check if the product belongs to selected category
                if (!selectedCategoryId || categoryId === selectedCategoryId) {
                    option.hidden = false;
                    found = true;
                } else {
                    option.hidden = true;
                }
            }

            // Reset product dropdown
            productSelect.value = "";

            if (!found && selectedCategoryId) {
                stockInput.value = "No product found!";
                stockInput.style.color = 'red';
                stockInput.style.borderColor = '#dc3545'; // Bootstrap red
            } else {
                stockInput.value = "";
                stockInput.style.color = '';
                stockInput.style.borderColor = '';
            }
        }
    </script>


    {{-- End Filtering for when select category auto select category wise product --}}






    {{-- Start stock --}}

    {{-- auto count stock Qty based on product select and not found with danger color set --}}

    <script>
        function setStock() {
            const input = document.getElementById('product_stock');
            const selectedOption = document.querySelector('#product').selectedOptions[0];
            const stock = selectedOption.getAttribute('data-stock');

            if (stock === null || stock === "0") {
                input.value = "Stock not found!";
                input.style.color = 'red'; // Red text
                input.style.borderColor = '#dc3545'; // Bootstrap danger border
            } else {
                input.value = stock;
                input.style.color = ''; // Reset color
                input.style.borderColor = ''; // Reset border
            }
        }
    </script>

    {{-- End stock --}}


    {{-- Select2 Initialization --}}
    <script>
        $(document).ready(function() {
            // Initialize Select2 on product dropdown
            $('#product').select2({
                placeholder: 'Select Product',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

@endsection
