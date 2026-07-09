@extends('frontend.layouts.app')
@section('content')
<div class="content container-fluid">
    @include('layouts.flash-message')
    @if ($errors->any())
        <div class="alert alert-danger" id="validation-error-alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <script>setTimeout(function(){var e=document.getElementById('validation-error-alert');if(e)e.style.display='none';},3000);</script>
    @endif
    <div class="modern-card">
        <div class="card-header">
            <h5>Create Setting</h5>
            <a href="{{ route('setting.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('setting.new') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Unit (ইউনিট) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="unit" placeholder="Enter Unit">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Currency (কারেন্সি) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="currency" placeholder="Enter Currency">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Name (কোম্পানি নাম) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logo (লোগো)</label>
                        <input type="file" class="form-control" name="logo" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address (এড্রেস)</label>
                        <input type="text" class="form-control" name="address" placeholder="Enter Address">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone (ফোন)</label>
                        <input type="tel" class="form-control" name="phone" placeholder="Enter Phone Number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email (ইমেইল)</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Website (ওয়েবসাইট)</label>
                        <input type="url" class="form-control" name="website" placeholder="Enter Website URL">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
