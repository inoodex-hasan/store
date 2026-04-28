@extends('frontend.layouts.app')

@section('content')

<div class="content container-fluid">

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <!-- Page Header -->
            <div class="card shadow">

                <div class="card-header cat-head align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1 fw-bold">Edit Permission</h5>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                            <a href="{{ route('permission.index') }}" class="btn create-btn-outline">Permission List</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('permission.update',$permission->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="input-block mb-3 row">
                                    <label class="col-form-label col-md-2">Text Input</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control iborder"
                                            value="{{ old('name', $permission->name) }}" id="name" name="name"
                                            placeholder="Enter Permission name">
                                    </div>
                                </div>
                                <div class="input-block mb-3 mb-0 row">
                                    <div class="col-md-10">
                                        <div class="input-group mb-3">
                                            <button class="btn create-btn" type="submit">Button</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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