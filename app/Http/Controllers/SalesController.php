<?php

namespace App\Http\Controllers;

use App\Models\AccountsReceivable;
use Input;
use Validator;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Service;
use Twilio\Rest\Client;
use App\Models\Customer;
use App\Models\DailySale;
use Illuminate\Http\Request;
use App\Mail\CreateSalesMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\Stock;


class SalesController extends Controller
{
public function index(Request $request)
{
    $services = Sale::join('customers', 'customers.id', 'sales.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'sales.sales_by');

    if ($request->from != "" && $request->to != "") {
        $from = date('Y-m-d 00:00:00', strtotime($request->from));
        $to = date('Y-m-d 23:59:59', strtotime($request->to));
        $services = $services->whereBetween('sales.created_at', [$from, $to]);
    }

    if ($request->search_by == 'order_no' && $request->key != "") {
        $services = $services->where('sales.order_no', 'like', '%' . $request->key . '%');
    }

    if (in_array($request->search_by, ['name', 'phone', 'email']) && $request->key != "") {
        $services = $services->where('customers.' . $request->search_by, 'like', '%' . $request->key . '%');
    }

    $services = $services->select(
                    'sales.*',
                    'users.name as sales_by',
                    'customers.name',
                    'customers.phone',
                    'customers.address'
                )
                ->orderBy('id', 'desc')
                ->paginate(10);  // paginate instead of get()

    $users = lib_salesMan();

    if ($request->search_for == 'pdf') {
        $pdf = Pdf::loadView('pdf.sales', compact('services', 'request'))
            ->setPaper('A4', 'portrait');
        return $pdf->download('Sales.pdf');
    }

    // Your existing revenue summaries here (unchanged)
    $todaysRevenue = Service::whereDate('created_at', Carbon::today())->where('status', '1')->sum('bill');
    $thisWeeksRevenue = Service::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', '1')->sum('bill');
    $thisMonthsRevenue = Service::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('status', '1')->sum('bill');
    $thisYearsRevenue = Service::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('status', '1')->sum('bill');
    $totalServiceDues = Service::where('status', '1')->where('due_amount', '>', 0)->sum('due_amount');

    $todaysSalesRevenue = Sale::whereDate('created_at', Carbon::today())->where('status', '1')->sum('bill');
    $thisWeeksSalesRevenue = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', '1')->sum('bill');
    $thisMonthsSalesRevenue = Sale::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('status', '1')->sum('bill');
    $thisYearsSalesRevenue = Sale::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('status', '1')->sum('bill');
    $totalSalesDues = 0;

    $todaysDailySalesRevenue = DailySale::whereDate('date', Carbon::today())->where('status', '1')->sum('total_amount');
    $thisWeeksDailySalesRevenue = DailySale::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', '1')->sum('total_amount');
    $thisMonthsDailySalesRevenue = DailySale::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('status', '1')->sum('total_amount');
    $thisYearsDailySalesRevenue = DailySale::whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('status', '1')->sum('total_amount');

    $monthlyRevenue = Service::selectRaw('MONTH(created_at) as month, SUM(bill) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->where('status', '1')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->mapWithKeys(function ($total, $month) {
            $monthName = Carbon::createFromFormat('m', $month)->format('M');
            return [$monthName => $total];
        });

    $yearlyRevenue = Service::selectRaw('YEAR(created_at) as year, SUM(bill) as total')
        ->whereRaw('YEAR(created_at) >= YEAR(CURDATE()) - 9')
        ->where('status', '1')
        ->groupBy('year')
        ->pluck('total', 'year');

    return view('frontend.pages.sales.index', compact(
        'services',
        'request',
        'users',
        'todaysRevenue',
        'thisWeeksRevenue',
        'thisMonthsRevenue',
        'thisYearsRevenue',
        'monthlyRevenue',
        'yearlyRevenue',
        'todaysSalesRevenue',
        'thisWeeksSalesRevenue',
        'thisMonthsSalesRevenue',
        'thisYearsSalesRevenue',
        'totalServiceDues',
        'totalSalesDues',
        'todaysDailySalesRevenue',
        'thisWeeksDailySalesRevenue',
        'thisMonthsDailySalesRevenue',
        'thisYearsDailySalesRevenue'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users  = User::get();
        $products = Product::with('latestPurchase')->where('status','1')->get();

        //  $categories = Category::where('status','1')->get();


        // Only count shop stock (type = 1)
        $stocks = Stock::selectRaw('product_id, SUM(quantity) as total_quantity')
                ->where('type', 1)          // 1 means Shop
                ->groupBy('product_id')
                ->pluck('total_quantity', 'product_id')
                ->toArray();


       $categories = Category::all();
        
       $cartHtml = (string) view('frontend.pages.sales.cart');
       return view('frontend.pages.sales.create',compact('products','users','cartHtml','categories' , 'stocks'));
    }



    public function addToCart(Request $request){

       
        $request->validate([
            'product'       => 'required|exists:products,id',

        //  'size'          => 'required|exists:sizes,id',
        //  'color'          => 'nullable|exists:colors,id',

            'purchase_price'=> 'nullable|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'qty'           => 'required|integer|min:1',
            'total_price'   => 'required|numeric|min:0',
        ]);

        $productId = $request->product;

     //  $sizeId = $request->size;
    //   $colorId = $request->color;

        $product = Product::findOrFail($productId);

    //  $size = Size::where('id', $sizeId)->firstOrFail();
   //   $color = Color::where('id', $colorId)->first();
  //    $key = "{$request->product}_{$request->size}_{$request->color}";
    

         $key = "{$request->product}";

     // dd($request->all());

    // return $request->all();


        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->qty;
          //  $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id'    => $productId,
                 'product_name'   => $product->name,


             //  'name'     => $product->name,
           //    'unit_id'        => $product->unit?->id,
           //    'unit_name'      => $product->unit?->name,
          //     'size_id'        => $sizeId,
         //      'size_name'      => $size->name,
         //      'color_id'       => $colorId,
        //       'color_name'     => $color? $color->name : 'N/A',
       //        'warranty'       => $request->warranty,
      //         'purchase_price' => $request->purchase_price,

                'unit_price'     => $request->unit_price,
                'quantity'       => $request->qty,
                
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

    public function removeCartItem(Request $request){
        $key = $request->cart_key;
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item deleted successfully!');
    }



    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{

    print_r($request->all());
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|digits:11',
        'address' => 'required|string|max:255',
        'discount' => 'nullable|numeric|min:0',
        'paid_amount' => 'nullable|numeric|min:0',
        'payment_method' => 'nullable|string',
    ]);

    // Get cart from session
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Your Cart is empty!');
    }

    // Validate stock quantity before proceeding
    foreach ($cart as $item) {
        $totalShopStock = Stock::where('product_id', $item['product_id'])
            ->where('type', 1)  // 1 means Shop
            ->sum('quantity');

        if ($totalShopStock < $item['quantity']) {
            return back()->with('error', "Not enough stock for {$item['product_name']}");
        }
    }

    DB::beginTransaction();

    try {
        // Create or get customer
        $customer = Customer::firstOrCreate(
            ['name' => $validated['name'], 'phone' => $validated['phone']],
            ['address' => $validated['address']]
        );

        // Calculate total bill
        $totalBill = 0;
        foreach ($cart as $item) {
            $totalBill += $item['unit_price'] * $item['quantity'];
        }

        $discount = $validated['discount'] ?? 0;
        $payable = $totalBill - $discount;
        $paid = $validated['paid_amount'] ?? 0;
        $due = $payable - $paid;

        // Create Sale record
        $sale = Sale::create([
            'order_no'    => 'INV-' . strtoupper(uniqid()),
            'customer_id' => $customer->id,
            'bill'        => $totalBill,
            'discount'    => $discount,
            'payble'      => $payable,
            'paid_amount' => $paid,
            'due'         => $due,
            'sales_by'    => auth()->id(),
            'status'      => '1',
        ]);

        // Create SalesItem records and deduct stock
        foreach ($cart as $item) {
            SalesItem::create([
                'order_id'    => $sale->id,
                'product_id'  => $item['product_id'],
                'unit_price'  => $item['unit_price'],
                'qty'         => $item['quantity'],
                'total_price' => $item['unit_price'] * $item['quantity'],
            ]);

            // Deduct stock from Shop (type=1)
            $shopStock = Stock::where('product_id', $item['product_id'])
                ->where('type', 1)
                ->orderBy('id')
                ->first();

            if ($shopStock) {
                $qtyBefore = $shopStock->quantity;
                $shopStock->quantity -= $item['quantity'];

                if ($shopStock->quantity <= 0) {
                    $shopStock->delete();
                } else {
                    $shopStock->save();
                }

                // Log stock movement for sale deduction
                \App\Models\StockMovement::log(
                    $item['product_id'],
                    1, // type = Shop
                    $shopStock->location ?? 0,
                    $qtyBefore,
                    -$item['quantity'],
                    'sale',
                    $sale->id
                );
            } else {
                throw new \Exception("Not enough shop stock for product ID {$item['product_id']}");
            }
        }

        // Update or create accounts_receivable record
        $accountReceivable = AccountsReceivable::firstOrCreate(
            ['customer_id' => $customer->id],
            ['due_amount' => 0]
        );

        // Add due amount (payable - paid)
        $accountReceivable->due_amount += $due;
        $accountReceivable->save();

        // If paid amount > 0, create a payment record only (do NOT reduce due again)
        if ($paid > 0) {
            Payment::create([
                'customer_id' => $customer->id,
                'amount' => $paid,
                'sale_id' => $sale->id,
                'payment_method' => $validated['payment_method'] ?? 'cash',
                'payment_for' => 2, // Adjust according to your logic
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Clear cart session
        session()->forget('cart');

        DB::commit();

        return redirect()->route('sales.invoice', $sale->id);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with(['error' => $e->getMessage()]);
    }
}





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sales = Sale::join('customers','customers.id','=','sales.customer_id')
                    ->where('sales.id',$id)
                    ->select('sales.*')
                    ->first();
        if(!$sales)abort(404);
        $users  = User::get();
        $products = Product::where('status','1')->get();

        $customer = Customer::where('id', $sales->customer_id)->first();
        if(!$customer)abort(404);

        $items = SalesItem::where('order_id',  $sales->id) ->get();

        return view('frontend.pages.sales.edit',compact('sales','products','items','customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // return $request->all();
    
      
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'product' => 'required|array',
            'product.*' => 'required|integer|exists:products,id',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
            'unit_price' => 'required|array',
            'unit_price.*' => 'required|numeric|min:1',
            'discount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            
            $customer = Customer::firstOrCreate(
                ['name' => $validated['name'], 'phone' => $validated['phone']],
                ['address' => $validated['address'] ?? null]
            );

            $sale = Sale::where('id', $id)->first();
            if(!$sale)return 'Sales not found.';


            $oldItems = SalesItem::where('order_id', $sale->id)->get();
            foreach ($oldItems as $item) {
                $inventory = Inventory::where('product_id', $item->product_id)->first();
                if ($inventory) {
                    $inventory->current_stock += $item->qty;
                    $inventory->update();
                }
            }

            SalesItem::where('order_id', $sale->id)->delete();

            $totalBill = 0;
            $warranties = Product::wherein('id', $validated['product'])->pluck('id'); // pluck('warranty','id');

            foreach ($validated['product'] as $index => $productId) {
                $qty = $validated['qty'][$index];
                $unitPrice = $validated['unit_price'][$index];

                $total = $unitPrice * $qty;
                $totalBill += $total;

                SalesItem::create([
                    'order_id' => $sale->id,
                    'product_id' => $productId,
                    'unit_price' => $unitPrice,
                    'qty' => $qty,
                    'total_price' => $total,
                    'warranty' => isset($warranties[$productId]) ? $warranties[$productId] : 0,
                ]);

                $inventory = Inventory::where('product_id', $productId)->first();
                if ($inventory) {
                    $inventory->current_stock -= $qty;
                    $inventory->update();
                }
            }

            $discount = $validated['discount'];
            $payble = $totalBill - $discount;

            $sale->update([
                'bill' => $totalBill,
                'discount' => $discount,
                'payble' => $payble,
            ]);

            DB::commit();



            return redirect()->route('sales.invoice', $sale->id);

        } catch (\Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
            return redirect()->back()->with(['error' =>  $e->getMessage()]);
           
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Sale::where('id',$id)->first();
        if(!$service)abort(404);
        $service->delete();

        return redirect()->back()->with(['success' => getNotify(3)]);
    }

    public function makeInvoice(Request $request, $serviceId){
        $sales = Sale::where('id', $serviceId)->first();
        if(!$sales)abort(404);
        $customer = Customer::where('id',$sales->customer_id)->first();
        if(!$customer)abort(404);
        $items = SalesItem::join('products', 'products.id', 'sales_items.product_id')
        ->where('order_id',  $sales->id)
        ->select('sales_items.*','products.name')
        ->get();



        return view('frontend.pages.sales.invoice',compact('sales','items','customer'));
    }

    public function payments(Request $request){ 

        $payments = Payment::where('payment_for', 2);

        $defaultFilter = true;

        if ($request->from != "" && $request->to != "") {
            $from = date('Y-m-d 00:00:00', strtotime($request->from));
            $to = date('Y-m-d 23:59:59', strtotime($request->to));
            $payments = $payments->whereBetween('payments.created_at', [$from, $to]);
            $defaultFilter = false;
        }

        if ($request->payments_method != "") {
            $payments = $payments->where('payments.payment_method_id', $request->payments_method);
            $defaultFilter = false;
        }

        if($defaultFilter){
            $startOfMonth = date('Y-m-01 00:00:00');
            $endOfMonth = date('Y-m-t 23:59:59');
            $payments = $payments->whereBetween('payments.created_at', [$startOfMonth, $endOfMonth]);
        }

        $payments = $payments->get();

        if($request->search_for == 'pdf'){
            $pdf = Pdf::loadView('pdf.service_payments', compact('payments', 'request'))
                ->setPaper('A4', 'portrait');
            return $pdf->download('service Payments.pdf');
        }

        return view('frontend.pages.sales.payments',compact('payments','request'));
    }

    public function report(Request $request)
    {
        $salesQuery = DB::table('sales_items')
            ->join('sales', 'sales.id', '=', 'sales_items.order_id')
            ->join('products', 'products.id', '=', 'sales_items.product_id')
            ->select(
                'products.name as product_name',
                'sales.created_at as sale_date',
                'sales_items.qty',
                'sales_items.unit_price',
                'sales_items.total_price'

           //   'sales_items.color_name',
          //     sales_items.size_name'

            );

        $hasFilters = false;

        if ($request->filled('item_name')) {
            $salesQuery->where('sales_items.product_id', $request->item_name);
            $hasFilters = true;
        }

        if ($request->filled('from')) {
            $salesQuery->whereDate('sales.created_at', '>=', $request->from);
            $hasFilters = true;
        }

        if ($request->filled('to')) {
            $salesQuery->whereDate('sales.created_at', '<=', $request->to);
            $hasFilters = true;
        }

         if (!$hasFilters) {
            $salesQuery->whereBetween('sales.created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        } 

        $salesReport = $salesQuery->orderBy('sales.created_at', 'desc')->get();

        $products = DB::table('products')->select('id', 'name')->get();

        return view('frontend.pages.report.sales.index', [
            'salesReport' => $salesReport,
            'products'    => $products,
            'request'     => $request
        ]);
    }

   public function getSaleDetails($id)
{
    // Get sale info with customer info
    $sale = Sale::select(
        'sales.*',
        'customers.name',
        'customers.phone',
        'customers.address'
    )
    ->join('customers', 'customers.id', '=', 'sales.customer_id')
    ->where('sales.id', $id)
    ->firstOrFail();

    // Get items for this sale with warranty info
    $items = DB::table('sales_items')
        ->select(
            'sales_items.*',
            'products.name',
            'sales_items.unit_price',
            'sales_items.qty',
            'sales_items.total_price'
        )
        ->join('products', 'products.id', '=', 'sales_items.product_id')
        ->where('sales_items.order_id', $id)
        ->get();

    return response()->json([
        'sale' => $sale,
        'items' => $items,
    ]);
}

public function invoice($id)
{
   
    $setting = Setting::first(); // Get your app/company info

    return view('frontend.pages.sales.invoice', compact('setting'));
}

public function history(Request $request)
{
    $query = DB::table('sales_items')
        ->join('sales', 'sales.id', '=', 'sales_items.order_id')
        ->join('products', 'products.id', '=', 'sales_items.product_id')
        ->select(
            'products.name as product_name',
            DB::raw('SUM(sales_items.qty) as total_qty')
        );

    if ($request->filled('date')) {
        $query->whereDate('sales.created_at', $request->date);
    } elseif ($request->filled('from') && $request->filled('to')) {
        $query->whereDate('sales.created_at', '>=', $request->from)
              ->whereDate('sales.created_at', '<=', $request->to . ' 23:59:59');
    }

    if ($request->filled('product_id')) {
        $query->where('sales_items.product_id', $request->product_id);
    }

    $query->groupBy('products.name')
          ->orderBy('total_qty', 'desc');

    $sales = $query->paginate(20);

    $totalProductsSold = DB::table('sales_items')
        ->join('sales', 'sales.id', '=', 'sales_items.order_id')
        ->join('products', 'products.id', '=', 'sales_items.product_id')
        ->when($request->filled('date'), fn($q) => $q->whereDate('sales.created_at', $request->date))
        ->when($request->filled('from') && $request->filled('to'), fn($q) => $q
            ->whereDate('sales.created_at', '>=', $request->from)
            ->whereDate('sales.created_at', '<=', $request->to . ' 23:59:59')
        )
        ->when($request->filled('product_id'), fn($q) => $q->where('sales_items.product_id', $request->product_id))
        ->sum('sales_items.qty');

    $products = DB::table('products')->where('status', '1')->orderBy('name')->get(['id', 'name']);

    return view('frontend.pages.sales.history', compact('sales', 'request', 'totalProductsSold', 'products'));
}


}


