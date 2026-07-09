@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="modern-card mb-3">
            <div class="card-header">
                <h5>Return Details #{{ $return->id }}</h5>
                <a href="{{ route('returns.index') }}" class="btn btn-light btn-sm text-dark float-end">
                    <i class="fa fa-arrow-left"></i> Back to List
                </a>
            </div>
            <div class="card-body p-3">
                @php
                    $statusConfig = [
                        'pending' => ['class' => 'warning', 'icon' => 'clock', 'msg' => 'This return is pending approval'],
                        'approved' => ['class' => 'info', 'icon' => 'check', 'msg' => 'Return approved. Waiting for stock update.'],
                        'completed' => ['class' => 'success', 'icon' => 'check-double', 'msg' => 'Return completed and stock updated.'],
                        'rejected' => ['class' => 'danger', 'icon' => 'times', 'msg' => 'Return was rejected.']
                    ][$return->status] ?? ['class' => 'secondary', 'icon' => 'question', 'msg' => 'Unknown status'];
                @endphp
                <div class="alert alert-{{ $statusConfig['class'] }} d-flex align-items-center mb-3 py-2">
                    <i class="fas fa-{{ $statusConfig['icon'] }} me-3 fa-lg"></i>
                    <div>
                        <strong>Status: {{ ucfirst($return->status) }}</strong><br>
                        <small>{{ $statusConfig['msg'] }}</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless modern-table" style="border: none;">
                            <tr>
                                <td class="fw-bold" style="width:40%; border: none;">Return ID:</td>
                                <td style="border: none;">#{{ $return->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="border: none;">Return Date:</td>
                                <td style="border: none;">{{ $return->return_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="border: none;">Created At:</td>
                                <td style="border: none;">{{ $return->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="border: none;">Total Refund:</td>
                                <td style="border: none;" class="fw-bold" style="color: #e94134;">{{ number_format($return->total_refund_amount, 2) }}</td>
                            </tr>
                            @if($return->reason)
                                <tr>
                                    <td class="fw-bold" style="border: none;">Reason:</td>
                                    <td style="border: none;">{{ $return->reason }}</td>
                                </tr>
                            @endif
                            @if($return->notes)
                                <tr>
                                    <td class="fw-bold" style="border: none;">Notes:</td>
                                    <td style="border: none;">{{ $return->notes }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless modern-table" style="border: none;">
                            <tr>
                                <td class="fw-bold" style="width:40%; border: none;">Order No:</td>
                                <td style="border: none;">
                                    @if($return->sale)
                                        #{{ $return->sale->order_no }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="border: none;">Customer:</td>
                                <td style="border: none;">{{ $return->customer->name ?? 'N/A' }}</td>
                            </tr>
                            @if($return->customer && $return->customer->phone)
                                <tr>
                                    <td class="fw-bold" style="border: none;">Phone:</td>
                                    <td style="border: none;">{{ $return->customer->phone }}</td>
                                </tr>
                            @endif
                            @if($return->processedBy)
                                <tr>
                                    <td class="fw-bold" style="border: none;">Processed By:</td>
                                    <td style="border: none;">{{ $return->processedBy->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="border: none;">Processed At:</td>
                                    <td style="border: none;">{{ $return->processed_at?->format('d M Y H:i') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <h6 class="fw-bold mb-2 mt-3">Returned Items</h6>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Reason</th>
                                <th>Condition</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($return->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ number_format($item->total_price, 2) }}</td>
                                    <td><span class="badge-status info">{{ $item->reason_label }}</span></td>
                                    <td>
                                        @php
                                            $conditionColors = ['good' => 'success', 'damaged' => 'warning', 'defective' => 'danger'];
                                        @endphp
                                        <span class="badge-status {{ $conditionColors[$item->condition] ?? 'secondary' }}">
                                            {{ $item->condition_label }}
                                        </span>
                                    </td>
                                    <td>{{ $item->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: #fef9f8;">
                                <td colspan="4" class="text-end fw-bold">Total Refund:</td>
                                <td colspan="4" class="fw-bold" style="color: #e94134;">{{ number_format($return->total_refund_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($return->isPending() || $return->isApproved())
                    <div class="mt-3 pt-3" style="border-top: 1px solid #f5e6e4;">
                        <h6 class="fw-bold mb-2">Actions</h6>
                        <div class="d-flex gap-2">
                            @if($return->isPending())
                                <form method="POST" action="{{ route('returns.approve', $return->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this return?')">
                                        <i class="fas fa-check me-2"></i>Approve Return
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times me-2"></i>Reject Return
                                </button>
                            @endif
                            @if($return->isApproved())
                                <form method="POST" action="{{ route('returns.complete', $return->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Complete return and update stock?')">
                                        <i class="fas fa-box me-2"></i>Complete & Update Stock
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($return->isPending())
        <div class="modal fade" id="rejectModal" tabindex="-1">
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
                                <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                                <textarea name="reason" class="form-control" rows="3" placeholder="Enter reason for rejection" required></textarea>
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
@endsection
