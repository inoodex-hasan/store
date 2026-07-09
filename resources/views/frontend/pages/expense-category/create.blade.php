@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        @include('layouts.flash-message')
        <div class="modern-card">
            <div class="card-header">
                <h5>Add Expense Category</h5>
                <a href="{{ route('expense-categories.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
            </div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('expense-categories.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter category name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
