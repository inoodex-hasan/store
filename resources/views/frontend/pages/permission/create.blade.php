@extends('frontend.layouts.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="col-lg-6 mx-auto">
        <div class="card shadow">

            <!-- /Page Header -->
            <div class="card-header cat-head align-items-center d-flex  s">
                <h5 class="card-title fw-bold mb-0 flex-grow-1">Create Permission</h5>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('permission.index') }}" class="btn create-btn-outline">Permission List</a>
                    </div>
                </div>
            </div>

            <!-- this is permission crate.blade.php  -->

            @if ($errors->any())
            <div class=" alert alert-danger" id="validation-error-alert">
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

                        <!-- end card header -->
                        <div class="live-preview">
                            <div class="row gy-4">
                                <form action="{{ route('permission.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">

                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <label for="name" class="form-label">Name</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" class="form-control" value="{{ old('name') }}"
                                                        id="name" name="name" placeholder="Enter Permission name">
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
                    <!--end col-->
                </div>
            </div>
        </div>
    </div>
</div>

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