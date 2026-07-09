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
            <h5>Create User Manage</h5>
            <a href="{{ route('user-manage.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('user-manage.new') }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Shop Name <span class="text-danger">*</span></label>
                        <select class="form-select" name="shop_id" required>
                            <option value="" selected disabled>Select Shop</option>
                            @foreach ($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">User Name <span class="text-danger">*</span></label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="" selected disabled>Select User</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" data-role="{{ $user->role->id ?? '' }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role Name</label>
                        <select class="form-select" id="role_display" disabled>
                            <option value="" selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="role_id" id="role_id">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userDropdown = document.getElementById('user_id');
    const roleDisplay = document.getElementById('role_display');
    const hiddenRoleInput = document.getElementById('role_id');
    if (userDropdown && roleDisplay && hiddenRoleInput) {
        userDropdown.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const roleId = selectedOption.getAttribute('data-role');
            hiddenRoleInput.value = roleId;
            Array.from(roleDisplay.options).forEach(option => {
                option.selected = (option.value === roleId);
            });
        });
    }
});
</script>
@endsection
