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
                    <h5>Create Category</h5>
                    <a href="{{ route('category.index') }}" class="btn btn-light btn-sm text-dark float-end">Back</a>
                </div>
                <div class="card-body p-4">
                    <p class="text-center text-success"> {{ Session::get('message') }} </p>
                    <form action="{{ route('category.new') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12 col-lg-12">
                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="category_name" class="form-label fw-semibold">Category Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="category_name" name="category_name"
                                            placeholder="Enter Category Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12">
                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="category_image" class="form-label fw-semibold">Category Image</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="category_image"
                                            name="category_image" accept="image/*">
                                        <img id="image_preview" class="image-preview" src="#" alt="Image Preview">
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
<style>
.image-preview {
    margin-top: 15px;
    max-width: 200px;
    max-height: 200px;
    display: none;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#category_image').on('change', function(event) {
        const file = event.target.files[0];
        const preview = $('#image_preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            preview.hide();
        }
    });
});
</script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>
@endsection
@endsection
