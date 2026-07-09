@extends('frontend.layouts.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 6px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 12px !important;
        padding-right: 30px !important;
        font-size: 14px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #dee2e6 !important;
        border-radius: 6px !important;
        padding: 6px 12px;
    }

    .select2-dropdown {
        border: 1px solid #dee2e6 !important;
        border-radius: 6px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
</style>
    @csrf
    <div class="content container-fluid pt-0">

        <div class="modern-card mt-4">
            <div class="card-header">
                <h5>Create Sale</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <form action="{{ route('cart.store') }}" method="post">
                            @csrf
                            <div class="row">
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

                                <div class="col-12 col-md-4 mt-3">
                                    <label>Unit Price (ইউনিট প্রাইস)</label>
                                    <input onchange="calculateTotal()" type="number" class="form-control" name="unit_price"
                                        id="unit_price" placeholder="Unit Price" required>
                                </div>

                                <div class="col-12 col-md-4 mt-3">
                                    <label>Qty (পরিমাণ)</label>
                                    <input onchange="calculateTotal()" type="number" class="form-control" name="qty"
                                        id="qty" placeholder="Qty" required>
                                </div>

                                <div class="col-12 col-md-4 mt-3">
                                    <label>Total Price (টোটাল প্রাইস)</label>
                                    <input type="number" class="form-control" name="total_price" id="total_price"
                                        placeholder="Total Price" readonly>
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Add To Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 pt-3">
                    {!! $cartHtml !!}

                    @if (session('cart') && count(session('cart')) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
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
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p class="text-center display-4">No items in cart.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-0 d-none">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="group-item" data-itemnumber="1" id="form-group-item1"
                        style="background:#198754; color:#fff !important; padding: 10px 5px;">

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
            }, 500);
        }
    </script>

    <script>
        function calculateTotal() {
            let unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
            let qty = parseInt(document.getElementById('qty').value) || 0;
            document.getElementById('total_price').value = (unitPrice * qty).toFixed(2);
        }

        function orderCaculation(total) {
            let discount = parseFloat(document.getElementById('discount_editable').value) || 0;
            let paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;

            if (discount < 0) {
                discount = 0;
                document.getElementById('discount_editable').value = 0;
            }

            if (paidAmount < 0) {
                paidAmount = 0;
                document.getElementById('paid_amount').value = 0;
            }

            let grandTotal = Math.max((total - discount), 0);
            let dueAmount = Math.max((grandTotal - paidAmount), 0);

            document.getElementById('discount').value = discount;
            document.getElementById('grand_total').value = grandTotal;
            document.getElementById('due_amount').value = dueAmount;
            document.getElementById('grand_total_show').innerHTML = grandTotal;
        }

        document.addEventListener('DOMContentLoaded', function() {
            let subtotal = 0;
            const subtotalElement = document.querySelector('table tbody tr:last-child td:nth-child(4)');
            if (subtotalElement) {
                subtotal = parseFloat(subtotalElement.textContent) || 0;
            }

            document.getElementById('discount_editable')?.addEventListener('input', function() {
                orderCaculation(subtotal);
            });

            document.getElementById('paid_amount')?.addEventListener('input', function() {
                orderCaculation(subtotal);
            });
        });
    </script>

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

                if (option.value === "") {
                    option.hidden = false;
                    continue;
                }

                if (!selectedCategoryId || categoryId === selectedCategoryId) {
                    option.hidden = false;
                    found = true;
                } else {
                    option.hidden = true;
                }
            }

            productSelect.value = "";

            if (!found && selectedCategoryId) {
                stockInput.value = "No product found!";
                stockInput.style.color = 'red';
                stockInput.style.borderColor = '#dc3545';
            } else {
                stockInput.value = "";
                stockInput.style.color = '';
                stockInput.style.borderColor = '';
            }
        }
    </script>

    <script>
        function setStock() {
            const input = document.getElementById('product_stock');
            const selectedOption = document.querySelector('#product').selectedOptions[0];
            const stock = selectedOption.getAttribute('data-stock');

            if (stock === null || stock === "0") {
                input.value = "Stock not found!";
                input.style.color = 'red';
                input.style.borderColor = '#dc3545';
            } else {
                input.value = stock;
                input.style.color = '';
                input.style.borderColor = '';
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#product').select2({
                placeholder: 'Select Product',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <script>
        setTimeout(function() {
            let alert = document.querySelector('.alert-primary');
            if (alert) {
                alert.classList.add('fade');
                setTimeout(function() { alert.remove(); }, 300);
            }
        }, 3000);
    </script>

@endsection
