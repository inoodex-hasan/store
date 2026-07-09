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
            <h5>Update Shop</h5>
            <a href="{{ route('Shop-warehouse.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('Shop.update', $shop->id) }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name (নাম) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ $shop->name }}" placeholder="Enter Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location (লোকেশন) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="location" value="{{ $shop->location }}" placeholder="Enter Location">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
