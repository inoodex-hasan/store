@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">



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

        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card shadow">
                    <div class="card-header cat-head align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1 fw-bold">Create User Mange</h5>
                        <div class="flex-shrink-0">


                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <a href="{{ route('user-manage.index') }}" class="btn create-btn-outline"> User Manage
                                    List</a>
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <p class="text-center text-success"> {{ Session::get('message') }} </p>
                        <div class="live-preview">
                            <div class="row gy-4">
                                <form action="{{ route('user-manage.new') }}" method="post" enctype="multipart/form-data">
                                    @csrf




                                    @if ($errors->any())
                                        <div class="alert alert-danger" id="validation-error-alert">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <script>
                                            setTimeout(() => {
                                                document.getElementById('validation-error-alert').style.display = 'none';
                                            }, 3000);
                                        </script>
                                    @endif



                                    <div class="card-body">
                                        <p class="text-center text-success">{{ Session::get('message') }}</p>
                                        <div class="live-preview">
                                            <div class="row gy-4">
                                                <form action="{{ route('user-manage.new') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    {{-- Shop Dropdown --}}
                                                    <div class="row g-4 mt-2">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-sm-3">

                                                                    <label for="shop_id"
                                                                        class="form-label fw-semibold">Shop
                                                                        Name</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <select class="form-select iborder" id="shop_id"
                                                                        name="shop_id" required>
                                                                        <option value="" selected disabled>Select Shop
                                                                            Name
                                                                        </option>
                                                                        @foreach ($shops as $shop)
                                                                            <option value="{{ $shop->id }}">
                                                                                {{ $shop->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    {{-- User Dropdown --}}
                                                    <div class="row g-4 mt-2">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-sm-3">

                                                                    <label for="user_id"
                                                                        class="form-label fw-semibold">User
                                                                        Name</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <select class="form-select iborder" id="user_id"
                                                                        name="user_id" required>
                                                                        <option value="" selected disabled>Select User
                                                                        </option>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}"
                                                                                data-role="{{ $user->role->id ?? '' }}">
                                                                                {{ $user->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>



                                                    {{-- Role Dropdown (display only) --}}
                                                    <div class="row g-4 mt-2">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label for="role_display"
                                                                        class="form-label fw-semibold">Role Name</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <select class="form-select iborder" id="role_display"
                                                                        disabled>
                                                                        <option value="" selected disabled>Select Role
                                                                        </option>
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->id }}">
                                                                                {{ $role->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    {{-- Hidden field that gets submitted --}}
                                                                    <input type="hidden" name="role_id" id="role_id">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>




                                                    <div class="mt-4 text-end">
                                                        <button type="submit" class="btn create-btn px-4">Submit</button>
                                                    </div>
                                                </form>
                                            </div><!-- end row -->
                                        </div>
                                    </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end container -->




                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const userDropdown = document.getElementById('user_id');
                        const roleDisplay = document.getElementById('role_display');
                        const hiddenRoleInput = document.getElementById('role_id');

                        userDropdown.addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const roleId = selectedOption.getAttribute('data-role');

                            // Set hidden input
                            hiddenRoleInput.value = roleId;

                            // Update display dropdown
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
