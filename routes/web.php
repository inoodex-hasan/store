<?php

use App\Http\Controllers\AccountReceivableController;
use App\Models\Extra;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use App\Models\Admin\DelivaryCharge;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProductContoller;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ExpenseController;
// use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaytrailController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\PaymentController;


use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShopWarehouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransferStockController;





Route::middleware(['auth'])->group(function () {

    Route::get('/', [FrontendController::class, 'index'])->name('index');

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    //Product Management
    Route::group(['middleware' => ['permission:Product Management']], function () {
        Route::prefix('product')->middleware(['auth'])->group(function () {
            Route::resource('products', ProductContoller::class);



            // for new sales system
            Route::get('get_product_size_and_color', [ProductContoller::class, 'getSizeColor'])->name('products.getSizeAndColor');
            Route::get('/products/details', [ProductContoller::class, 'productDetails'])->name('products.details');






            // Category
            Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
            Route::get('/category-create', [CategoryController::class, 'create_category_button'])->name('category.create');

            Route::post('/category/new', [CategoryController::class, 'category_store'])->name('category.new');


            Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');
            Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
            // Category End

        });
        Route::resource('brands', BrandController::class);
    });




    //Customer Management
    Route::group(['middleware' => ['permission:Customer Management']], function () {
        Route::middleware(['auth'])->group(function () {
            Route::resource('customers', CustomerController::class);
        });
    });


    //Vendor Management
    Route::group(['middleware' => ['permission:Vendor Management']], function () {
        Route::middleware(['auth'])->group(function () {
            Route::resource('vendors', VendorController::class);
        });
    });



    //Purchase  Management
    Route::group(['middleware' => ['permission:Purchase Management']], function () {
        Route::prefix('purchase')->middleware(['auth'])->group(function () {
            Route::resource('purchase', PurchaseController::class);
            Route::get('latest-price/{id}', [PurchaseController::class, 'getLatestPrice'])->name('purchase.latest_price');
        });
    });



    //Inventory Management And Stock
    Route::group(['middleware' => ['permission:Inventory Management']], function () {
        Route::prefix('inventory')->middleware(['auth'])->group(function () {

            Route::resource('inventory', InventoryController::class);




            // Start Stock Management
            Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
            //  Route::get('/stock-create', [StockController::class, 'create_setting_button'])->name('stock.create');

            Route::post('/stock-new', [StockController::class, 'create_stock'])->name('stock.new');


            Route::get('/stock/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
            Route::post('/stock/update/{id}', [StockController::class, 'stockUpdate'])->name('stock.update');
            Route::delete('/stock/delete/{id}', [StockController::class, 'stockDelete'])->name('stock.delete');
            // End Stock Management
        });
    });





    // Order Management
    Route::group(['middleware' => ['permission:content-management']], function () {
        Route::resource('slider', SliderController::class);
        Route::resource('home-ad', AdsController::class);
    });



    Route::group(['middleware' => ['permission:Administration']], function () {
        Route::resource('users', UserController::class);
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);




        // settings Start
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting-create', [SettingController::class, 'create_setting_button'])->name('setting.create');

        Route::post('/setting/new', [SettingController::class, 'store'])->name('setting.new');


        Route::get('/setting/edit/{id}', [SettingController::class, 'edit'])->name('setting.edit');
        Route::post('/setting/update/{id}', [SettingController::class, 'update'])->name('setting.update');
        Route::delete('/setting/delete/{id}', [SettingController::class, 'delete'])->name('setting.delete');
        // settings End



        // Start Shop
        Route::get('/Shop-warehouse', [ShopWarehouseController::class, 'index'])->name('Shop-warehouse.index'); // shop and warehouse
        Route::get('/Shop-create', [ShopWarehouseController::class, 'create_shop_button'])->name('Shop.create');

        Route::post('/Shop-new', [ShopWarehouseController::class, 'store_shop'])->name('Shop.new');
        Route::get('/Shop-edit/{id}', [ShopWarehouseController::class, 'shop_edit'])->name('Shop.edit');
        Route::post('/Shop-update/{id}', [ShopWarehouseController::class, 'shop_update'])->name('Shop.update');
        Route::delete('/Shop-delete/{id}', [ShopWarehouseController::class, 'shop_delete'])->name('Shop.delete');
        // End Shop


        // Start Warehouse
        Route::get('/warehouse-create', [ShopWarehouseController::class, 'create_warehouse_button'])->name('warehouse.create');

        Route::post('/warehouse-new', [ShopWarehouseController::class, 'store_ware_house'])->name('warehouse.new');
        Route::get('/warehouse-edit/{id}', [ShopWarehouseController::class, 'ware_house_edit'])->name('warehouse.edit');
        Route::post('/warehouse-update/{id}', [ShopWarehouseController::class, 'ware_house_update'])->name('warehouse.update');
        Route::delete('/warehouse-delete/{id}', [ShopWarehouseController::class, 'deleteWareHouse'])->name('warehouse.delete');
        // End Warehouse


        // Start User Manage

        Route::get('/user-manage', [UserManageController::class, 'index'])->name('user-manage.index');
        Route::get('/user-create', [UserManageController::class, 'create_user_manage_button'])->name('user-manage.create');


        Route::get('/get-user-role/{id}', [UserManageController::class, 'getUserRole']); // ajax/jquery auto fetch


        Route::post('/user-new', [UserManageController::class, 'storeUserManage'])->name('user-manage.new');
        Route::get('/user-edit/{id}', [UserManageController::class, 'user_manage_edit'])->name('user-manage.edit');




        Route::post('/user-update/{id}', [UserManageController::class, 'user_manage_update'])->name('user-manage.update');
        Route::delete('/user-delete/{id}', [UserManageController::class, 'user_manage_delete'])->name('user-manage.delete');


        // End User Manage





        Route::resource('attendance', AttendanceController::class);

        Route::get('/user/pin', [UserController::class, 'pin'])->name('users.pin');
        Route::post('/user/pin', [UserController::class, 'pinStore'])->name('users.pin_store');
    });



    Route::group(['middleware' => ['permission:Service Management']], function () {
        Route::resource('service', ServiceController::class);
        Route::get('service/invoice/{id}', [ServiceController::class, 'makeInvoice'])->name('service.invoice');
        Route::get('complated/service', [ServiceController::class, 'complatedService'])->name('service.complated');
        Route::post('service/makecomplate/{id}', [ServiceController::class, 'makeComplate'])->name('service.makecomplate');
        Route::get('service-payments', [ServiceController::class, 'payments'])->name('service.payments');
        Route::post('/submit-rating', [ServiceController::class, 'storeRating'])->name('submit.rating');
    });









    Route::group(['middleware' => ['permission:Sales Management']], function () {

        Route::resource('sales', SalesController::class);
        // Route::get('sales/invoice/{id}', [SalesController::class, 'makeInvoice'])->name('sales.invoice');
        Route::get('sales-payments', [SalesController::class, 'payments'])->name('sales.payments');
        Route::get('sales/{id}/details', [SalesController::class, 'getSaleDetails'])->name('sales.details');
        Route::get('/sales/invoice/{id}', [SalesController::class, 'makeInvoice'])->name('sales.invoice');
        Route::get('sales-history', [SalesController::class, 'history'])->name('sales.history');




        // for new sales system
        Route::post('cart/store', [SalesController::class, 'addToCart'])->name('cart.store');
        Route::post('cart/remove_item', [SalesController::class, 'removeCartItem'])->name('cart.remove_item');
        // for new sales system




        //***** Start Transfer Stock Management

        Route::get('transfer-stock', [TransferStockController::class, 'index'])->name('transfer_stock.index');
        Route::get('/create-transfer-stock', [TransferStockController::class, 'create_transfer_stock'])->name('transfer_stock.create');

        Route::post('/transfer-stock-new', [TransferStockController::class, 'store_transfer_stock'])->name('transfer_stock.new');

        //  Route::get('/transfer-stock-edit/{id}', [TransferStockController::class, 'transfer_stock_edit'])->name('transfer_stock.edit'); /*** No Needed!!!

        //     Route::post('/transfer-stock-update/{id}', [TransferStockController::class, 'user_manage_update'])->name('transfer_stock.update'); /*** No Needed!!!

        //  Route::delete('/transfer-stock-delete/{id}', [TransferStockController::class, 'user_manage_delete'])->name('transfer_stock.delete'); /*** No Needed!!!


        //***** End Transfer Stock Management

    });










    Route::group(['middleware' => ['permission:Report Management']], function () {
        Route::get('purchase-report', [PurchaseController::class, 'reportIndex'])->name('purchase.report');
        Route::get('purchase/report', [PurchaseController::class, 'report'])->name('purchase.report.get');
        Route::get('sales-report', [SalesController::class, 'report'])->name('sales.report');
    });

    Route::group(['middleware' => ['permission:Report Management']], function () {
        Route::resource('expense-categories', ExpenseCategoryController::class);
        Route::resource('dailyExpenses', ExpenseController::class);
    });
    Route::resource('dailySales', DailySaleController::class);
    Route::resource('salesTarget', SalesTargetController::class);





    // Route::group(['middleware' => ['permission:Service Management|Sales Management']], function () {
    //     Route::get('payments/{id}/{payment_for}', [PaymentController::class, 'payments'])->name('payments');
    //     Route::post('add/payment', [PaymentController::class, 'addPayment'])->name('add.payment');
    //     Route::post('update/payment/{id}', [PaymentController::class, 'updatePayment'])->name('update.payment');
    //     Route::delete('delete/payment/{id}', [PaymentController::class, 'deletePayment'])->name('delete.payment');
    //     Route::resource('products', ProductContoller::class);
    //       Route::get('/payments', [PaymentController::class, 'payments']);
    // });


    // for payments
    Route::resource('payments', PaymentController::class);


    Route::get('/account-receivable', [AccountReceivableController::class, 'index'])->name('account-receivable.index');


    Route::get('/accounts-receivable/{customerId}', action: [AccountReceivableController::class, 'showDue'])->name('accounts_receivable.show');

    Route::post('/accounts-receivable/payment', [AccountReceivableController::class, 'makePayment'])->name('accounts_receivable.payment');
    Route::get('/customer-due/{id}', [PaymentController::class, 'getCustomerDue']);


    // web.php (routes)
    Route::get('/receivables/history/{customer}', [AccountReceivableController::class, 'history'])->name('receivables.history');

    // Product Returns
    Route::group(['middleware' => ['permission:Sales Management']], function () {
        Route::get('returns', [ReturnController::class, 'index'])->name('returns.index');
        Route::get('returns/create', [ReturnController::class, 'create'])->name('returns.create');
        Route::post('returns', [ReturnController::class, 'store'])->name('returns.store');
        Route::get('returns/sale-items/{saleId}', [ReturnController::class, 'getSaleItems'])->name('returns.sale.items');
        Route::get('returns/{id}', [ReturnController::class, 'show'])->name('returns.show');
        Route::delete('returns/{id}', [ReturnController::class, 'destroy'])->name('returns.destroy');
        Route::patch('returns/{id}/approve', [ReturnController::class, 'approve'])->name('returns.approve');
        Route::patch('returns/{id}/complete', [ReturnController::class, 'complete'])->name('returns.complete');
        Route::patch('returns/{id}/reject', [ReturnController::class, 'reject'])->name('returns.reject');
    });
});


Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
