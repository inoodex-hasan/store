@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Accounts Receivable List</h5>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('account-receivable.index') }}" method="GET" class="row g-2">
                        <div class="col-md-4 p-1">
                            <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control form-control-sm" placeholder="Search by customer name">
                        </div>
                        <div class="col-md-3 p-1">
                            <input type="number" name="due_amount" value="{{ request('due_amount') }}" class="form-control form-control-sm" placeholder="Minimum Due Amount">
                        </div>
                        <div class="col-md-3 d-flex align-items-center gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <a href="{{ route('account-receivable.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name (কাস্টমার নাম)</th>
                                <th>Total Due (মোট বকেয়া)</th>
                                <th>Last Updated (লাস্ট আপডেটেড)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receivables as $index => $item)
                                <tr>
                                    <td>{{ $receivables->firstItem() + $index }}</td>
                                    <td>{{ $item->customer->name ?? 'Unknown' }}</td>
                                    <td><span class="badge-status danger">{{ number_format($item->due_amount, 2) }}</span></td>
                                    <td>{{ $item->updated_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('receivables.history', $item->customer_id) }}"><i class="far fa-clock"></i> Payment History</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No accounts receivable found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($receivables->hasPages())
                    <div class="modern-pagination">
                        {{ $receivables->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
