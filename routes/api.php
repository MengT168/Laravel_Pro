<?php

use App\Http\Controllers\UserConapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[UserConapi::class,'register']);
Route::post('/loginSubmit',[UserConapi::class,'loginSubmit'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('get_brand',[UserConapi::class,'getBrand']); 
    Route::get('get_category',[UserConapi::class,'getCategory']); 
    Route::get('get_model',[UserConapi::class,'getModel']);
    Route::get('get_color',[UserConapi::class,'getColor']);
    Route::get('get_income',[UserConapi::class,'getIncome']);
    Route::get('get_car',[UserConapi::class,'getCar']);
    Route::get('get_car_import_price',[UserConapi::class,'getImportCarPrice']);
    Route::get('get_brand_by/{id}',[UserConapi::class,'getBrandById']);
    Route::get('get_category_by/{id}',[UserConapi::class,'getCategoryById']);
    Route::get('get_model_by/{id}',[UserConapi::class,'getModelById']);
    Route::get('get_color_by/{id}',[UserConapi::class,'getColorById']);
    Route::get('get_car_by/{id}',[UserConapi::class,'getCarById']);
    Route::get('get_import_car_price/{id}',[UserConapi::class,'getImportCarPriceById']);
    Route::get('get_sell_car',[UserConapi::class,'getSellCar']);
    Route::get('get_sell_price',[UserConapi::class,'getSellPrice']);
    Route::post('logout', [UserConapi::class, 'logout']);
    Route::post('sell_car', [UserConapi::class, 'sellCar']);
    Route::post('create_customer',[UserConapi::class,'createCustomer']);
    Route::get('get_customer',[UserConapi::class,'getCustomer']);
    Route::get('get_customer_by/{id}',[UserConapi::class,'getCustomerById']);


    Route::middleware('admin')->group(function () {
        Route::get('getuser', [UserConapi::class, 'getUser']);

        Route::post('creat_brand', [UserConapi::class, 'creatBrand']);
        Route::post('creat_category', [UserConapi::class, 'creatCategory']);
        Route::post('creat_model', [UserConapi::class, 'creatModel']);
        Route::post('creat_car', [UserConapi::class, 'creatCar']);
        Route::post('creat_color', [UserConapi::class, 'creatColor']);

        

        Route::post('import_car_price', [UserConapi::class, 'importCarPrice']);
        Route::post('set_sale_price', [UserConapi::class, 'setSalePrice']);

        Route::put('update_brand/{id}', [UserConapi::class, 'updateBrand']);
        Route::put('update_category/{id}', [UserConapi::class, 'updateCategory']);
        Route::put('update_model/{id}', [UserConapi::class, 'updateModel']);
        Route::put('update_color/{id}', [UserConapi::class, 'updateColor']);
        Route::put('update_car/{id}', [UserConapi::class, 'updateCar']);
        Route::put('update_import_price/{id}', [UserConapi::class, 'updateImportPrice']);
        Route::put('update_sale_price', [UserConapi::class, 'updateSalePrice']);
        Route::put('update_customer/{id}', [UserConapi::class, 'updateCustomer']);



        Route::delete('delete_brand/{id}', [UserConapi::class, 'deleteBrand']);
        Route::delete('delete_category/{id}', [UserConapi::class, 'deleteCategory']);
        Route::delete('delete_model/{id}', [UserConapi::class, 'deleteModel']);
        Route::delete('delete_color/{id}', [UserConapi::class, 'deleteColor']);
        Route::delete('delete_car/{id}', [UserConapi::class, 'deleteCar']);
        Route::delete('delete_customer/{id}', [UserConapi::class, 'deleteCustomer']);

        Route::put('access_user/{id}', [UserConapi::class, 'manageUserAccess']);
        
        Route::get('getNewUser', [UserConapi::class, 'userNotAccess']);
    });

  
});
