@extends('frontend.layouts.app')

@section('content')
<div class="container">

    @if($accountReceivable && $accountReceivable->customer)
        <h3>Due Amount for Customer: {{ $accountReceivable->customer->name }}</h3>
        <p><strong>Due Amount:</strong> {{ $accountReceivable->due_amount ?? 0 }}</p>

        <h4>Make Payment</h4>
        <form action="{{ route('accounts_receivable.payment') }}" method="POST">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $accountReceivable->customer_id }}">

            <div class="form-group">
                <label for="amount">Payment Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" min="1" required>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Pay</button>
        </form>

        <h4 class="mt-4">Payment History</h4>
        <table class="table table-bordered">
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
                        <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->payment_method }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No payment history found.</td></tr>
                @endforelse
            </tbody>
        </table>
    @else
        <div class="alert alert-danger">No account receivable data found for this customer.</div>
    @endif

</div>
@endsection
