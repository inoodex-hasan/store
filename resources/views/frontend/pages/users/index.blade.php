@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <!-- <div class="page-header">
            <div class="content-page-header">
                <h5> Users</h5>
            </div>
        </div> -->

        <div class="card shadow">
            <div class="card-header align-items-center d-flex">
                <h5 class="card-title mb-0 fw-bold flex-grow-1">Users</h5>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('users.create') }}" class="btn create-btn-outline">Create Users</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        @if (session('sweet_alert'))
                            <script>
                                Swal.fire({
                                    icon: '{{ session('
                                                            sweet_alert.type ') }}',
                                    title: '{{ session('
                                                            sweet_alert.title ') }}',
                                    text: '{{ session('
                                                            sweet_alert.text ') }}',
                                });
                            </script>
                        @endif


                        <!-- end card header -->

                        <div class="row gy-4">
                            <div class="table-responsive">
                                <table class="table" id="dataTbl">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image (ছবি)</th>
                                            <th>Name (নাম)</th>
                                            <th>Email (ইমেইল)</th>
                                            <th>Phone (ফোন)</th>
                                            <th>Type (টাইপ)</th>
                                            <th>status (স্ট্যাটাস)</th>
                                            <th>Action (একশন)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <img class="t-img" src="{{ asset('frontend/users/' . $item->images) }}"
                                                        alt="Users Image">
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->roleName ?? 'N/A' }}</td>
                                                <td class="{{ $item->status == '1' ? 'text-success' : 'text-danger' }}">
                                                    {{ $item->status == '1' ? 'Active' : 'Inactive' }}
                                                </td>
                                                <td class="text-center   ">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <a href="{{ route('users.edit', $item->id) }}" class="table-btn">
                                                            <i class="fe fe-edit text-white"></i>
                                                        </a>
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#myModal{{ $item->id }}" class="table-btn">
                                                            <i class="fe fe-trash-2 text-white"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                                <!-- Default Modals -->
                                                <div id="myModal{{ $item->id }}" class="modal fade" tabindex="-1"
                                                    aria-labelledby="myModalLabel" aria-hidden="true"
                                                    style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Delete</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this Users:
                                                                <strong
                                                                    style="color: darkorange">{{ $item->name }}</strong>
                                                                ?
                                                            </div>
                                                            <div class="modal-footer">

                                                                <form action="{{ route('users.destroy', $item->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit"
                                                                        class="btn btn-default">Delete</button>

                                                                </form>
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>

                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end row-->
                        </div>


                    </div>
                    <!--end col-->
                </div>
            </div>
        </div>

    </div>
    <!-- container-fluid -->

@section('script')
@endsection
@endsection
