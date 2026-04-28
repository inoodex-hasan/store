@extends('frontend.layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <div class="row justify-content-center">
        <div class="col-md-6 mx-auto">
            <div class="card mt-4  shadow">
                <div class="card-header cat-head align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1 fw-bold">Add Vendor</h5>

                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('vendors.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="name" class="form-label">Name (নাম)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control iborder" name="name" id="name"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12-6 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="phone" class="form-label">Phone (ফোন)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="tel" class="form-control iborder" name="phone" id="phone"
                                            pattern="[0-9]{11}" maxlength="11" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="email" class="form-label">Email (ইমেইল)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control iborder" name="email" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="address" class="form-label fw-bold">Address (এড্রেস)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea class="form-control iborder" name="address" id="address" rows="3" required></textarea>
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
