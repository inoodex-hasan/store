@extends('frontend.layouts.app')

@section('content')
<style>
.shadow {
    /* box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px !important; */
    box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
    /* border:1px  solid #FF3F33 !important; */
    overflow: hidden;
    border-radius: 21px !important;
}

.image-preview {
    margin-top: 15px;
    max-width: 200px;
    max-height: 200px;
    display: none;
}

.card-header.cat-head {
    /* background:#FF3F33; */
    background: #f0f5f1;
    overflow: hidden;
    color: #fff;
    ;

}

.create-btn-outline {
    border: 1px solid #000;
    background: transparent;
    color: #000;
}

.create-btn-outline:hover {
    border: 1px solid #000;
    background: #000;
    color: #fff;
}

.create-btn {
    background: #000;
    color: #fff;
}

.create-btn:hover {
    background: #000;
    color: #fff;
}
</style>
<div class="content container-fluid  ">
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
            <div class="card shadow">
                <div class="card-header cat-head align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1 fw-bold"> Create Category</h5>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('category.index') }}" class="btn create-btn-outline">Back</a>
                        </div>
                    </div>
                </div>
                <br>
                  <p class="text-center text-success"> {{ Session::get('message') }} </p>
                <div class="card-body">
                  
                    <div class="live-preview">
                        <div class="row gy-4">
                            <form action="{{ route('category.new') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="row align-items-center">
                                            <div class="col-sm-3">

                                                <label for="category_name" class="form-label  fw-semibold">Category
                                                    Name</label>
                                            </div>
                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" style="border:1px solid #000"
                                                    id="category_name" name="category_name"
                                                    placeholder="Enter Category Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12">
                                        <div class="row align-items-center">
                                            <div class="col-sm-3">

                                                <label for="category_image" class="form-label fw-semibold">Category
                                                    Image</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" style="border:1px solid #000"
                                                    id="category_image" name="category_image" accept="image/*">

                                                <img id="image_preview" class="image-preview" src="#"
                                                    alt="Image Preview">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn create-btn px-4">Submit</button>
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