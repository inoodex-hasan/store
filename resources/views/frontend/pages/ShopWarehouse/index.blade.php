@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">


        <div class="card shadow">
            <div class="card-header  cat-head d-flex align-items-center justify-content-between">
                <h5 class="cart-title fw-bold">Shop List</h5>
                <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                    <a href="{{ route('Shop.create') }}" class="btn create-btn-outline"> Create Shop </a>
                </div>
            </div>
            {{--        <!-- Page Header --> --}}
            {{--        <div class="page-header"> --}}
            {{--            <div class="content-page-header"> --}}
            {{--                <h5>  Warehouse List </h5> --}}
            {{--            </div> --}}
            {{--        </div> --}}
            {{--        <!-- /Page Header --> --}}
            <div class="card-body">
                <div class="row">
                    <div class="col">

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> Name (নাম) </th>
                                        <th> Location (লোকেশন) </th>
                                        <th> Action (একশন)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shops as $shop)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $shop->name }} </td>
                                            <td> {{ $shop->location }} </td>

                                            <td class="text-center">

                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('Shop.edit', $shop->id) }}" class="table-btn">
                                                        <i class="fe fe-edit text-white"></i>
                                                    </a>

                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#myModal{{ $shop->id }}" class="table-btn">
                                                        <i class="fe fe-trash-2 text-white"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <!-- Default Modals -->
                                            <div id="myModal{{ $shop->id }}" class="modal fade" tabindex="-1"
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
                                                            <strong style="color: darkorange">{{ $shop->name }}</strong>
                                                            ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('Shop.delete', $shop->id) }}"
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
        <hr>
        <hr>
        <br>
        <br>
        <br>

        <div class="card shadow">
            <div class="card-header cat-head d-flex align-items-center justify-content-between ">
                <h5 class="cart-title fw-bold">Warehouse List</h5>
                <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                    <a href="{{ route('warehouse.create') }}" class="btn create-btn-outline"> Create Warehouse </a>
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
                                        <th> Name (নাম)</th>
                                        <th> Location (লোকেশন) </th>
                                        <th>Action (একশন)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ware_houses as $ware_house)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $ware_house->name }} </td>
                                            <td> {{ $ware_house->location }} </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('warehouse.edit', $ware_house->id) }}"
                                                        class="table-btn">
                                                        <i class="fe fe-edit text-white"></i>
                                                    </a>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#myModal{{ $ware_house->id }}" class="table-btn">
                                                        <i class="fe fe-trash-2 text-white"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <!-- Default Modals -->
                                            <div id="myModal{{ $ware_house->id }}" class="modal fade" tabindex="-1"
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
                                                            <strong
                                                                style="color: darkorange">{{ $ware_house->name }}</strong>
                                                            ?
                                                        </div>
                                                        <div class="modal-footer">

                                                            <form action="{{ route('warehouse.delete', $ware_house->id) }}"
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
