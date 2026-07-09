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
            <h5>Create Permission</h5>
            <a href="{{ route('permission.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('permission.store') }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ old('name') }}" name="name" placeholder="Enter Permission name" required>
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
