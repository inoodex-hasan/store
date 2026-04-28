@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="content-page-header">
                <h5 class="card-title fw-bold">Create Product Return</h5>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('returns.store') }}" id="returnForm">
                    @csrf

                    <!-- Sale Selection -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Select Sale (Order) <span class="text-danger">*</span></label>
                            <select name="sale_id" id="saleSelect" class="form-select select2" required>
                                <option value="">-- Select Sale --</option>
                                @foreach($sales as $s)
                                    <option value="{{ $s->id }}" {{ request('sale_id') == $s->id ? 'selected' : '' }}
                                        data-customer="{{ $s->customer_id }}">
                                        #{{ $s->order_no }} 
                                        - {{ $s->customer->name ?? 'No Customer' }}
                                        <!-- - ({{ $s->created_at->format('d M Y') }}) -->
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Return Date <span class="text-danger">*</span></label>
                            <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Sale Items Display -->
                    <div id="saleItemsSection" class="mb-4 {{ $sale ? '' : 'd-none' }}">
                        <h6 class="fw-bold mb-3">Sale Items</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Sold Qty</th>
                                        <th>Return Qty</th>
                                        <th>Unit Price</th>
                                        <th>Return Reason</th>
                                        <th>Condition</th>
                                        <th>Notes</th>
                                        <th>Action</th>
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
                                                        class="form-control form-control-sm qty-input" min="1" max="{{ $item->quantity }}"
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
                        <div class="alert alert-info" id="noItemsMessage" style="display: {{ $sale && $saleItems->count() > 0 ? 'none' : 'block' }}">
                            Select a sale to view items
                        </div>
                    </div>

                    <!-- Return Reason (General) -->
                    <div class="mb-4">
                        <label class="form-label">General Return Reason / Notes</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Enter general reason for return"></textarea>
                    </div>

                    <!-- Total Summary -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Total Refund Amount:</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h4 class="mb-0 text-primary" id="totalRefund">0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('returns.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
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

        // Calculate total refund
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

        // Listen for quantity changes
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input')) {
                calculateTotal();
            }
        });

        // Handle sale selection
        function handleSaleChange() {
            const saleId = saleSelect.value;
            console.log('Sale selected:', saleId);

            if (!saleId) {
                saleItemsSection.classList.add('d-none');
                return;
            }

            // Show loading state
            saleItemsTable.innerHTML = '<tr><td colspan="8" class="text-center">Loading...</td></tr>';
            saleItemsSection.classList.remove('d-none');

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            // Fetch sale items via AJAX
            fetch(`/returns/sale-items/${saleId}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Sale items loaded:', data);
                    if (data.items && data.items.length > 0) {
                        let html = '';
                        data.items.forEach((item, index) => {
                            html += `
                                <tr data-product-id="${item.product_id}" data-max-qty="${item.quantity}">
                                    <td>
                                        ${item.product_name}
                                        <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                                    </td>
                                    <td>${item.quantity}</td>
                                    <td>
                                        <input type="number" name="items[${index}][quantity]"
                                            class="form-control form-control-sm qty-input" min="0" max="${item.quantity}"
                                            value="0" style="width: 80px;">
                                    </td>
                                    <td>
                                        <input type="number" name="items[${index}][unit_price]"
                                            class="form-control form-control-sm" value="${item.unit_price}" readonly>
                                    </td>
                                    <td>
                                        <select name="items[${index}][return_reason]" class="form-select form-select-sm">
                                            <option value="damaged">Damaged</option>
                                            <option value="wrong_item">Wrong Item</option>
                                            <option value="customer_changed_mind">Customer Changed Mind</option>
                                            <option value="defective">Defective</option>
                                            <option value="expired">Expired</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="items[${index}][condition]" class="form-select form-select-sm">
                                            <option value="good">Good</option>
                                            <option value="damaged">Damaged</option>
                                            <option value="defective">Defective</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="items[${index}][notes]"
                                            class="form-control form-control-sm" placeholder="Notes">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
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
                .catch(error => {
                    console.error('Error fetching sale items:', error);
                    saleItemsTable.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error loading items: ' + error.message + '</td></tr>';
                });
        }

        // Attach event listeners with delay for Select2 initialization
        function attachSaleListener() {
            console.log('Attaching sale listener...');

            // Standard change
            saleSelect.addEventListener('change', function() {
                console.log('Standard change fired');
                handleSaleChange();
            });

            // jQuery/Select2 change
            if (typeof jQuery !== 'undefined') {
                jQuery(saleSelect).on('change', function() {
                    console.log('jQuery change fired');
                    handleSaleChange();
                });

                // Try Select2 specific event
                jQuery(saleSelect).on('select2:select', function(e) {
                    console.log('Select2 select fired', e.params.data);
                    handleSaleChange();
                });
            }
        }

        // Initialize Select2 on sale dropdown
        if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
            jQuery('#saleSelect').select2({
                placeholder: '-- Select Sale --',
                allowClear: true,
                width: '100%'
            });
        }

        // Wait for page to fully load including Select2
        if (document.readyState === 'complete') {
            setTimeout(attachSaleListener, 500);
        } else {
            window.addEventListener('load', function() {
                setTimeout(attachSaleListener, 500);
            });
            // Also try on DOMContentLoaded as backup
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(attachSaleListener, 1000);
            });
        }

        // Form validation
        document.getElementById('returnForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('#saleItemsTable tr');
            let hasValidItem = false;

            items.forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input')?.value || 0);
                if (qty > 0) {
                    hasValidItem = true;
                }
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
