@extends('frontend.layouts.app')
@section('content')

    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Brands</h5>
                <a href="{{ route('brands.create') }}" class="btn btn-light btn-sm text-dark float-end">
                    <i class="fa fa-plus-circle"></i> Add Brand
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name (নাম)</th>
                                <th>Status (স্ট্যাটাস)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        @if ($brand->status == 1)
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
                                                <a class="dropdown-item" href="{{ route('brands.edit', $brand->id) }}">
                                                    <i class="far fa-edit"></i>Edit
                                                </a>
                                                <a onclick="if (confirm('Are you sure to delete this brand?')) { document.getElementById('deleteBrand{{ $brand->id }}').submit(); }"
                                                    class="dropdown-item text-danger" href="javascript:void(0)">
                                                    <i class="far fa-trash-alt"></i>Delete
                                                </a>
                                                <form id="deleteBrand{{ $brand->id }}"
                                                    action="{{ route('brands.destroy', $brand->id) }}"
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

                    @if ($brands->hasPages())
                        <div class="modern-pagination">
                            {{ $brands->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
