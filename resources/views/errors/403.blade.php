@extends('frontend.layouts.app')
@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 60vh;">
    <div class="text-center">
        <div class="mb-3">
            <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #0d6efd;"></i>
        </div>
        <h1 style="font-size: 120px; font-weight: 700; color: #2c3e50; line-height: 1;">403</h1>
        <p class="text-muted mb-4" style="font-size: 18px;">{{ $exception->getMessage() ?: 'You do not have permission to access this page.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-4">
            <i class="fas fa-home me-2"></i> Back to Home
        </a>
    </div>
</div>
@endsection
