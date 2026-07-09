@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Users</h5>
                <a href="{{ route('users.create') }}" class="btn btn-light btn-sm text-dark"><i class="fa fa-plus-circle"></i> Create User</a>
            </div>
            <div class="card-body">
                @if (session('sweet_alert'))
                    <script>Swal.fire({icon: '{{ session('sweet_alert.type') }}', title: '{{ session('sweet_alert.title') }}', text: '{{ session('sweet_alert.text') }}'});</script>
                @endif
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image (ছবি)</th>
                                <th>Name (নাম)</th>
                                <th>Email (ইমেইল)</th>
                                <th>Phone (ফোন)</th>
                                <th>Type (টাইপ)</th>
                                <th>Status (স্ট্যাটাস)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td><img class="t-img" src="{{ asset('frontend/users/' . $item->images) }}" alt="User Image"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->roleName ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->status == '1')
                                            <span class="badge-status success">Active</span>
                                        @else
                                            <span class="badge-status danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('users.edit', $item->id) }}"><i class="far fa-edit"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#delModal{{ $item->id }}"><i class="far fa-trash-alt"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div id="delModal{{ $item->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: #e94134; color: #fff;">
                                                <h5 class="modal-title" style="color: #fff;">Delete User</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $item->name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('users.destroy', $item->id) }}" method="post">
                                                    @csrf @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
