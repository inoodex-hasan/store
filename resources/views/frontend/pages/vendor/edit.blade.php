@extends('frontend.layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<div class="row justify-content-center mt-4">
    <div class="col-md-6 mx-auto">
        <div class="card shadow">
            <div class="card-header cat-head">
                <h5 class="fw-bold">Edit Vendor</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('vendors.update', $customer->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row mb-2 align-items-center">
                                <div class="col-sm-3">
                                    <label for="name" class="form-label">Name</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{$customer->name}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row align-items-center">
                                <div class="col-sm-3">
                                    <label for="phone" class="form-label">Phone</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="phone" id="phone"
                                        value="{{$customer->phone}}" pattern="[0-9]{11}" maxlength="11"
                                        placeholder="Enter phone number" required>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="row align-items-center">
                                <div class="col-sm-3">
                                    <label for="email" class="form-label">Email</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" value="{{$customer->email}}"
                                        id="email">
                                </div>
                            </div>

                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="address" class="form-label fw-bold">Address</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="address" id="address" rows="3"
                                        required>{{$customer->address}}</textarea>
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