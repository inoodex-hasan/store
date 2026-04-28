@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">


        <div class="card shadow">
            <!-- Page Header -->

            <div class="card-header cat-head align-items-center d-flex">
                <h5 class="card-title mb-0 flex-grow-1 fw-bold">Permission List</h5>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                        <a href="{{ route('permission.create') }}" class="btn create-btn-outline"><i
                                class="fa-solid fa-plus"></i> Create Permissions</a>
                    </div>
                </div>
            </div>

            <!-- /Page Header -->

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name (নাম)</th>
                                        <th>Action(একশন)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center gap-2">

                                                    <a href="{{ route('permission.edit', $item->id) }}" class="table-btn">
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
                                                            <strong style="color: darkorange">{{ $item->name }}</strong>
                                                            ?
                                                        </div>
                                                        <div class="modal-footer">

                                                            <form action="{{ route('permission.destroy', $item->id) }}"
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




                                            <!-- /.modal -->


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
