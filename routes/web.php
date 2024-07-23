<?php

use App\Http\Controllers\backend\backController;
use App\Http\Controllers\frontend\frontController;
use App\Http\Controllers\ManageController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/',[frontController::class,'login'])->name('login');
Route::get('/register',[frontController::class,'signUp']);


Route::post('/registerSubmit',[backController::class,'registerSubmit']);
Route::post('/loginSubmit',[backController::class,'loginSubmit']);


Route::get('/logout', [backController::class,'logout'])->name('logout');




Route::group(['middleware'=>'admin'],function(){
   Route::get('/admin/dashboard',[frontController::class,'dashboard1']);



   Route::get('/admin/new_category',[frontController::class,'newCategory']);
   Route::get('/admin/list_category',[frontController::class,'listCategory']);


   Route::get('/admin/new_brand',[frontController::class,'newBrand']);
   Route::get('/admin/list_brand',[frontController::class,'listBrand']);


   Route::get('/admin/new_model',[frontController::class,'newModel']);
   Route::get('/admin/list_model',[frontController::class,'listModel']);


   Route::get('/admin/manage_users',[frontController::class,'manageUsers']);
   Route::get('/admin/list_users',[frontController::class,'listUsers']);
   
   
   Route::get('/admin/new_color',[frontController::class,'newColor']);
   Route::get('/admin/list_color',[frontController::class,'listColor']);


   Route::get('/admin/new_car',[frontController::class,'newCar']);
   Route::get('/admin/list_car',[frontController::class,'listCar']);
   Route::get('/admin/sold_car', [frontController::class, 'listSoldCar']);
   Route::get('/admin/detail/{id}', [frontController::class, 'detailCar']);


   Route::get('/admin/import_car',[frontController::class,'importCar']);
   Route::get('/admin/list_import',[frontController::class,'listImport']);

   Route::get('/admin/set_sale_price', [frontController::class, 'setSalePrrice']);
   Route::get('/admin/list_set', [frontController::class, 'listSet']);


   Route::get('/admin/new_sale', [frontController::class, 'newSale']);
   Route::get('/admin/list_sale', [frontController::class, 'listSale']);


   Route::get('/admin/new_customer',[frontController::class,'newCustomer']);


   
   Route::get('/admin/list_income', [frontController::class, 'listIncome']);



   Route::get('/admin/list_customer',[frontController::class,'listCustomer']);

   


   Route::get('/admin/edit_carcate/{id}',[frontController::class,'UpdateCate']);
   Route::get('/admin/edit_brand/{id}',[frontController::class,'UpdateBrand']);
   Route::get('/admin/edit_model/{id}',[frontController::class,'UpdateModel']);
   Route::get('/admin/edit_users/{id}',[backController::class,'UpdateUser']); 
   Route::get('/admin/edit_color/{id}',[frontController::class,'UpdateColor']); 
   Route::get('/admin/edit_car/{id}',[frontController::class,'UpdateCar']);
   Route::get('/admin/update_users/{id}',[frontController::class,'UpdateUser']);
   Route::get('/admin/edit_importCar/{id}',[frontController::class,'UpdateImport']);
   Route::get('/admin/edit_saleprice/{id}',[frontController::class,'UpdateSalePrice']);
   // Route::get('/admin/edit_sale/{id}',[frontController::class,'UpdateSaleCar']);
   Route::get('/admin/edit_customer/{id}',[frontController::class,'UpdateCustomer']);



   Route::get('/admin/delete_car_cate/{id}',[backController::class,'deleteCate']);
   Route::get('/admin/delete_brand/{id}',[backController::class,'deleteBrand']);
   Route::get('/admin/delete_model/{id}',[backController::class,'deleteModel']);
   Route::get('/admin/delete_users/{id}',[backController::class,'deleteUsers']);
   Route::get('/admin/delete_color/{id}',[backController::class,'deleteColor']);
   Route::get('/admin/delete_customer/{id}',[backController::class,'deleteCustomer']);
   


   Route::post('/admin/categorySubmit',[backController::class,'categorySubmit']);
   Route::post('/admin/brandSubmit',[backController::class,'brandSubmit']);
   Route::post('/admin/modelSubmit',[backController::class,'modelSubmit']);
   Route::post('/admin/colorSubmit',[backController::class,'colorSubmit']);
   Route::post('/admin/carSubmit',[backController::class,'carSubmit']);
   Route::post('/admin/sale',[backController::class,'saleSubmit']);


   Route::post('/admin/customerSubmit',[backController::class,'customerSubmit']);


   Route::post('/admin/updateCategorySubmit',[backController::class,'updateCategorySubmit']);
   Route::post('/admin/updateBrandSubmit',[backController::class,'updateBrandSubmit']);
   Route::post('/admin/updateModelSubmit',[backController::class,'updateModelSubmit']);
   Route::post('/admin/updateColorSubmit',[backController::class,'updateColorSubmit']);
   Route::post('/admin/UpdatecarSubmit',[backController::class,'updateCarSubmit']);
   Route::post('/admin/importSubmit',[backController::class,'importSubmit']);
   Route::post('/admin/set_sale_price',[backController::class,'setSalePrice']);
   Route::post('/admin/UpdateUserSubmit',[backController::class,'updateUsersSubmit']);
   Route::post('/admin/UpdateimportSubmit',[backController::class,'updateImportSubmit']);
   Route::post('/admin/updateSaleSubmit',[backController::class,'updateSaleSubmit']);


   Route::post('/admin/updateCustomerSubmit',[backController::class,'updateCustomerSubmit']);
});

Route::group(['middleware'=>'user'],function(){
   Route::get('/user/dashboard',[frontController::class,'dashboard']);
   Route::get('/user/list_income', [frontController::class, 'listIncomeUser']);

   Route::get('/user/list_category',[frontController::class,'listCategoryUser']);
   Route::get('/user/list_brand',[frontController::class,'listBrandUser']);
   Route::get('/user/list_model',[frontController::class,'listModelUser']);
   Route::get('/user/list_color',[frontController::class,'listColorUser']);
   Route::get('/user/list_car',[frontController::class,'listCarUser']);
   Route::get('/user/list_import',[frontController::class,'listImportUser']);
   Route::get('/user/list_set', [frontController::class, 'listSetUser']);
   Route::get('/user/sold_car', [frontController::class, 'listSoldCarUser']);
   Route::get('/user/new_sale', [frontController::class, 'newSaleUser']);
   Route::get('/user/list_sale', [frontController::class, 'listSaleUser']);
   Route::get('/user/detail/{id}', [frontController::class, 'detailCarUser']);

   Route::post('/user/sale',[backController::class,'saleSubmitUser']);
   Route::post('/user/updateCustomerSubmit',[backController::class,'updateCustomerSubmitUser']);
   Route::get('/user/new_customer',[frontController::class,'newCustomerUser']);
   Route::get('/user/edit_customer/{id}',[frontController::class,'UpdateCustomerUser']);
   Route::get('/user/list_customer',[frontController::class,'listCustomerUser']);
   Route::post('/user/customerSubmit',[backController::class,'customerSubmitUser']);
});