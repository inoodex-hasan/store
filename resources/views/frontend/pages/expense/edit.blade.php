@extends('frontend.layouts.app')
@section('content')
    <div class="content container-fluid">
        @include('layouts.flash-message')
        @if ($errors->any())
            <div class="alert alert-danger" id="validation-error-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>setTimeout(function(){var e=document.getElementById('validation-error-alert');if(e)e.style.display='none';},3000);</script>
        @endif
        <div class="modern-card">
            <div class="card-header">
                <h5>Edit Daily Expense</h5>
                <a href="{{ route('dailyExpenses.index') }}" class="btn btn-light btn-sm text-dark">Back to List</a>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('dailyExpenses.update', $expense->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', $expense->date) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expense Category <span class="text-danger">*</span></label>
                            <select name="expense_category_id" class="form-select" required>
                                <option value="">-- Select --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('expense_category_id', $expense->expense_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $expense->amount) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Spend Method <span class="text-danger">*</span></label>
                            <select name="spend_method" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="cash" {{ old('spend_method', $expense->spend_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('spend_method', $expense->spend_method) == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="bank_transfer" {{ old('spend_method', $expense->spend_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="1" placeholder="Enter remarks">{{ old('remarks', $expense->remarks) }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            <a href="{{ route('dailyExpenses.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
