@extends('frontend.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header cat-head">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Payments List</h5>
                    <a href="{{ route('payments.create') }}" class="btn create-btn-outline">Add New Payment</a>
                </div>

                <div class="card mb-3 p-3">
                    <form action="{{ route('payments.index') }}" method="GET" class="row g-2">



                        <!-- Sale -->
                        {{-- <div class="col-md-2">
                            <select name="sale_id" class="form-select">
                                <option value="">All Sales</option>
                                @foreach ($sales as $sale)
                                    <option value="{{ $sale->id }}"
                                        {{ request('sale_id') == $sale->id ? 'selected' : '' }}>
                                        {{ $sale->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="col-md-2">
                            <input type="text" name="customer_name" value="{{ request('customer_name') }}"
                                class="form-control" placeholder="Search customer by name">
                        </div>

                        {{-- <!-- Customer -->
                        <div class="col-md-2">
                            <select name="customer_id" class="form-select">
                                <option value="">All Customers</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <!-- Amount -->
                        <div class="col-md-2">
                            <input type="number" name="amount" value="{{ request('amount') }}" class="form-control"
                                placeholder="Amount">
                        </div>

                        <!-- Payment Date -->
                        <div class="col-md-2">
                            <input type="date" name="payment_date" value="{{ request('payment_date') }}"
                                class="form-control">
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-2">
                            <select name="payment_method" class="form-select">
                                <option value="">All Methods</option>
                                @foreach ($methods as $method)
                                    <option value="{{ $method }}"
                                        {{ request('payment_method') == $method ? 'selected' : '' }}>
                                        {{ $method }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Filter Button First -->
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>

                        <!-- Reset Button Last -->
                        <div class="col-md-2 d-flex align-items-center">
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>

                    </form>
                </div>


                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Sale ID (সেল আইডি)</th>
                            <th>Customer ID (কাস্টমার আইডি)</th>
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
                                <td>{{ $payment->customer->name }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</td>
                                <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('payments.edit', $payment->id) }}"
                                        class="btn create-btn text-light"><i class="fa-solid fa-pen-to-square"></i></a>
                                    {{-- <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-success">Show</a> --}}

                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this payment?')"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->

                <div class="d-flex justify-content-end mt-4">
                    {!! $payments->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        @endsection
