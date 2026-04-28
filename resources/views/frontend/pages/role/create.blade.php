@extends('frontend.layouts.app')

@section('content')
<div class="content container-fluid">

    <div class="card shadow">

        <div class="card-header  cat-head align-items-center d-flex">
            <h5 class="card-title mb-0 fw-bold flex-grow-1">Create Role</h5>
            <div class="flex-shrink-0">
                <div class="form-check form-switch form-switch-right form-switch-md">
                    <a href="{{ route('role.index') }}" class="btn  create-btn-outline">Role List</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
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
                    <div class="live-preview">
                        <div class="row gy-4">
                            <form action="{{ route('role.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-12 col-md-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}" id="name"
                                            name="name" placeholder="Enter User name">
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <h5>Parmissions</h5>
                                        <hr style="margin:0px;">
                                        <div class="row g-4 mt-2 ">
                                            @foreach ($permissions as $item)
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 "
                                                style="border:1px solid #ddd; padding:8px; border-radius:7px">
                                                <div class="form-check form-switch" style="padding: 0px;">
                                                    <label
                                                        for="permission_{{ $item->id }}">{{ $item->name }}</label><br>
                                                    <input class="form-check-input mb-2"
                                                        style="margin-left: 0.5em !important;" type="checkbox"
                                                        role="switch" name="permissions[]"
                                                        id="permission_{{ $item->id }}" value="{{ $item->id }}" />
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn create-btn  float-end">Submit</button>
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