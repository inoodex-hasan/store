@extends('frontend.layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <div class="row">
        <div class="col-md-6 mx-auto mt-4">
            <div class="card shadow">
                <div class="card-header cat-head">
                    <h2 class="mb-3">Add Customers</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf


                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="name" class="form-label">Name (নাম)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Enter Your Name" s
                                            name="name" id="name" required>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="phone" class="form-label">Phone (ফোন)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="tel" class="form-control" placeholder="Enter Your Phone"
                                            name="phone" id="phone" pattern="[0-9]{11}" maxlength="11"
                                            placeholder="Enter phone number" required>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="email" class="form-label">Email (ইমেইল)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" placeholder="Enter Your E-mail"
                                            name="email" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-sm-3">
                                        <label for="address" class="form-label fw-bold">Address (এড্রেস)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="address" placeholder="Enter Your Address" id="address" rows="3" required></textarea>

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
