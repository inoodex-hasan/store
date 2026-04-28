@extends('frontend.layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow">

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
                <div class="card-header cat-head align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 fw-bold">Create User</h4>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('users.index') }}" class="btn create-btn-outline">User List</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">

                                <!-- end card header -->
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row gy-4">
                                            <form action="{{ route('users.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <!-- <div class="col-xxl-3 col-md-6 mb-3">
                                        <label for="name" class="form-label">Type</label>
                                        <select class="form-select mb-3" name="role_id">
                                            @foreach (userTypes() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach                                                                                        
                                        </select>
                                    </div> -->
                                                    <div class="col-md-12 mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3">
                                                                <label for="name" class="form-label">Name</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('name') }}" id="name" name="name"
                                                                    placeholder="Enter User name">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3">
                                                                <label for="name" class="form-label">Email</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('email') }}" id="email" name="email"
                                                                    placeholder="Enter User email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3">
                                                                <label for="name" class="form-label">Phone</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('phone') }}" id="phone" name="phone"
                                                                    placeholder="Enter User phone">
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3">
                                                                <label for="name" class="form-label">Password</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('password') }}" id="password"
                                                                    name="password" placeholder="Enter User password">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3">
                                                                <label for="image"
                                                                    class="form-label">Image(366x366)</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="file" multiple class="form-control"
                                                                    id="image" name="images">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3">
                                                                <label for="status" class="form-label">Status</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <select class="form-select mb-3" name="status">
                                                                    <option selected="" value="1">Actve</option>
                                                                    <option value="0">InActve</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-3">
                                                                <label for="name" class="form-label">Role</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <select class="form-select mb-3" name="user_role"
                                                                    required>
                                                                    @foreach ($roles as $role)
                                                                    <option value="{{ $role->id}}">{{ $role->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <button type="submit" class="btn create-btn float-end">Submit</button>
                                            </form>

                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- container-fluid -->

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