@extends('frontend.layouts.app')

@section('content')
    <style>
        .shadow {
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
            overflow: hidden;
            border-radius: 21px !important;
        }

        .image-preview {
            margin-top: 15px;
            max-width: 200px;
            max-height: 200px;
            display: none;
        }

        .card-header.cat-head {
            background: #f0f5f1;
            overflow: hidden;
            color: #fff;
            ;

        }

        .create-btn-outline {
            border: 1px solid #000;
            background: transparent;
            color: #000;
        }

        .create-btn-outline:hover {
            border: 1px solid #000;
            background: #000;
            color: #fff;
        }

        .create-btn {
            background: #000;
            color: #fff;
        }

        .create-btn:hover {
            background: #000;
            color: #fff;
        }

        .iborder {
            border: 1px solid #000;
        }

        .t-img {
            width: 60px;
            height: 60px;
            border-radius: 7px;
            border: 1px solid #ddd;
            padding: 3px;
        }

        .table td {
            text-align: left;
            vertical-align: middle;
        }
    </style>

    <div class="content container-fluid">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header cat-head d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1 fw-bold">Category List</h5>
                        <div class="form-check form-switch form-switch-right form-switch-md d-flex justify-content-end">
                            <a href="{{ route('category.create') }}" class="btn create-btn-outline"> Create Category </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> Name (নাম)</th>
                                        <th> Category Image (ক্যাটাগরি ছবি) </th>
                                        <th>Action (একশন)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $category->category_name }} </td>

                                            <td>
                                                @if ($category->category_image)
                                                    <img src="{{ asset($category->category_image) }}" class="t-img"
                                                        alt="Category Image" height="50" width="80">
                                                @else
                                                    <img src="{{ asset('/') }}upload/default.png" class="t-img"
                                                        alt="Default Image" height="50" width="80">
                                                @endif
                                            </td>


                                            <td>
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('category.edit', $category->id) }}">
                                                                    <i class="far fa-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#myModal{{ $category->id }}">
                                                                    <i class="far fa-trash-alt me-2"></i>Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Default Modals -->


                                            <div id="myModal{{ $category->id }}" class="modal fade" tabindex="-1"
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
                                                            <strong style="color: darkorange">{{ $category->name }}</strong>
                                                            ?
                                                        </div>
                                                        <div class="modal-footer">

                                                            <form action="{{ route('category.delete', $category->id) }}"
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

                            <div class="d-flex justify-content-end mt-4">
                                {!! $categories->links('pagination::bootstrap-5') !!}
                            </div>



                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection
