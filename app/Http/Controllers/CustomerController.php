<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use App\Models\Customer;
use Input;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $customers = Customer::paginate(10);
    //     return view('frontend.pages.customer.index', compact('customers'));
    // }

    public function index(Request $request)
    {
        $query = Customer::query();

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by phone
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        // Filter by email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Paginate results
        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('frontend.pages.customer.index', compact('customers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('frontend.pages.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->all();

        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'nullable|email',
            'address' => 'required|string',
        ];

        $validation = Validator::make($attributes, $rules);

        if ($validation->fails()) {
            return redirect()->back()
                ->with(['error' => getNotify(4), 'error_code' => 'edit'])
                ->withErrors($validation)
                ->withInput();
        }

        // Check if customer with phone already exists
        $customer = Customer::where('phone', $request->phone)->first();

        if ($customer) {
            // Update existing customer
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->status = '1';
            $customer->save();

            return redirect()->back()->with(['success' => 'Existing customer updated successfully.']);
        }

        // Else, create a new customer
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->status = '1';
        $customer->save();

        return redirect()->back()->with(['success' => getNotify(1)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('frontend.pages.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attributes = $request->all();
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric|unique:customers,phone,' . $id,
            'email' => 'nullable|email',
            'address' => 'required|string',
        ];
        $validation = Validator::make($attributes, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'edit'])->withErrors($validation)->withInput();
        }

        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->back()->with(['success' => getNotify(2)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->back()->with(['success' => getNotify(3)]);
    }
}
