@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        @include('layouts.flash-message')
        <div class="modern-card">
            <div class="card-header">
                <h5>Due Payment</h5>
                <a href="{{ route('account-receivable.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
            </div>
            <div class="card-body p-3">
                @if($accountReceivable && $accountReceivable->customer)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Customer:</strong> {{ $accountReceivable->customer->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Due Amount:</strong> <span class="badge-status danger">{{ $accountReceivable->due_amount ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="modern-card mb-4">
                        <div class="card-header">
                            <h5>Make Payment</h5>
                        </div>
                        <div class="card-body p-3">
                            <form action="{{ route('accounts_receivable.payment') }}" method="POST" class="row g-3">
                                @csrf
                                <input type="hidden" name="customer_id" value="{{ $accountReceivable->customer_id }}">
                                <div class="col-md-6">
                                    <label class="form-label">Payment Amount</label>
                                    <input type="number" name="amount" class="form-control" min="1" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Method</label>
                                    <input type="text" name="payment_method" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Pay</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modern-card">
                        <div class="card-header">
                            <h5>Payment History</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>Payment Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                                                <td><span class="badge-status success">{{ $payment->amount }}</span></td>
                                                <td>{{ $payment->payment_method }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No payment history found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">No account receivable data found for this customer.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
