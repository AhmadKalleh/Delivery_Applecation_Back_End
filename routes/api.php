<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Auth Controller

Route::controller(AuthController::class)->group(function ()
{
    Route::post('/register_pendding','register_pendding_user');

    Route::post('/login','login')   ;

    Route::post('/register','register');

    Route::post('/logout','logout')->middleware('auth:sanctum');

});

// Store Controller
Route::controller(StoreController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {
        Route::get('/stores','index')->middleware('can:index-store');

        Route::post('/stores','store')->middleware('can:create-store');

        Route::post('/stores_update','update')->middleware('can:update-store');

        Route::delete('/stores','destroy')->middleware('can:delete-store');

    });
});


// Product Controller
Route::controller(ProductController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {
        Route::get('/products/{storeId}','index')->middleware('can:index-product');

        Route::get('/search','search');

        Route::post('/products','store')->middleware('can:create-product');

        Route::get('/products_show','show')->middleware('can:show-product');

        Route::post('/products_update','update')->middleware('can:update-product');

        Route::delete('/products','destroy')->middleware('can:delete-product');
    });

});



// User Controller

Route::controller(UserController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {
        Route::get('/show','show')->middleware('can:show-user');

        Route::post('/update_phone','update_user_phone_number')->middleware('can:update-user');

        Route::get('/check_password','check_password');

        Route::post('/update_password','update_user_password')->middleware('can:update-user');

        Route::post('/update_image_profile','update_image_profile')->middleware('can:update-user');

        Route::delete('/delete_user','destroy')->middleware('can:delete-user');
    });

});


// Cart Controller

Route::controller(CartController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {

        Route::get('/carts','index')->middleware('can:index-cart');

        Route::post('/carts','store')->middleware('can:create-cart');

        Route::post('/carts_update','update')->middleware('can:update-cart');

        Route::delete('/carts','destroy')->middleware('can:delete-cart');
    });
});



// Address Controller

Route::controller(AddressController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {

        Route::get('/addresses','index')->middleware('can:index-address');

        Route::post('/addresses','store')->middleware('can:create-address');

        Route::post('/addresses_update','update')->middleware('can:update-address');

        Route::get('/addresses_show','show')->middleware('can:show-address');

        Route::delete('/addresses','destroy')->middleware('can:delete-address');
    });

});


// Favorite Controller
Route::controller(FavoriteController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {
        Route::get('/favorites','index')->middleware('can:index-favorite');

        Route::post('/favorites','store')->middleware('can:create-favorite');

        Route::post('/favorites_update')->middleware('can:update-favorite');

        Route::get('/favorites_show','show')->middleware('can:show-favorite');

        Route::delete('/favorites','destroy')->middleware('can:delete-favorite');
    });

});


// Order Controller
Route::controller(OrderController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {
        Route::get('/orders','index')->middleware('can:index-order');

        Route::post('/orders','store')->middleware('can:create-order');

        Route::post('/orders_update','update')->middleware('can:update-order');

        Route::get('/orders_show','show')->middleware('can:show-order');

        Route::delete('/orders','destroy')->middleware('can:delete-order');
    });

});


// Notification Controller

Route::controller(NotificationController::class)->group(function ()
{
    Route::middleware('auth:sanctum')->group(function ()
    {
        Route::get('/notifications','index')->middleware('can:index-notification');
    });

});



// dd($request->headers->all());
Route::get('/test',function (Request $request)
{
    //dd($request->headers->all());
    $token = $request->header('Authorization');
    return response()->json(['token_received' => $token]);
});

// Route::get('/test2',function (Request $request)
// {
//     $allData = [
//         'headers' => $request->headers->all(),
//         'body' => $request->all()
//     ];

//     return response()->json($allData);
// });
