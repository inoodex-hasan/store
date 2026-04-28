@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">
    <h2>Payment History for <strong>{{ $customer->name }}</strong></h2>
    <p><strong>Phone:</strong> {{ $customer->phone }} | <strong>Address:</strong> {{ $customer->address }}</p>

    @if($payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mt-3">
                <thead class="table-secondary">
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
                            <td class="text-success fw-bold">{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucfirst($payment->payment_method) ?? 'N/A' }}</td>
                            <td>
                                @if($payment->sale_id)
                                    <a href="{{ route('sales.invoice', $payment->sale_id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        View Invoice
                                    </a>
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
        <div class="alert alert-info mt-4">
            No payment records found for this customer.
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
