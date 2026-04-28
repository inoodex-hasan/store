@extends('frontend.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Payment #{{ $payment->id }}</h2>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary mb-3">Back to Payments</a>

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

    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="sale_id" class="form-label">Sale ID <span class="text-danger">*</span></label>
            <input type="number" name="sale_id" id="sale_id" class="form-control" value="{{ old('sale_id', $payment->sale_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer ID <span class="text-danger">*</span></label>
            <input type="number" name="customer_id" id="customer_id" class="form-control" value="{{ old('customer_id', $payment->customer_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" required>
        </div>

        <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ old('payment_method', $payment->payment_method) }}" placeholder="Cash, Card, Bank Transfer etc.">
        </div>

        <button type="submit" class="btn btn-primary">Update Payment</button>
    </form>
</div>
@endsection
