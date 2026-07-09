@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto">
                <div class="modern-card">
                    <div class="card-header">
                        <h5>Add Vendor</h5>
                        <a href="{{ route('vendors.index') }}" class="btn btn-light btn-sm text-dark float-end">Back</a>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('vendors.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-sm-3">
                                            <label for="name" class="form-label">Name (নাম)</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name" id="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-sm-3">
                                            <label for="phone" class="form-label">Phone (ফোন)</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="tel" class="form-control" name="phone" id="phone"
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
                                            <input type="email" class="form-control" name="email" id="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-sm-3">
                                            <label for="address" class="form-label fw-bold">Address (এড্রেস)</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-light px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
