@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        @include('layouts.flash-message')
        @if ($errors->any())
            <div class="alert alert-danger" id="validation-error-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>setTimeout(function(){var e=document.getElementById('validation-error-alert');if(e)e.style.display='none';},3000);</script>
        @endif
        <div class="modern-card">
            <div class="card-header">
                <h5>Edit Payment #{{ $payment->id }}</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-light btn-sm text-dark">Back to Payments</a>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Sale ID <span class="text-danger">*</span></label>
                            <input type="number" name="sale_id" class="form-control" value="{{ old('sale_id', $payment->sale_id) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Customer ID <span class="text-danger">*</span></label>
                            <input type="number" name="customer_id" class="form-control" value="{{ old('customer_id', $payment->customer_id) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Method</label>
                            <input type="text" name="payment_method" class="form-control" value="{{ old('payment_method', $payment->payment_method) }}" placeholder="Cash, Card, Bank Transfer etc.">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Update Payment</button>
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
