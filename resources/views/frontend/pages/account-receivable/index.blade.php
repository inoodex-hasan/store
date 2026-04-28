@extends('frontend.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header cat-head">
                <h5 class="mb-4 title">Accounts Receivable List</h1>
            </div>
            <div class="card-body">

                <div class="card mb-3 p-3">
                    <form action="{{ route('account-receivable.index') }}" method="GET" class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="customer_name" value="{{ request('customer_name') }}"
                                class="form-control" placeholder="Search by customer name">
                        </div>

                        <div class="col-md-3">
                            <input type="number" name="due_amount" value="{{ request('due_amount') }}" class="form-control"
                                placeholder="Minimum Due Amount">
                        </div>

                        <div class="col-md-2 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>

                        <div class="col-md-2 d-flex align-items-center">
                            <a href="{{ route('account-receivable.index') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>

                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Customer Name (কাস্টমার নাম)</th>
                                <th>Total Due (মোট বকেয়া)</th>
                                <th>Last Updated (লাস্ট আপডেটেড)</th>
                                <th class="text-center" style="width: 140px;">Actions (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receivables as $item)
                                <tr>
                                    <td>{{ $item->customer->name ?? 'Unknown' }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($item->due_amount, 2) }}</td>
                                    <td>{{ $item->updated_at->format('d M Y, h:i A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('receivables.history', $item->customer_id) }}"
                                            class="btn create-btn text-light" title="View Payment History">
                                            <i class="bi bi-clock-history"></i> <i class="fa-solid fa-timeline"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No accounts receivable found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {!! $receivables->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
