@extends('frontend.layouts.app')

@section('content')
<div class="content container-fluid">

    <div class="col-lg-6 mx-auto">
        <div class="card shadow">
            <div class="card-header cat-head align-items-center d-flex justify-content-between">
                <h5 class="card-title mb-0 flex-grow-1 fw-bold">Update User Manage</h5>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('user-manage.index') }}" class="btn create-btn-outline"> User Manage
                            List</a>
                    </div>
                </div>
            </div>


            @if ($errors->any())
            <div class="alert alert-danger" id="validation-error-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            <script>
            // Set a timeout to hide the alert after 2000 milliseconds (2 seconds)
            setTimeout(function() {
                document.getElementById('validation-error-alert').style.display = 'none';
            }, 3000);
            </script>
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <p class="text-center text-success"> {{Session::get('message')}} </p>
                        <div class="live-preview">
                            <div class="row gy-4">
                                <form action="{{route('user-manage.update', $user_manage->id)}}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Shop Dropdown --}}
                                    <div class="row g-4 mt-2">
                                        <div class="col-lg-12">
                                            <div class="row align-items-center">
                                                <div class="col-sm-3">
                                                    <label for="shop_id" class="form-label fw-semibold">Shop
                                                        Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="shop_id" name="shop_id" required>
                                                        <option value="" disabled>Select Shop Name</option>
                                                        @foreach ($shops as $shop)
                                                        <option value="{{ $shop->id }}"
                                                            {{ $shop->id == $user_manage->shop_id ? 'selected' : '' }}>
                                                            {{ $shop->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row align-items-center">
                                                <div class="col-sm-3">
                                                    <label for="user_id" class="form-label fw-semibold">User
                                                        Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="user_id" name="user_id" required>
                                                        <option value="" disabled>Select User</option>
                                                        @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            data-role="{{ $user->role->id ?? '' }}"
                                                            {{ $user->id == $user_manage->user_id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="role_display" class="form-label fw-semibold"> Role
                                                            Name
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" id="role_display" disabled>
                                                            <option value="">Select Role</option>
                                                            @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}"
                                                                {{ $role->id == $user_manage->role_id ? 'selected' : '' }}>
                                                                {{ $role->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        {{-- Hidden field that gets submitted --}}
                                                        <input type="hidden" name="role_id" id="role_id"
                                                            value="{{ $user_manage->role_id }}">
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="mt-4 text-end">
                                                <button type="submit" class="btn create-btn px-4">Submit</button>
                                            </div>
                                </form>
                            </div>
                            <!--end row-->
                        </div>

                    </div>
                    <!--end col-->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userDropdown = document.getElementById('user_id');
    const roleDisplay = document.getElementById('role_display');
    const hiddenRoleInput = document.getElementById('role_id');

    userDropdown.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const roleId = selectedOption.getAttribute('data-role');

        // Update hidden input
        hiddenRoleInput.value = roleId;

        // Update visible role dropdown
        Array.from(roleDisplay.options).forEach(option => {
            option.selected = (option.value === roleId);
        });
    });
});
</script>



@section('script')
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>
@endsection
@endsection