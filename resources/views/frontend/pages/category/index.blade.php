@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Category List</h5>
                <a href="{{ route('category.create') }}" class="btn btn-light btn-sm text-dark float-end">
                    <i class="fa fa-plus-circle"></i> Create Category
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name (নাম)</th>
                                <th>Image (ছবি)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td>
                                        @if ($category->category_image)
                                            <img src="{{ asset($category->category_image) }}" class="t-img" alt="">
                                        @else
                                            <img src="{{ asset('/') }}upload/default.png" class="t-img" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('category.edit', $category->id) }}">
                                                    <i class="far fa-edit"></i>Edit
                                                </a>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                                                    <i class="far fa-trash-alt"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <div id="deleteModal{{ $category->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $category->category_name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('category.delete', $category->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="modern-pagination">
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
