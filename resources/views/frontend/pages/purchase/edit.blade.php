@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Edit Purchase</h5>
                <a href="{{ route('purchase.index') }}" class="btn btn-light btn-sm text-dark float-end">
                    <i class="fa fa-arrow-left"></i> Back to List
                </a>
            </div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('purchase.update', $purchase->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-select" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $product->id == $purchase->product_id ? 'selected' : '' }}>
                                        {{ $product->name }}({{ $product->model ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Vendor <span class="text-danger">*</span></label>
                            <select name="vendor_id" class="form-select" required>
                                <option value="">Select Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ $vendor->id == $purchase->vendor_id ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="{{ $purchase->quantity }}"
                                class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Unit Price</label>
                            <input type="number" step="0.01" name="unit_price" id="unit_price"
                                value="{{ $purchase->unit_price }}" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sub Price</label>
                            <input type="number" step="0.01" name="sub_price" id="sub_price"
                                value="{{ $purchase->sub_price }}" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Total Price</label>
                            <input type="number" step="0.01" name="total_price" id="total_price"
                                value="{{ $purchase->total_price }}" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Payment</label>
                            <input type="number" step="0.01" name="payment" id="payment"
                                value="{{ $purchase->payment }}" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Due</label>
                            <input type="number" step="0.01" name="due" id="due"
                                value="{{ $purchase->due }}" class="form-control" readonly>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            <a href="{{ route('purchase.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qty = document.getElementById('quantity');
            const up = document.getElementById('unit_price');
            const sp = document.getElementById('sub_price');
            const tp = document.getElementById('total_price');
            const pm = document.getElementById('payment');
            const du = document.getElementById('due');
            let manualPay = false;

            function calc() {
                const q = parseFloat(qty.value) || 0;
                const u = parseFloat(up.value) || 0;
                const sub = q * u;
                sp.value = sub.toFixed(2);
                tp.value = sub.toFixed(2);
                if (!manualPay) pm.value = sub.toFixed(2);
                calcDue();
            }

            function calcDue() {
                const t = parseFloat(tp.value) || 0;
                const p = parseFloat(pm.value) || 0;
                du.value = (t - p).toFixed(2);
            }

            qty.addEventListener('input', calc);
            up.addEventListener('input', calc);
            pm.addEventListener('input', function() { manualPay = true; calcDue(); });
            tp.addEventListener('input', calcDue);

            $('#product_id').select2({
                placeholder: 'Select Product',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
