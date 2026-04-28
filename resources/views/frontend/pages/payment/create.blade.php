@extends('frontend.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header cat-head align-items-center d-flex justify-content-between">
                <h5 class="card-title fw-bold ">Add New Payment</h5>
                <div class="flex-shrink-0">
                    <a href="{{ route('payments.index') }}" class="btn create-btn-outline mb-3">Back to Payments</a>
                </div>
            </div>

            @if (session('alert'))
                <script>
                    alert("{{ session('alert') }}");
                </script>
            @endif


            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Please fix the following errors:<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="sale_id" class="form-label">Sale ID (সেল আইডি)</label>
                        <input type="number" name="sale_id" id="sale_id" class="form-control"
                            value="{{ old('sale_id') }}">
                    </div>

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Select Customer (সিলেক্ট কাস্টমার)</label>
                        <select name="customer_id" id="customer_id" class="form-select" required>
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->phone }} - {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- New Due Payment Field --}}
                    <div class="mb-3">
                        <label for="due_payment" class="form-label">Due Payment (বকেয়া পেমেন্ট)</label>
                        <input type="text" id="due_payment" class="form-control" value="0" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (এমাউন্ট)<span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control"
                            value="{{ old('amount') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date (পেমেন্ট তারিখ) <span
                                class="text-danger">*</span></label>
                        <input type="date" name="payment_date" id="payment_date" class="form-control"
                            value="{{ old('payment_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method (পেমেন্ট তারিখ)</label>
                        <input type="text" name="payment_method" id="payment_method" class="form-control"
                            value="{{ old('payment_method') }}" placeholder="Cash, Card, Bank Transfer etc.">
                    </div>

                    <button type="submit" class="btn create-btn">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Ajax Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#customer_id').change(function() {
            var customerId = $(this).val();
            if (customerId) {
                $.ajax({
                    url: '/customer-due/' + customerId,
                    type: 'GET',
                    success: function(data) {
                        $('#due_payment').val(data.due_amount);
                    }
                });
            } else {
                $('#due_payment').val(0);
            }
        });
    </script>
@endsection
