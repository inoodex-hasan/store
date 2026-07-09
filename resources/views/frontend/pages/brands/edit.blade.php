@extends('frontend.layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 mx-auto">
            <div class="modern-card">
                <div class="card-header">
                    <h5>Edit Brand</h5>
                    <a href="{{ route('brands.index') }}" class="btn btn-light btn-sm text-dark float-end">Back</a>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('brands.update', $brand->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="name" class="form-label">Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{$brand->name}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="status" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-select mb-3" name="status" required>
                                            <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>
                                                Inactive</option>
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