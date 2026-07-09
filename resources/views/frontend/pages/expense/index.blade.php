@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="modern-card">
            <div class="card-header">
                <h5>Daily Expense</h5>
                <a href="{{ route('dailyExpenses.create') }}" class="btn btn-light btn-sm text-dark"><i class="fa fa-plus-circle"></i> Add Daily Expense</a>
            </div>
            <div class="card-body">
                <div class="filter-bar">
                    <form action="{{ route('dailyExpenses.index') }}" method="GET" class="row g-2">
                        <div class="col-md-2 p-1">
                            <label class="form-label mb-0 small">From</label>
                            <input type="date" name="from" class="form-control form-control-sm" value="{{ old('from', $request->from ?? '') }}">
                        </div>
                        <div class="col-md-2 p-1">
                            <label class="form-label mb-0 small">To</label>
                            <input type="date" name="to" class="form-control form-control-sm" value="{{ old('to', $request->to ?? '') }}">
                        </div>
                        <div class="col-md-2 p-1">
                            <label class="form-label mb-0 small">Spend Method</label>
                            <select name="spend_method" class="form-select form-select-sm">
                                <option value="">All</option>
                                <option value="cash" {{ ($request->spend_method ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ ($request->spend_method ?? '') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="bank_transfer" {{ ($request->spend_method ?? '') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-2 p-1">
                            <label class="form-label mb-0 small">Category</label>
                            <select name="expense_category_id" class="form-select form-select-sm">
                                <option value="">All</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ ($request->expense_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 p-1">
                            <label class="form-label mb-0 small">Search Remarks</label>
                            <input type="text" name="key" class="form-control form-control-sm" value="{{ old('key', $request->key ?? '') }}" placeholder="Remarks">
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-1">
                            <button type="submit" name="search_for" value="filter" class="btn btn-primary btn-sm">Search</button>
                            <button type="submit" name="search_for" value="pdf" class="btn btn-secondary btn-sm" title="Download PDF"><i class="fe fe-download"></i></button>
                            <a href="{{ route('dailyExpenses.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date (তারিখ)</th>
                                <th>Category (ক্যাটাগরি)</th>
                                <th>Amount (এমাউন্ট)</th>
                                <th>Spend Method (ব্যয় মাধ্যম)</th>
                                <th>Remarks (মন্তব্য)</th>
                                <th>Action (একশন)</th>
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
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('dailyExpenses.edit', $item->id) }}"><i class="far fa-edit"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteExpense({{ $item->id }})"><i class="far fa-trash-alt"></i> Delete</a>
                                                <form id="del{{ $item->id }}" method="POST" action="{{ route('dailyExpenses.destroy', $item->id) }}" style="display:none">@csrf @method('DELETE')</form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($dailyExpense->hasPages())
                    <div class="modern-pagination">
                        {{ $dailyExpense->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteExpense(id) {
            if (confirm('Delete this expense?')) {
                document.getElementById('del' + id).submit();
            }
        }
    </script>
@endpush
