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
        @if (session('error'))
            <div class="alert alert-danger" id="flash-error-alert">{{ session('error') }}</div>
            <script>setTimeout(function(){var e=document.getElementById('flash-error-alert');if(e)e.style.display='none';},3000);</script>
        @endif
        <div class="modern-card">
            <div class="card-header">
                <h5>Create Transfer Stock</h5>
                <a href="{{ route('transfer_stock.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('transfer_stock.new') }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Stock From (Warehouse) <span class="text-danger">*</span></label>
                            <select name="stock_from" id="stock_from" class="form-select" required>
                                <option value="">-- Select Warehouse --</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stock To (Shop) <span class="text-danger">*</span></label>
                            <select name="stock_to" id="stock_to" class="form-select" required {{ !$user_shop ? 'disabled' : '' }}>
                                @if ($user_shop)
                                    <option value="{{ $user_shop->id }}" selected>{{ $user_shop->location }} (Your Managed Shop)</option>
                                @else
                                    <option value="" selected disabled>-- No Shop Assigned (Contact Super Admin) --</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-select" required>
                                <option value="">-- Select Product --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <a href="{{ route('transfer_stock.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
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
        $(document).ready(function() {
            $('#product_id').select2({
                placeholder: '-- Select Product --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
