<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CompanyControler;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryHistoryController;
use App\Http\Controllers\ProductBatchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductIdentifierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\UserProductController;
use App\Models\CustomerRemote;
use App\Models\ProductIdentifier;
use App\Models\TerminalRemote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/status', 'UserController@show');


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Auth::routes([ 'register' => false ]);

Route::get('/', function () {
    return redirect(route('login'));
});


Route::get('/app-up', function () {
    Artisan::call('up');
    return redirect('/');
});

Route::get('/app-down', function () {
    Artisan::call('down --secret="Ridoy@00753"');
    return redirect('/');
});

Route::get('/test', function () {
   // return CustomerRemote::select('CustomerID','CustomerName','ProviderID','CustomerCode','CustomerAlertSMSRecipient','CustomerAlertEmailRecipient')->get();
    //     $ProudctIden = ProductIdentifier::all();
    //     foreach($ProudctIden as $Proudct) {
    //         DB::connection('mysql2')->table('product_identifiers')
    //             ->where('secondary_code', $Proudct->secondary_code)
    //             ->update(['code' => $Proudct->code]);
    //     }
    // //    return DB::connection('mysql2')->table('product_identifiers')->get();
    //     // return CustomerRemote::take(10)->get();
    return redirect(route('login'));
});



Route::middleware(['auth'])->group(function () {

    //user router list
    Route::prefix('dashboard')->group(function(){
        Route::name('user.')->group(function(){
            Route::get('/',[DashboardController::class,'index'])->name('dashboard');
            Route::get('/profile',[DashboardController::class, 'profile'])->name('profile');
            Route::post('/profile/update',[DashboardController::class, 'update'])->name('profile.update');
        });
    });

    Route::resource('companies', CompanyControler::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    Route::resource('units', UnitController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('inventory-histories', InventoryHistoryController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('requisitions', RequisitionController::class);
    Route::resource('user-products', UserProductController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);

    Route::resource('product-batches', ProductBatchController::class);
    Route::resource('product-identifiers', ProductIdentifierController::class);
    Route::post('product-identifiers-datatable', [ProductIdentifierController::class, 'datatable'])->name('product-identifiers.datatable');

});

//sync
Route::prefix('sync')->group(function(){
    Route::name('sync.')->group(function(){
        Route::get('indentifier', [SyncController::class, 'identifier'])->name('indentifier');
        Route::get('customer', [SyncController::class, 'customer'])->name('customer');
    });
});
