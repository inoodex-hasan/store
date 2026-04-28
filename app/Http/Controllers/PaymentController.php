<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountsReceivable;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show all payments
    // public function index()
    // {
    //     // $payments = Payment::paginate(10);
    //     $payments = Payment::with('customer')->paginate(10);

    //    return view('frontend.pages.payment.index', compact('payments'));
    // }

    public function index(Request $request)
    {
        $query = Payment::with(['sale.customer']); // eager load sale & customer

        // // Filter by sale_id
        // if ($request->filled('sale_id')) {
        //     $query->where('sale_id', $request->sale_id);
        // }

        // Filter by customer_id
        if ($request->filled('customer_name')) {
            $name = $request->customer_name;
            $query->whereHas('sale.customer', function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%");
            });
        }

        // Filter by amount (exact or min/max)
        if ($request->filled('amount')) {
            $query->where('amount', $request->amount);
        }

        // Filter by payment_date
        if ($request->filled('payment_date')) {
            $query->whereDate('payment_date', $request->payment_date);
        }

        // Filter by payment_method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();


        // For dropdowns
        // $sales = Sale::all();
        $customers = $query->latest()->paginate(10)->withQueryString();
        $methods = Payment::select('payment_method')->distinct()->pluck('payment_method');

        return view('frontend.pages.payment.index', compact('payments', 'customers', 'methods'));
    }


    // Show create form
    public function create()
    {
        $customers = Customer::all();
        return view('frontend.pages.payment.create', compact('customers'));
    }

    // Store payment
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => '',
            'customer_id' => 'required|integer',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string',
        ]);

        // Get customer's due amount
        $accountReceivable = AccountsReceivable::firstOrCreate(
            ['customer_id' => $request->customer_id],
            ['due_amount' => 0]
        );

        // Check if payment amount is greater than due amount
        if ($request->amount > $accountReceivable->due_amount) {
            return back()
                ->with('alert', 'Payment amount cannot be greater than the due amount (' . $accountReceivable->due_amount . ').')
                ->withInput();
        }

        // Payment create
        $payment = Payment::create($request->all());

        // Reduce due_amount
        $accountReceivable->due_amount -= $request->amount;
        $accountReceivable->save();

        return redirect()->route('payments.index')->with('success', 'Payment added successfully.');
    }


    // Edit form
    public function edit(Payment $payment)
    {
        return view('frontend.pages.payment.edit', compact('payment'));
    }

    // Update payment
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'sale_id' => '',
            'customer_id' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string',
        ]);

        $payment->update($request->all());

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    // Delete payment
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }


    public function getCustomerDue($id)
    {
        $accountReceivable = \App\Models\AccountsReceivable::where('customer_id', $id)->first();
        $due = $accountReceivable ? $accountReceivable->due_amount : 0;
        return response()->json(['due_amount' => $due]);
    }
}
