@extends('frontend.layouts.app')
@section('content')
<div class="content container-fluid">
    @include('layouts.flash-message')
    @if ($errors->any())
        <div class="alert alert-danger" id="validation-error-alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <script>setTimeout(function(){var e=document.getElementById('validation-error-alert');if(e)e.style.display='none';},3000);</script>
    @endif
    <div class="modern-card">
        <div class="card-header">
            <h5>Edit Role</h5>
            <a href="{{ route('role.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('role.update', $role->id) }}" method="post">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ old('name', $role->name) }}" name="name" placeholder="Enter Role name" required>
                    </div>
                    <div class="col-md-8">
                        <h6 class="fw-bold">Permissions</h6>
                        <hr class="my-1">
                        <div class="row g-2 mt-2">
                            @foreach ($permissions as $item)
                            <div class="col-6 col-md-4 col-lg-3" style="border:1px solid #ddd; padding:8px; border-radius:7px">
                                <div class="form-check form-switch" style="padding-left: 2.5em;">
                                    <input class="form-check-input" type="checkbox" role="switch" name="permissions[]" id="permission_{{ $item->id }}" value="{{ $item->id }}" @if($roleHasPermissions->pluck('permission_id')->contains($item->id)) checked @endif>
                                    <label class="form-check-label" for="permission_{{ $item->id }}">{{ $item->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
