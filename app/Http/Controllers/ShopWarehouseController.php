<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use function Symfony\Component\Mime\Header\all;

class ShopWarehouseController extends Controller
{


    public function index()
    {
        return view('frontend.pages.ShopWarehouse.index',[
            'shops'       => Shop::all(),
            'ware_houses' => Warehouse::all(),
        ]);
    }




    public function create_shop_button()
    {
        return view('frontend.pages.ShopWarehouse.create_shop_button');
    }



    public function store_shop(Request $request)
    {

        // Validation

    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
    ]);


        Shop::newShop($request);
        return back()->with('message', 'Shop info create successfully!');
    }



    public function shop_edit($id)
    {
        return view('frontend.pages.ShopWarehouse.shop_edit',[
            'shop' => Shop::find($id)
        ]);
    }

    public function shop_update(Request $request, $id)
    {

       //  Validation

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);



        Shop::updateShop($request, $id);
        return redirect('/Shop-warehouse')->with('message', 'Shop info update successfully!');
    }


    public function shop_delete($id)
    {
        Shop::deleteShop($id);
        return redirect('/Shop-warehouse');
    }





// Ware house

    public function create_warehouse_button()
    {
        return view('frontend.pages.ShopWarehouse.create_warehouse_button');
    }



    public function store_ware_house(Request $request)
    {

        // Validation

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);


        Warehouse::newWareHouse($request);
        return back()->with('message', 'Warehouse info create successfully!');
    }



    public function ware_house_edit($id)
    {
        return view('frontend.pages.ShopWarehouse.ware_house_edit',[
            'ware_house' => Warehouse::find($id)
        ]);
    }


    public function ware_house_update(Request $request, $id)
    {

    //     Validation

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);



        Warehouse::updateWareHouse($request, $id);
        return redirect('/Shop-warehouse')->with('message', 'Warehouse info update successfully!');
    }


    public function deleteWareHouse($id)
    {
        Warehouse::deleteWareHouse($id);
        return redirect('/Shop-warehouse');
    }







}
