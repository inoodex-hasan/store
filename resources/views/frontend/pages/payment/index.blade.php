@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        @include('layouts.flash-message')
        <div class="modern-card">
            <div class="card-header">
                <h5>Payment List</h5>
                <a href="{{ route('payments.create') }}" class="btn btn-light btn-sm text-dark"><i class="fa fa-plus-circle"></i> Add New Payment</a>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('payments.index') }}" method="GET" class="row g-2">
                        <div class="col-md-3 p-1">
                            <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control form-control-sm" placeholder="Search customer by name">
                        </div>
                        <div class="col-md-2 p-1">
                            <input type="number" name="amount" value="{{ request('amount') }}" class="form-control form-control-sm" placeholder="Amount">
                        </div>
                        <div class="col-md-2 p-1">
                            <input type="date" name="payment_date" value="{{ request('payment_date') }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 p-1">
                            <select name="payment_method" class="form-select form-select-sm">
                                <option value="">All Methods</option>
                                @foreach ($methods as $method)
                                    <option value="{{ $method }}" {{ request('payment_method') == $method ? 'selected' : '' }}>{{ $method }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-center gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sale ID (সেল আইডি)</th>
                                <th>Customer (কাস্টমার)</th>
                                <th>Amount (এমাউন্ট)</th>
                                <th>Payment Date (পেমেন্ট তারিখ)</th>
                                <th>Method (মেথড)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->sale_id }}</td>
                                    <td>{{ $payment->customer->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</td>
                                    <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('payments.edit', $payment->id) }}"><i class="far fa-edit"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deletePayment({{ $payment->id }})"><i class="far fa-trash-alt"></i> Delete</a>
                                                <form id="del{{ $payment->id }}" method="POST" action="{{ route('payments.destroy', $payment->id) }}" style="display:none">@csrf @method('DELETE')</form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($payments->hasPages())
                    <div class="modern-pagination">
                        {{ $payments->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deletePayment(id) {
            if (confirm('Are you sure you want to delete this payment?')) {
                document.getElementById('del' + id).submit();
            }
        }
    </script>
@endpush
