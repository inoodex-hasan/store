@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Create Product Return</h5>
                <a href="{{ route('returns.index') }}" class="btn btn-light btn-sm text-dark float-end">
                     Back to List
                </a>
            </div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('returns.store') }}" id="returnForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Select Sale (Order) <span class="text-danger">*</span></label>
                            <select name="sale_id" id="saleSelect" class="form-select" required>
                                <option value="">-- Select Sale --</option>
                                @foreach($sales as $s)
                                    <option value="{{ $s->id }}" {{ request('sale_id') == $s->id ? 'selected' : '' }}
                                        data-customer="{{ $s->customer_id }}">
                                        #{{ $s->order_no }} - {{ $s->customer->name ?? 'No Customer' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Return Date <span class="text-danger">*</span></label>
                            <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div id="saleItemsSection" class="mb-3 {{ $sale ? '' : 'd-none' }}">
                        <h6 class="fw-bold mb-2">Sale Items</h6>
                        <div class="table-responsive">
                            <table class="modern-table" style="border: 1px solid #f5e6e4;">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Sold Qty</th>
                                        <th>Return Qty</th>
                                        <th>Unit Price</th>
                                        <th>Return Reason</th>
                                        <th>Condition</th>
                                        <th>Notes</th>
                                        <th style="width:40px"></th>
                                    </tr>
                                </thead>
                                <tbody id="saleItemsTable">
                                    @if($sale && $saleItems)
                                        @foreach($saleItems as $item)
                                            <tr data-product-id="{{ $item->product_id }}" data-max-qty="{{ $item->quantity }}">
                                                <td>
                                                    {{ $item->product->name ?? 'N/A' }}
                                                    <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    <input type="number" name="items[{{ $loop->index }}][quantity]"
                                                        class="form-control form-control-sm qty-input" min="0" max="{{ $item->quantity }}"
                                                        value="0" style="width: 80px;">
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $loop->index }}][unit_price]"
                                                        class="form-control form-control-sm" value="{{ $item->unit_price }}" readonly>
                                                </td>
                                                <td>
                                                    <select name="items[{{ $loop->index }}][return_reason]" class="form-select form-select-sm">
                                                        <option value="damaged">Damaged</option>
                                                        <option value="wrong_item">Wrong Item</option>
                                                        <option value="customer_changed_mind">Customer Changed Mind</option>
                                                        <option value="defective">Defective</option>
                                                        <option value="expired">Expired</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="items[{{ $loop->index }}][condition]" class="form-select form-select-sm">
                                                        <option value="good">Good</option>
                                                        <option value="damaged">Damaged</option>
                                                        <option value="defective">Defective</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="items[{{ $loop->index }}][notes]"
                                                        class="form-control form-control-sm" placeholder="Notes">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="alert alert-info mt-2 py-2 small" id="noItemsMessage"
                            style="display: {{ $sale && $saleItems->count() > 0 ? 'none' : 'block' }}">
                            Select a sale to view items
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">General Return Reason / Notes</label>
                        <textarea name="reason" class="form-control" rows="2" placeholder="Enter general reason for return"></textarea>
                    </div>

                    <div class="modern-card mb-3" style="background: #fef9f8;">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Total Refund Amount:</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h4 class="mb-0" style="color: #e94134;" id="totalRefund">0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('returns.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Create Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const saleSelect = document.getElementById('saleSelect');
        const saleItemsSection = document.getElementById('saleItemsSection');
        const saleItemsTable = document.getElementById('saleItemsTable');
        const noItemsMessage = document.getElementById('noItemsMessage');
        const totalRefundEl = document.getElementById('totalRefund');

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('#saleItemsTable tr').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input')?.value || 0);
                const price = parseFloat(row.querySelector('input[name$="[unit_price]"]')?.value || 0);
                if (qty > 0) {
                    total += qty * price;
                }
            });
            totalRefundEl.textContent = total.toFixed(2);
        }

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input')) {
                calculateTotal();
            }
        });

        function handleSaleChange() {
            const saleId = saleSelect.value;
            if (!saleId) {
                saleItemsSection.classList.add('d-none');
                return;
            }
            saleItemsTable.innerHTML = '<tr><td colspan="8" class="text-center">Loading...</td></tr>';
            saleItemsSection.classList.remove('d-none');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch(`/returns/sale-items/${saleId}`, {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
                .then(r => { if (!r.ok) throw new Error('Status: ' + r.status); return r.json(); })
                .then(data => {
                    if (data.items && data.items.length > 0) {
                        let html = '';
                        data.items.forEach((item, index) => {
                            html += `
                                <tr data-product-id="${item.product_id}" data-max-qty="${item.quantity}">
                                    <td>${item.product_name}<input type="hidden" name="items[${index}][product_id]" value="${item.product_id}"></td>
                                    <td>${item.quantity}</td>
                                    <td><input type="number" name="items[${index}][quantity]" class="form-control form-control-sm qty-input" min="0" max="${item.quantity}" value="0" style="width:80px"></td>
                                    <td><input type="number" name="items[${index}][unit_price]" class="form-control form-control-sm" value="${item.unit_price}" readonly></td>
                                    <td><select name="items[${index}][return_reason]" class="form-select form-select-sm">
                                        <option value="damaged">Damaged</option>
                                        <option value="wrong_item">Wrong Item</option>
                                        <option value="customer_changed_mind">Customer Changed Mind</option>
                                        <option value="defective">Defective</option>
                                        <option value="expired">Expired</option>
                                        <option value="other">Other</option>
                                    </select></td>
                                    <td><select name="items[${index}][condition]" class="form-select form-select-sm">
                                        <option value="good">Good</option>
                                        <option value="damaged">Damaged</option>
                                        <option value="defective">Defective</option>
                                    </select></td>
                                    <td><input type="text" name="items[${index}][notes]" class="form-control form-control-sm" placeholder="Notes"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-danger remove-item"><i class="fas fa-times"></i></button></td>
                                </tr>
                            `;
                        });
                        saleItemsTable.innerHTML = html;
                        saleItemsSection.classList.remove('d-none');
                        noItemsMessage.style.display = 'none';
                    } else {
                        saleItemsTable.innerHTML = '';
                        saleItemsSection.classList.add('d-none');
                        noItemsMessage.style.display = 'block';
                        noItemsMessage.textContent = 'No items found for this sale';
                    }
                })
                .catch(err => {
                    saleItemsTable.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error loading items: ' + err.message + '</td></tr>';
                });
        }

        saleSelect.addEventListener('change', handleSaleChange);

        document.getElementById('returnForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('#saleItemsTable tr');
            let hasValidItem = false;
            items.forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input')?.value || 0);
                if (qty > 0) hasValidItem = true;
            });
            if (!hasValidItem) {
                e.preventDefault();
                alert('Please select at least one item to return with quantity > 0');
                return false;
            }
        });
    });
</script>
@endpush
