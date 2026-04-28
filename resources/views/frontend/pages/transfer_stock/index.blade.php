@extends('frontend.layouts.app')

@section('content')
    <div class="content container-fluid">


        <div class="card shadow">
            <div class="card-header cat-head align-items-center d-flex">
                <h5 class="card-title mb-0 flex-grow-1 fw-bold"> Transfer Stock </h5>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                        <a href="{{ route('transfer_stock.create') }}" class="btn create-btn-outline"> Transfer Stock </a>
                    </div>
                </div>
            </div>

            <div class="card mb-3 p-3">
                <form action="{{ route('transfer_stock.index') }}" method="GET" class="row g-2">

                    <div class="col-md-3">
                        <select name="product_id" class="form-select">
                            <option value="">All Products</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="stock_from" class="form-select">
                            <option value="">All Warehouses (Stock from)</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}"
                                    {{ request('stock_from') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="stock_to" class="form-select">
                            <option value="">All Shops (Stock to)</option>
                            @foreach ($shops as $shop)
                                <option value="{{ $shop->id }}"
                                    {{ request('stock_to') == $shop->id ? 'selected' : '' }}>
                                    {{ $shop->location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="quantity" value="{{ request('quantity') }}" class="form-control"
                            placeholder="Minimum Quantity">
                    </div>

                    <div class="col-md-2 d-flex align-items-center">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>

                    <div class="col-md-1 d-flex align-items-center">
                        <a href="{{ route('transfer_stock.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>


            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Transfer Stock & Time (ট্রান্সফার স্টক ও সময়) </th>
                                        <th> Stock From (ওয়্যারহাউস-লোকেশন) </th>
                                        <th> Stock To (শপ লোকেশন) </th>
                                        <th> Product (প্রোডাক্ট) </th>
                                        <th> Quantity (পরিমাণ)</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transfer_stocks as $transfer_stock)
                                        <tr>
                                            <td> {{ $loop->index + 1 }} </td>
                                            <td>{{ $transfer_stock->created_at->timezone('Asia/Dhaka')->format('d M Y, h:i A') }}
                                            </td>



                                            <td>{{ $transfer_stock->fromWarehouse->location ?? 'N/A' }}</td>
                                            <td>{{ $transfer_stock->toShop->location ?? 'N/A' }}</td>
                                            <td>{{ $transfer_stock->product->name ?? 'N/A' }}</td>

                                            <td> {{ $transfer_stock->quantity }} </td>




                                            {{--                                        <td class="text-center"> --}}
                                            {{--                                            <div class="d-flex align-items-center gap-2"> --}}
                                            {{--                                                <a href="{{ route('transfer_stock.edit', $transfer_stock->id) }}" --}}
                                            {{--                                                   class="table-btn"> --}}
                                            {{--                                                    <i class="fe fe-edit text-white"></i> --}}
                                            {{--                                                </a> --}}

                                            {{--                                                <button type="button" data-bs-toggle="modal" --}}
                                            {{--                                                        data-bs-target="#myModal{{ $transfer_stock->id }}" class="table-btn"> --}}
                                            {{--                                                    <i class="fe fe-trash-2 text-white"></i> --}}
                                            {{--                                                </button> --}}
                                            {{--                                            </div> --}}
                                            {{--                                        </td> --}}

                                            <!-- Default Modals -->


                                            {{--                                        <div id="myModal{{ $transfer_stock->id }}" class="modal fade" tabindex="-1" --}}
                                            {{--                                             aria-labelledby="myModalLabel" style="display: none;" aria-modal="true" --}}
                                            {{--                                             role="dialog"> --}}
                                            {{--                                            <div class="modal-dialog"> --}}
                                            {{--                                                <div class="modal-content"> --}}
                                            {{--                                                    <div class="modal-header"> --}}
                                            {{--                                                        <h5 class="modal-title" id="myModalLabel">Delete</h5> --}}
                                            {{--                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" --}}
                                            {{--                                                                aria-label="Close"> --}}
                                            {{--                                                        </button> --}}
                                            {{--                                                    </div> --}}
                                            {{--                                                    <div class="modal-body"> --}}
                                            {{--                                                        Are you sure you want to delete this Permissions: --}}
                                            {{--                                                        <strong style="color: darkorange">{{ $transfer_stock->name }}</strong> --}}
                                            {{--                                                        ? --}}
                                            {{--                                                    </div> --}}
                                            {{--                                                    <div class="modal-footer"> --}}

                                            {{--                                                        <form action="{{ route('transfer_stock.delete', $transfer_stock->id) }}" --}}
                                            {{--                                                              method="post"> --}}
                                            {{--                                                            @csrf --}}
                                            {{--                                                            @method('delete') --}}
                                            {{--                                                            <button type="submit" class="btn btn-default">Delete</button> --}}

                                            {{--                                                        </form> --}}
                                            {{--                                                        <button type="button" class="btn btn-light" --}}
                                            {{--                                                                data-bs-dismiss="modal">Close</button> --}}
                                            {{--                                                    </div> --}}

                                            {{--                                                </div><!-- /.modal-content --> --}}
                                            {{--                                            </div><!-- /.modal-dialog --> --}}
                                            {{--                                        </div> --}}

                                            <!-- /.modal -->



                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>


                            <div class="d-flex justify-content-end mt-4">
                                {!! $transfer_stocks->links('pagination::bootstrap-5') !!}
                            </div>






                        </div>



                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
