@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Purchase List</h5>
                <a class="btn btn-light btn-sm text-dark" href="{{ route('purchase.create') }}">
                    <i class="fa fa-plus-circle"></i> Add Purchase
                </a>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('purchase.index') }}" method="GET" class="row g-2">
                        <div class="col-md-3 p-1">
                            <select name="vendor_id" class="form-select form-select-sm">
                                <option value="">All Vendors</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 p-1">
                            <input type="number" name="quantity" value="{{ request('quantity') }}"
                                class="form-control form-control-sm" placeholder="Quantity">
                        </div>
                        <div class="col-md-2 p-1">
                            <input type="number" step="0.01" name="unit_price" value="{{ request('unit_price') }}"
                                class="form-control form-control-sm" placeholder="Unit Price">
                        </div>
                        <div class="col-md-3 d-flex gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('purchase.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date (তারিখ)</th>
                                <th>Product (প্রোডাক্ট)</th>
                                <th>Vendor (ভেন্ডর)</th>
                                <th>Qty (পরিমাণ)</th>
                                <th>Unit Price (ইউনিট প্রাইস)</th>
                                <th>Total Price (টোটাল)</th>
                                <th>Payment (পেমেন্ট)</th>
                                <th>Due (বাকি)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $purchase)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $purchase->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $purchase->product->name ?? 'N/A' }}({{ $purchase->product->model ?? 'N/A' }})</td>
                                    <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>{{ $purchase->unit_price }}</td>
                                    <td>{{ $purchase->total_price }}</td>
                                    <td>{{ $purchase->payment }}</td>
                                    <td>{{ $purchase->due }}</td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('purchase.edit', $purchase->id) }}">
                                                    <i class="far fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="{{ route('purchase.destroy', $purchase->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="far fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($purchases->hasPages())
                    <div class="modern-pagination">
                        {{ $purchases->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select').select2({
                placeholder: function() { return $(this).data('placeholder') || 'Select'; },
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
