@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Customer List</h5>
                <a href="{{ route('customers.create') }}" class="btn btn-light btn-sm text-dark float-end">
                    <i class="fa fa-plus-circle"></i> Add Customer
                </a>
            </div>
            <div class="card-body">
                <div class="card-body py-2 px-0 border-bottom">
                    <form action="{{ route('customers.index') }}" method="GET" class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                placeholder="Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="phone" value="{{ request('phone') }}" class="form-control"
                                placeholder="Phone">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="email" value="{{ request('email') }}" class="form-control"
                                placeholder="Email">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name (নাম)</th>
                                <th>Phone (ফোন)</th>
                                <th>Email (ইমেইল)</th>
                                <th>Address (এড্রেস)</th>
                                <th>Status (স্ট্যাটাস)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $product)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->phone ?? 'N/A' }}</td>
                                    <td>{{ $product->email ?? 'N/A' }}</td>
                                    <td>{{ $product->address ?? 'N/A' }}</td>
                                    <td>
                                        @if ($product->status == 1)
                                            <span class="badge-status active">Active</span>
                                        @else
                                            <span class="badge-status inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('customers.edit', $product->id) }}">
                                                    <i class="far fa-edit"></i>Edit
                                                </a>
                                                <a onclick="if (confirm('Are you sure to delete this customer?')) { document.getElementById('deleteCustomer{{ $product->id }}').submit(); }"
                                                    class="dropdown-item text-danger" href="javascript:void(0)">
                                                    <i class="far fa-trash-alt"></i>Delete
                                                </a>
                                                <form id="deleteCustomer{{ $product->id }}"
                                                    action="{{ route('customers.destroy', $product->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($customers->hasPages())
                        <div class="modern-pagination">
                            {{ $customers->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
