<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountsReceivable;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AccountReceivableController extends Controller
{
    //     public function index()
    // {
    //     $receivables = AccountsReceivable::with('customer')->paginate(10);
    //     return view('frontend.pages.account-receivable.index', compact('receivables'));
    // }

    public function index(Request $request)
    {
        $query = AccountsReceivable::with('customer');

        if ($request->filled('customer_name')) {
            $name = $request->customer_name;
            $query->whereHas('customer', function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%");
            });
        }

        if ($request->filled('due_amount')) {
            $query->where('due_amount', '>=', $request->due_amount);
        }

        $receivables = $query->latest()->paginate(10);

        return view('frontend.pages.account-receivable.index', compact('receivables'));
    }


    public function showDue($customerId)
    {
        $accountReceivable = AccountsReceivable::with('customer')
            ->where('customer_id', $customerId)
            ->first();

        $payments = Payment::where('customer_id', $customerId)->orderBy('created_at', 'desc')->get();

        return view('frontend.pages.account-receivable.due', compact('accountReceivable', 'payments'));
    }




    public function makePayment(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $accountReceivable = AccountsReceivable::where('customer_id', $request->customer_id)->first();

            if (!$accountReceivable) {
                return back()->with('error', 'Account receivable not found.');
            }

            $newDue = $accountReceivable->total_due - $request->amount;

            if ($newDue < 0) {
                return back()->with('error', 'Payment amount exceeds due amount.');
            }


            Payment::create([
                'customer_id' => $request->customer_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_for' => 2,
                'payment_date' => now(),
            ]);


            $accountReceivable->total_due = $newDue;
            $accountReceivable->updated_at = now();
            $accountReceivable->save();

            DB::commit();

            return redirect()->back()->with('success', 'Payment successful and due updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }



    public function history($customerId)
    {
        $customer = \App\Models\Customer::findOrFail($customerId);
        $payments = \App\Models\Payment::where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.account-receivable.history', compact('customer', 'payments'));
    }
}
