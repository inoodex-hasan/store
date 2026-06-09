<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin\Location;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Stock;
use App\Models\Brand;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\TransferStock;

class StockController extends Controller
{


    // public function index()
    // {
    //     return view('frontend.pages.stock.index', [
    //         'stocks' => Stock::latest()->paginate(10), // Paginate 10 per page
    //         'products' => Product::all(),
    //         'shops' => Shop::all(),
    //         'warehouses' => Warehouse::all(),
    //     ]);
    // }

    public function index(Request $request)
    {
        $query = Stock::with(['product', 'shop', 'warehouse']);

        // 🔸 Product Filter
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // 🔸 Brand Filter
        if ($request->filled('brand_id')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('brand_id', $request->brand_id);
            });
        }

        // 🔸 Location Filter (shop OR warehouse)
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function ($q) use ($location) {
                $q->whereHas('shop', function ($sub) use ($location) {
                    $sub->where('location', $location);
                })->orWhereHas('warehouse', function ($sub) use ($location) {
                    $sub->where('location', $location);
                });
            });
        }

        // 🔸 Type Filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 🔸 Quantity Filter
        if ($request->filled('quantity')) {
            $query->where('quantity', $request->quantity);
        }

        $stocks = $query->latest()->get();

        $products = Product::all();
        $brands = Brand::all();
        $shops = Shop::all();
        $warehouses = Warehouse::all();
        // 👉 merge shop & warehouse locations into one unique list
        $locations = $shops->pluck('location')->merge($warehouses->pluck('location'))->unique()->values();
        $types = Stock::select('type')->distinct()->pluck('type');

        return view('frontend.pages.stock.index', compact('stocks', 'products', 'brands', 'shops', 'warehouses', 'locations', 'types'));
    }




    public function create_stock(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:1,2',
            'location'    => 'required|string',
            'product_id'  => 'required|integer',
            'quantity'    => 'required|numeric|min:1',
        ]);

        Stock::newStock($request);
        return back()->with('message', 'Stock info create successfully!');
    }


    public function edit($id, $request)
    {
        return view('frontend.pages.stock.index',   [
            'stock'       => Stock::findOrFail($id),
            'stocks'      => Stock::with('product')->get(),
            'products'    => Product::all(),
            'shops'       => Shop::all(),
            'warehouses'  => Warehouse::all(),
        ]);
    }



    public function stockUpdate(Request $request, $id)
    {
        $request->validate([
            'type'        => 'required|in:1,2',
            'location'    => 'required|string',
            'product_id'  => 'required|integer',
            'quantity'    => 'required|numeric|min:1',
        ]);

        Stock::stockUpdate($request, $id);
        return back()->with('message', 'Stock info update successfully!');
    }


    public function stockDelete($id)
    {
        Stock::stockDelete($id);
        return back()->with('message', 'Stock info deleted successfully!');
    }
}
