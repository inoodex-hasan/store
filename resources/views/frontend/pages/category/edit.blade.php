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
    setTimeout(function() {
        document.getElementById('validation-error-alert').style.display = 'none';
    }, 3000);
    </script>
    @endif

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="modern-card">
                <div class="card-header">
                    <h5>Update Category</h5>
                    <a href="{{ route('category.index') }}" class="btn btn-light btn-sm text-dark float-end">Back</a>
                </div>
                <div class="card-body p-4">
                    <p class="text-center text-success"> {{Session::get('message')}} </p>
                    <form action="{{route('category.update' ,$category->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="category_name" class="form-label fw-semibold">Category Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="category_name"
                                            name="category_name" value="{{$category->category_name}}"
                                            placeholder="Enter Category Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="category_image" class="form-label fw-semibold">Category Image</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="category_image"
                                            name="category_image" accept="image/*">

                                        @if($category->category_image)
                                        <img src="{{ asset($category->category_image) }}" alt="Category Image"
                                            height="100" width="130" class="mt-2">
                                        @else
                                        <img src="{{ asset('upload/default.png') }}" alt="Default Image"
                                            height="100" width="130" class="mt-2">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-light px-4">Submit</button>
                        </div>
                    </form>
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
