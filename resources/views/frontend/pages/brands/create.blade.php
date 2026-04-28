@extends('frontend.layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<div class="row justify-content-center">
    <div class="col-lg-6 mx-auto mt-4">
        <div class="card  shadow">
            <div class="card-header cat-head align-items-center d-flex">
                <h5 class="card-title mb-0 flex-grow-1 fw-bold">Add Brand</h5>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('brands.store') }}">
                    @csrf


                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="name" class="form-label">Name</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control iborder" placeholder="Brand Name" name="name"
                                        id="name" required>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="status" class="form-label">Status</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-select mb-3 iborder" name="status" required>
                                        <option selected="" value="1">Actve</option>
                                        <option value="0">InActve</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="add-customer-btns text-left">
                        <button type="submit" class="btn create-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    $('.js-example-basic-single').select2({

    });

    $('.js-example-basic-single-no-new-value').select2({});


});
</script>

@endsection