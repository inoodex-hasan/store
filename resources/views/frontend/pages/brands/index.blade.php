@extends('frontend.layouts.app')
@section('content')
    <style>

    </style>
    <div class="content container-fluid">
        <div class="card shadow">
            <div class="card-header cat-head align-items-center d-flex">
                <h5 class="card-title mb-0 flex-grow-1 fw-bold"> Brands</h5>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                        <a class="btn create-btn-outline" href="{{ route('brands.create') }}">
                            <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Brand
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="brandTable" class="table table-center table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name (নাম)</th>
                                        <th>Status (স্ট্যাটাস)</th>
                                        <th class="no-sort">Actions (একশন)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                @if ($brand->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="d-flex align-items-center">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('brands.edit', $brand->id) }}">
                                                                    <i class="far fa-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a onclick="if (confirm('Are you sure to delete this brand?')) { document.getElementById('deleteBrand{{ $brand->id }}').submit(); }"
                                                                    class="dropdown-item" href="javascript:void(0)">
                                                                    <i class="far fa-trash-alt me-2"></i>Delete
                                                                </a>
                                                                <form id="deleteBrand{{ $brand->id }}"
                                                                    action="{{ route('brands.destroy', $brand->id) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-4">
                                {!! $brands->links('pagination::bootstrap-5') !!}
                            </div>

                            <!-- Optional: Modals for inline edit (if not using separate page) -->
                            {{-- You can add modal edit form per brand here if needed --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
