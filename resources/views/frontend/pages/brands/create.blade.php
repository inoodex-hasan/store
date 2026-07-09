@extends('frontend.layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 mx-auto">
            <div class="modern-card">
                <div class="card-header">
                    <h5>Add Brand</h5>
                    <a href="{{ route('brands.index') }}" class="btn btn-light btn-sm text-dark float-end">Back</a>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('brands.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="name" class="form-label">Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Brand Name" name="name"
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
                                        <select class="form-select mb-3" name="status" required>
                                            <option selected="" value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
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
