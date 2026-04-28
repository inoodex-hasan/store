@extends('frontend.layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow">

                <div class="card-header cat-head align-items-center d-flex">
                    <h5 class="card-title mb-0 fw-bold flex-grow-1">Update Setting</h5>
                    <div class="flex-shrink-0">


                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('setting.index') }}" class="btn create-btn-outline"> Setting List</a>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger" id="validation-error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

                <script>
                // Set a timeout to hide the alert after 2000 milliseconds (2 seconds)
                setTimeout(function() {
                    document.getElementById('validation-error-alert').style.display = 'none';
                }, 3000);
                </script>
                @endif

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <p class="text-success"> {{Session::get('message')}} </p>
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <form action="{{route('setting.update',$setting->id)}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="unit" class="form-label fw-semibold">Unit</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="unit" name="unit"
                                                            value="{{$setting->unit}}" placeholder="Enter Unit">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="currency"
                                                            class="form-label fw-semibold">Currency</label>

                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="currency"
                                                            name="currency" value="{{$setting->currency}}"
                                                            placeholder="Enter Currency">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="company_name" class="form-label fw-semibold">Company
                                                            Name</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="company_name"
                                                            name="company_name" value="{{$setting->company_name}}"
                                                            placeholder="Enter Company Name">
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="logo" class="form-label fw-semibold">Logo</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" id="logo" name="logo"
                                                            accept="image/*">
                                                        <img src="{{asset($setting->logo)}}" alt="" height="60"
                                                            width="80">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="row align-items-center">
                                                        <div class="col-sm-3">
                                                            <label for="address"
                                                                class="form-label fw-semibold">Address</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="address"
                                                                name="address" value="{{$setting->address}}"
                                                                placeholder="Enter Address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="phone" class="form-label fw-semibold">Phone</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="tel" class="form-control" id="phone" name="phone"
                                                            value="{{$setting->phone}}"
                                                            placeholder="Enter Phone Number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="email" class="form-label fw-semibold">Email</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            value="{{$setting->email}}" placeholder="Enter Email">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="web" class="form-label fw-semibold">Website</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="url" class="form-control" id="website"
                                                            name="website" value="{{$setting->website}}"
                                                            placeholder="Enter Website URL">
                                                    </div>
                                                </div>



                                            </div>
                                        </div>

                                        <div class="mt-4 text-end">
                                            <button type="submit" class="btn create-btn px-4">Submit</button>
                                        </div>




                                    </form>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                        <!--end col-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>
@endsection
@endsection