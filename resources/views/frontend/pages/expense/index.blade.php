@extends('frontend.layouts.app')
@section('content')
    <style>
        th,
        td {
            padding: 5px !important;
        }
    </style>

    <div class="content container-fluid">

        <div class="card shadow">
            <!-- Page Header -->
            <div class="card-header cat-head">
                <div class="d-flex justify-content-between  align-items-center">

                    <h5 class="card-title mb-0 flex-grow-1 fw-bold">Daily Expense</h5>

                    <a class="btn create-btn-outline" href="{{ route('dailyExpenses.create') }}">
                        <i class="fa fa-plus-circle me-2"></i>Add Daily Expense
                    </a>

                </div>
                <div>


                    <form action="{{ route('dailyExpenses.index') }}" method="get" class="row g-3">
                        <div class="col-md-2">
                            <label>From</label>
                            <input type="date" name="from" class="form-control"
                                value="{{ old('from', $request->from ?? '') }}">
                        </div>
                        <div class="col-md-2">
                            <label>To</label>
                            <input type="date" name="to" class="form-control"
                                value="{{ old('to', $request->to ?? '') }}">
                        </div>
                        <div class="col-md-2">
                            <label>Spend Method</label>
                            <select name="spend_method" class="form-select">
                                <option value="">--Select--</option>
                                <option value="cash" {{ $request->spend_method == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="card" {{ $request->spend_method == 'card' ? 'selected' : '' }}>Card
                                </option>
                                <option value="bank_transfer"
                                    {{ $request->spend_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Category</label>
                            <select name="expense_category_id" class="form-select">
                                <option value="">--Select--</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $request->expense_category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Search Remarks</label>
                            <input type="text" name="key" class="form-control"
                                value="{{ old('key', $request->key ?? '') }}">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button type="submit" name="search_for" value="filter" class="btn create-btn">Search</button>
                            <button type="submit" name="search_for" value="pdf" class="btn btn-secondary"><i
                                    class="fe fe-download"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-table">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-center table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Date (তারিখ)</th>
                                                <th>Category (ক্যাটাগরি)</th>
                                                <th>Amount (এমাউন্ট)</th>
                                                <th>Spend Method (ব্যয় মাধ্যম)</th>
                                                <th>Remarks (মন্তব্য)</th>
                                                <th class="no-sort">Actions (একশন)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dailyExpense as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d M, Y') }}</td>
                                                    <td>{{ $item->category_name }}</td>
                                                    <td>{{ number_format($item->amount, 2) }} TK</td>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $item->spend_method)) }}</td>
                                                    <td>{{ $item->remarks }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn-action-icon" data-bs-toggle="dropdown"><i
                                                                    class="fas fa-ellipsis-v"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('dailyExpenses.edit', $item->id) }}">
                                                                    <i class="far fa-edit me-2"></i>Edit
                                                                </a>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                    onclick="if(confirm('Delete this expense?')) document.getElementById('del{{ $item->id }}').submit();">
                                                                    <i class="far fa-trash-alt me-2"></i>Delete
                                                                </a>
                                                                <form id="del{{ $item->id }}" method="POST"
                                                                    action="{{ route('dailyExpenses.destroy', $item->id) }}"
                                                                    style="display:none">
                                                                    @csrf @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- You can add pagination controls here if needed --}}
                                    {{-- <div class="d-flex justify-content-end mt-4">
                 {!! $dailyExpense->links('pagination::bootstrap-5') !!}
            </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
