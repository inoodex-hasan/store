@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Expense Categories</h5>
                <a class="btn btn-light btn-sm text-dark" data-bs-toggle="modal" data-bs-target="#add-expense-category-modal"><i class="fa fa-plus-circle"></i> Add Category</a>
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
                            @foreach ($expenseCategories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->status)
                                            <span class="badge-status success">Active</span>
                                        @else
                                            <span class="badge-status danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#edit-expense-category-modal{{ $category->id }}"><i class="far fa-edit"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteCategory({{ $category->id }})"><i class="far fa-trash-alt"></i> Delete</a>
                                                <form id="deleteForm{{ $category->id }}" method="POST" action="{{ route('expense-categories.destroy', $category->id) }}" style="display:none">@csrf @method('DELETE')</form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Edit Modal --}}
                                <div id="edit-expense-category-modal{{ $category->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: #e94134; color: #fff;">
                                                <h5 class="modal-title" style="color: #fff;">Edit Category</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('expense-categories.update', $category->id) }}">
                                                    @csrf @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($expenseCategories->hasPages())
                    <div class="modern-pagination">
                        {{ $expenseCategories->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="add-expense-category-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #e94134; color: #fff;">
                    <h5 class="modal-title" style="color: #fff;">Add Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('expense-categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                document.getElementById('deleteForm' + id).submit();
            }
        }
    </script>
@endpush
