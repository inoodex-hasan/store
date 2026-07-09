@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Setting List</h5>
                <a href="{{ route('setting.create') }}" class="btn btn-light btn-sm text-dark"><i class="fa fa-plus-circle"></i> Create Setting</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Unit (ইউনিট)</th>
                                <th>Currency (কারেন্সি)</th>
                                <th>Company Name (কোম্পানি নাম)</th>
                                <th>Logo (লোগো)</th>
                                <th>Address (এড্রেস)</th>
                                <th>Phone (ফোন)</th>
                                <th>Email (ইমেইল)</th>
                                <th>Website (ওয়েবসাইট)</th>
                                <th>Action (একশন)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Settings as $Setting)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $Setting->unit }}</td>
                                    <td>{{ $Setting->currency }}</td>
                                    <td>{{ $Setting->company_name }}</td>
                                    <td><img src="{{ asset($Setting->logo) }}" alt="" class="t-img"></td>
                                    <td>{{ $Setting->address }}</td>
                                    <td>{{ $Setting->phone }}</td>
                                    <td>{{ $Setting->email }}</td>
                                    <td>{{ $Setting->website }}</td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('setting.edit', $Setting->id) }}"><i class="far fa-edit"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#delModal{{ $Setting->id }}"><i class="far fa-trash-alt"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div id="delModal{{ $Setting->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: #e94134; color: #fff;">
                                                <h5 class="modal-title" style="color: #fff;">Delete Setting</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete this setting?</div>
                                            <div class="modal-footer">
                                                <form action="{{ route('setting.delete', $Setting->id) }}" method="post">
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
