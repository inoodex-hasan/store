@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Sales List</h5>
                <a href="{{ route('sales.create') }}" class="btn btn-light btn-sm text-dark float-end">
                    <i class="fa fa-plus-circle"></i> Create Sale
                </a>
            </div>
            <div class="card-body">
                <div class="filter-bar p-2">
                    <form action="{{ route('sales.index') }}" method="get" onsubmit="return validateSearch()">
                        <div class="row g-2">
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">From</label>
                                <input type="date" name="from" class="form-control form-control-sm"
                                    value="{{ isset($request) ? $request->from : '' }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">To</label>
                                <input type="date" name="to" class="form-control form-control-sm"
                                    value="{{ isset($request) ? $request->to : '' }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">Search By</label>
                                <select name="search_by" id="search_by" class="form-select form-select-sm">
                                    <option value="">--Select--</option>
                                    <option value="order_no"
                                        {{ isset($request) && $request->search_by == 'order_no' ? 'selected' : '' }}>Order No
                                    </option>
                                    <option value="name"
                                        {{ isset($request) && $request->search_by == 'name' ? 'selected' : '' }}>Name</option>
                                    <option value="phone"
                                        {{ isset($request) && $request->search_by == 'phone' ? 'selected' : '' }}>Phone</option>
                                    <option value="email"
                                        {{ isset($request) && $request->search_by == 'email' ? 'selected' : '' }}>Email</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">Search Key</label>
                                <input type="text" name="key" id="search_key" class="form-control form-control-sm"
                                    value="{{ isset($request) ? $request->key : '' }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end gap-1">
                                <button type="submit" name="search_for" value="filter" class="btn btn-primary btn-sm">Search</button>
                                <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                                <button type="submit" name="search_for" value="pdf" class="btn btn-primary btn-sm">
                                    <i class="fe fe-download"></i>
                                </button>
                            </div>
                        </div>
                        <div id="search_error" class="text-danger mt-1 small" style="display:none;"></div>
                    </form>
                    <script>
                    function validateSearch() {
                        const key = document.getElementById('search_key').value.trim();
                        const searchBy = document.getElementById('search_by').value;
                        const errorEl = document.getElementById('search_error');
                        if (key !== '' && searchBy === '') {
                            errorEl.textContent = 'Please select Search By first.';
                            errorEl.style.display = 'block';
                            return false;
                        }
                        errorEl.style.display = 'none';
                        return true;
                    }
                    </script>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date (তারিখ)</th>
                                <th>Order No (অর্ডার নং)</th>
                                <th>Name (নাম)</th>
                                <th>Phone (ফোন)</th>
                                <th>Payble (পেয়েবল)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $service)
                                <tr>
                                    <td>{{ $services->firstItem() + $loop->index }}</td>
                                    <td>{{ $service->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $service->order_no }}</td>
                                    <td>
                                        <a href="javascript:void(0)">{{ $service->name }}</a>
                                    </td>
                                    <td>{{ $service->phone }}</td>
                                    <td>{{ $service->payble }}</td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item view-sale-details-btn" href="javascript:void(0)"
                                                    data-sale-id="{{ $service->id }}">
                                                    <i class="far fa-eye"></i> Details
                                                </a>
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ route('sales.invoice', $service->id) }}">
                                                    <i class="far fa-file-alt"></i> Invoice
                                                </a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                    onclick="if (confirm('Are you sure to delete the Sales?')) { document.getElementById('serviceDelete{{ $service->id }}').submit(); }">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                                <form id="serviceDelete{{ $service->id }}"
                                                    action="{{ route('sales.destroy', $service->id) }}"
                                                    method="post" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No sales list available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($services->hasPages())
                    <div class="modern-pagination">
                        {{ $services->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sale Details Modal -->
    <div class="modal fade" id="saleDetailsModal" tabindex="-1" aria-labelledby="saleDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: #e94134; color: #fff;">
                    <h5 class="modal-title" id="saleDetailsModalLabel" style="color: #fff;">Sale Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="saleDetailsContent">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        let detailsModal;

        document.addEventListener('DOMContentLoaded', function() {
            detailsModal = new bootstrap.Modal(document.getElementById('saleDetailsModal'));

            document.querySelectorAll('.view-sale-details-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    let saleId = this.dataset.saleId;
                    let urlTemplate = "{{ route('sales.details', ':id') }}";
                    let url = urlTemplate.replace(':id', saleId);

                    let contentEl = document.getElementById('saleDetailsContent');
                    contentEl.innerHTML = '<p>Loading...</p>';

                    fetch(url)
                        .then(function(r) { return r.json(); })
                        .then(function(res) {
                            let sale = res.sale;
                            let items = res.items;

                            let html = `
                                <h6>Customer: ${sale.name} (${sale.phone})</h6>
                                <p>Address: ${sale.address || ''}</p>
                                <p>Bill: ${sale.bill}</p>
                                <p>Discount: ${sale.discount}</p>
                                <p>Payable: ${sale.payble}</p>
                                <hr>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                            items.forEach(function(item) {
                                html += `<tr>
                                    <td>${item.name}${item.model ? ' (' + item.model + ')' : ''}</td>
                                    <td>${item.unit_price}</td>
                                    <td>${item.qty}</td>
                                    <td>${item.total_price}</td>
                                </tr>`;
                            });

                            html += '</tbody></table>';
                            contentEl.innerHTML = html;
                            detailsModal.show();
                        })
                        .catch(function() {
                            contentEl.innerHTML = '<p>Error loading sale details.</p>';
                        });
                });
            });

            setTimeout(function() {
                let alert = document.querySelector('.alert-primary');
                if (alert) {
                    alert.classList.add('fade');
                    setTimeout(function() { alert.remove(); }, 300);
                }
            }, 3000);
        });
    </script>
@endpush
@endsection
