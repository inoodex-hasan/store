@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">

        <div class="col-lg-6 mx-auto">
            <!-- Page Header -->
            <div class="card shadow">
                <div class="card-header cat-head align-items-center d-flex justify-content-between">
                    <h5 class="cart-title fw-bold">Update Warehouse</h5>
                    <h4 class="card-title mb-0 flex-grow-1">
                        <p class="text-center text-success"> {{ Session::get('message') }} </p>
                    </h4>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('Shop-warehouse.index') }}" class="btn create-btn-outline"> Warehouse List
                            </a>
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
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <form action="{{ route('warehouse.update', $ware_house->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="name" class="form-label fw-semibold">Name
                                                            (নাম)</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $ware_house->name }}"
                                                            placeholder="Enter Name">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3">
                                                        <label for="location" class="form-label fw-semibold">Location
                                                            (লোকেশন)</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="location"
                                                            name="location" value="{{ $ware_house->location }}"
                                                            placeholder="Enter Location">
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
