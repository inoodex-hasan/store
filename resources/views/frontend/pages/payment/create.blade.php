@extends('frontend.layouts.app')
@section('content')
    <style>
        .select2-container { width: 100% !important; }
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            padding: 6px 12px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 6px !important;
            background: #fff !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #e94134 !important;
            box-shadow: 0 0 0 0.2rem rgba(233, 65, 52, 0.15) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px !important;
            padding-left: 0 !important;
            font-size: 14px !important;
            color: #212529 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
            top: 1px !important;
            right: 4px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }
        .select2-dropdown {
            border: 1px solid #dee2e6 !important;
            border-radius: 6px !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #dee2e6 !important;
            border-radius: 6px !important;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #e94134 !important;
        }
    </style>
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
        @if (session('alert'))
            <script>alert("{{ session('alert') }}");</script>
        @endif
        <div class="modern-card">
            <div class="card-header">
                <h5>Add New Payment</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-light btn-sm text-dark">Back to Payments</a>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Sale ID (সেল আইডি)</label>
                            <input type="number" name="sale_id" class="form-control" value="{{ old('sale_id') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Customer (কাস্টমার) <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id" class="form-select" required>
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->phone }} - {{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Due Payment (বকেয়া)</label>
                            <input type="text" id="due_payment" class="form-control" value="0" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Amount (এমাউন্ট) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Date (পেমেন্ট তারিখ) <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Method (পেমেন্ট মেথড)</label>
                            <input type="text" name="payment_method" class="form-control" value="{{ old('payment_method') }}" placeholder="Cash, Card, Bank Transfer etc.">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Submit Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="{{ asset('assets') }}/plugins/select2/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
                jQuery('#customer_id').select2({
                    placeholder: '-- Select Customer --',
                    allowClear: true,
                    width: '100%'
                });

                jQuery('#customer_id').on('change', function() {
                    var customerId = jQuery(this).val();
                    if (customerId) {
                        jQuery.ajax({
                            url: '/customer-due/' + customerId,
                            type: 'GET',
                            success: function(data) {
                                jQuery('#due_payment').val(data.due_amount);
                            }
                        });
                    } else {
                        jQuery('#due_payment').val(0);
                    }
                });
            }
        });
    </script>
@endpush
