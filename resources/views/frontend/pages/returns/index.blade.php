@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Product Returns</h5>
                <a href="{{ route('returns.create') }}" class="btn btn-light btn-sm text-dark float-end">
                    <i class="fa fa-plus-circle"></i> New Return
                </a>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form method="GET" action="{{ route('returns.index') }}">
                        <div class="row g-2">
                            <div class="col-md-3 p-1">
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Search (ID, Order, Customer)" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 p-1">
                                <select name="status" class="form-select form-select-sm">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-2 p-1">
                                <select name="customer_id" class="form-select form-select-sm">
                                    <option value="">All Customers</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 p-1">
                                <input type="date" name="date_from" class="form-control form-control-sm" placeholder="From Date"
                                    value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2 p-1">
                                <input type="date" name="date_to" class="form-control form-control-sm" placeholder="To Date"
                                    value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Return Date</th>
                                <th>Order No</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Refund Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returns as $return)
                                <tr>
                                    <td>{{ $return->id }}</td>
                                    <td>{{ $return->return_date->format('d M Y') }}</td>
                                    <td>
                                        @if($return->sale)
                                            <a href="javascript:void(0)" class="text-decoration-none">
                                                {{ $return->sale->order_no }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $return->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $return->items->count() }} items</td>
                                    <td>{{ number_format($return->total_refund_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $badgeClass = [
                                                'pending' => 'warning',
                                                'approved' => 'info',
                                                'completed' => 'success',
                                                'rejected' => 'danger'
                                            ][$return->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge-status {{ $badgeClass }}">{{ ucfirst($return->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('returns.show', $return->id) }}">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                                @if($return->isPending())
                                                    <form method="POST" action="{{ route('returns.approve', $return->id) }}"
                                                        class="d-inline" onsubmit="return confirm('Approve this return?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item text-success w-100">
                                                            <i class="far fa-check-circle"></i> Approve
                                                        </button>
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $return->id }}">
                                                        <i class="far fa-times-circle"></i> Reject
                                                    </a>
                                                @endif
                                                @if($return->isApproved())
                                                    <form method="POST" action="{{ route('returns.complete', $return->id) }}"
                                                        class="d-inline" onsubmit="return confirm('Complete return and update stock?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item text-primary w-100">
                                                            <i class="fas fa-box"></i> Complete & Update
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($return->isPending() || $return->isRejected())
                                                    <div class="dropdown-divider"></div>
                                                    <form method="POST" action="{{ route('returns.destroy', $return->id) }}"
                                                        class="d-inline" onsubmit="return confirm('Delete this return?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger w-100">
                                                            <i class="far fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        @if($return->isPending())
                                            <div class="modal fade" id="rejectModal{{ $return->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('returns.reject', $return->id) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-header" style="background: #e94134; color: #fff;">
                                                                <h5 class="modal-title" style="color: #fff;">Reject Return #{{ $return->id }}</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Rejection Reason</label>
                                                                    <textarea name="reason" class="form-control" rows="3"
                                                                        placeholder="Enter reason for rejection" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Reject Return</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No returns found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($returns->hasPages())
                    <div class="modern-pagination">
                        {{ $returns->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
