@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">
        <!-- /Page Header -->
        <div class="card shadow">
            <div class="card-header cat-head d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1 fw-bold">Setting List</h5>
                <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                    <a href="{{ route('setting.create') }}" class="btn  create-btn-outline"> Create Setting </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> Unit (ইউনিট) </th>
                                        <th> Currency (কারেন্সি) </th>
                                        <th> Company Name (কোম্পানি নাম)</th>
                                        <th> Logo (লোগো)</th>
                                        <th> Address (এড্রেস) </th>
                                        <th> Phone (ফোন)</th>
                                        <th> Email (ইমেইল)</th>
                                        <th> Website (ওয়েবসাইট)</th>
                                        <th>Action (একশন)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Settings as $Setting)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $Setting->unit }} </td>
                                            <td> {{ $Setting->currency }} </td>
                                            <td> {{ $Setting->company_name }} </td>
                                            <td>
                                                <img src="{{ asset($Setting->logo) }}" alt="" class="t-img">
                                            </td>
                                            <td> {{ $Setting->address }} </td>
                                            <td> {{ $Setting->phone }} </td>
                                            <td> {{ $Setting->email }} </td>
                                            <td> {{ $Setting->website }} </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('setting.edit', $Setting->id) }}" class="table-btn">
                                                        <i class="fe fe-edit text-white"></i>
                                                    </a>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#myModal{{ $Setting->id }}" class="table-btn">
                                                        <i class="fe fe-trash-2 text-white"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <!-- Default Modals -->
                                            <div id="myModal{{ $Setting->id }}" class="modal fade" tabindex="-1"
                                                aria-labelledby="myModalLabel" style="display: none;" aria-modal="true"
                                                role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"> </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this Permissions:
                                                            <strong style="color: darkorange">{{ $Setting->name }}</strong>
                                                            ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('setting.delete', $Setting->id) }}"
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
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
