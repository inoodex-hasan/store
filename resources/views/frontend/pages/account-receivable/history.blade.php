@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Payment History for {{ $customer->name }}</h5>
                <a href="{{ route('account-receivable.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Phone:</strong> {{ $customer->phone }} | <strong>Address:</strong> {{ $customer->address }}
                </div>

                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Payment Date</th>
                                    <th>Amount (৳)</th>
                                    <th>Payment Method</th>
                                    <th>Sale Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $index => $payment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                                        <td><span class="badge-status success">{{ number_format($payment->amount, 2) }}</span></td>
                                        <td>{{ ucfirst($payment->payment_method) ?? 'N/A' }}</td>
                                        <td>
                                            @if($payment->sale_id)
                                                <a href="{{ route('sales.invoice', $payment->sale_id) }}" target="_blank" class="btn btn-sm btn-outline-primary">View Invoice</a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mt-3">No payment records found for this customer.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
