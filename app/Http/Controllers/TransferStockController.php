<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use App\Models\TransferStock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferStockController extends Controller
{

    // public function index()
    // {
    //     return view('frontend.pages.transfer_stock.index',[

    //         'transfer_stocks' => TransferStock::with([
    //          'product',
    //          'fromWarehouse',
    //           'toShop'
    //         ])->latest()->paginate(10),

    //        // 'transfer_stocks' => TransferStock::all(),

    //     ]);
    // }

    public function index(Request $request)
    {
        $query = TransferStock::with(['product', 'warehouse', 'shop']);

        // Filter by Product    
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by Source (Warehouse)
        if ($request->filled('stock_from')) {
            $warehouse_id = $request->stock_from;
            $query->where('stock_from', $warehouse_id);
        }

        // Filter by Destination (Shop)
        if ($request->filled('stock_to')) {
            $shop_id = $request->stock_to;
            $query->where('stock_to', $shop_id);
        }

        // Filter by Quantity (minimum)
        if ($request->filled('quantity')) {
            $query->where('quantity', '>=', $request->quantity);
        }

        $transfer_stocks = $query->latest()->paginate(10)->withQueryString();

        $products = Product::all();
        $warehouses = Warehouse::all();
        $shops = Shop::all();

        return view('frontend.pages.transfer_stock.index', compact('transfer_stocks', 'products', 'warehouses', 'shops'));
    }





    // NaYeem***** -> The authenticated user's assigned shop (for stock destination)

    /**
     * Displays the transfer stock form with:
     * - All warehouses (for stock sources)
     * - The authenticated user's assigned shop (for stock destination)
     * - All products (for selection)
     */

    public function create_transfer_stock() // button show page
    {
        return view('frontend.pages.transfer_stock.create_transfer_stock', [

            $user = Auth::user(),                //  Show Only one Shop

            'warehouses' => Warehouse::all(),   // For "stock from" options

            //     'shops'      => Shop::all(),

            'products'   => Product::all(),       // For product selection
            'user_shop' => $user->primaryShop(),  // Get user's primary shop ,,,Only the user's managed shop

        ]);
    }

    // NaYeem***** -> The authenticated user's assigned shop (for stock destination)




    public function store_transfer_stock(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock_from' => 'required|exists:warehouses,id',
            'stock_to'   => 'required|exists:shops,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        try {
            // Simply call the model method
            TransferStock::transfer($validated);
            return back()->with('success', 'Stock transferred successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }



    //    public function transfer_stock_edit($id)
    //    {
    //        return view('frontend.pages.transfer_stock.edit',[
    //
    //            'transfer_stock' => TransferStock::findOrFail($id),
    //
    //            'warehouses' => Warehouse::all(),
    //            'shops'      => Shop::all(),
    //            'products'   => Product::all(),
    //        ]);
    //    }



}
