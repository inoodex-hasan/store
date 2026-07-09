@extends('frontend.layouts.app')
@section('content')
<div class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="modern-card">
                <div class="card-header">
                    <h5>আমার অ্যাকাউন্ট</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">লগইন</h5>
                            <form method="post" action="{{route('customerLogin')}}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">ইউজার নাম অথবা ইমেইল <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberme" name="rememberme">
                                    <label class="form-check-label" for="rememberme">মনে রাখুন</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">লগইন</button>
                                <div class="mt-2">
                                    <a href="javascript:void(0)" class="text-danger small">আপনি কি পাসওয়ার্ড ভুলে গেছেন?</a>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">রেজিস্টার</h5>
                            <form method="post" action="{{route('customersignUp')}}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="billing_first_name" id="reg_billing_first_name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ফোন নাম্বার <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="billing_phone" id="reg_billing_phone">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ইমেইল <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="reg_email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" id="reg_password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="confirm_password" id="reg_confirm_password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">রেজিস্টার</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
