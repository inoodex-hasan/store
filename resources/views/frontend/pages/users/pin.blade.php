@extends('frontend.layouts.app')
@section('content')
<div class="content container-fluid">
    @include('layouts.flash-message')
    @if (session('sweet_alert'))
        <script>Swal.fire({icon: '{{ session('sweet_alert.type') }}', title: '{{ session('sweet_alert.title') }}', text: '{{ session('sweet_alert.text') }}'});</script>
    @endif
    <div class="modern-card">
        <div class="card-header">
            <h5>Set PIN Number</h5>
            <a href="{{ route('users.index') }}" class="btn btn-light btn-sm text-dark">Back to Users</a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('users.pin_store') }}" method="post">
                @csrf
                <div class="row g-3">
                    @foreach ($extras as $extra)
                        <div class="col-md-4">
                            <label class="form-label" style="text-transform: capitalize;">{{ $extra->name }}</label>
                            <input type="text" class="form-control" value="{{ $extra->value }}" name="{{ $extra->name }}" placeholder="Enter {{ $extra->name }}">
                        </div>
                    @endforeach
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
