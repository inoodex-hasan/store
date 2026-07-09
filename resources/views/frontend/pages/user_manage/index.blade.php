@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>User Manage</h5>
                <a href="{{ route('user-manage.create') }}" class="btn btn-light btn-sm text-dark"><i class="fa fa-plus-circle"></i> Create User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Shop (শপ)</th>
                                <th>User's Name (ইউজার নাম)</th>
                                <th>Role Name (রোল নাম)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_manages as $user_manage)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $user_manage->shop->name ?? 'N/A' }}</td>
                                    <td>{{ $user_manage->user->name ?? 'N/A' }}</td>
                                    <td>{{ $user_manage->role->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('user-manage.edit', $user_manage->id) }}"><i class="far fa-edit"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#delModal{{ $user_manage->id }}"><i class="far fa-trash-alt"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div id="delModal{{ $user_manage->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: #e94134; color: #fff;">
                                                <h5 class="modal-title" style="color: #fff;">Delete User Manage</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this record?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('user-manage.delete', $user_manage->id) }}" method="post">
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
