<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class frontController extends Controller
{
    public function login(){
        return view('loginView');
    }

    public function signUp(){
        return view('register',);
    }

    public function dashboard(){
        

        $userRows = DB::table('users')->where('status', null)->count();
        $car = DB::table('car')->where('status', 'Available')->count();
        $carSold = DB::table('car')->where('status', 'Unavailable')->count();
        $model = DB::table('model')->count();
        $income = DB::table('income')->where('authorId',Auth::user()->id)->sum('profit');
        
        return view('User.Dashboard', [
            'userRows' => $userRows,
            'car' => $car,
            'sold' => $carSold,
            'model' => $model,
            'income' => $income
        ]);
    }
    public function dashboard1(){
        
        $userRows = DB::table('users')->where('status', null)->count();
        $car = DB::table('car')->where('status', 'Available')->count();
        $carSold = DB::table('car')->where('status', 'Unavailable')->count();
        $model = DB::table('model')->count();
        $income = DB::table('income')->sum('profit');
        
        return view('Admin.Dashboard', [
            'userRows' => $userRows,
            'car' => $car,
            'sold' => $carSold,
            'model' => $model,
            'income' => $income
        ]);
    }
    

// ==================================================================================================================================


    public function newCategory(){
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Category.new_category',['userRows'=>$userRows]);
    }

    public function newBrand(){
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Brand.new_brand',['userRows'=>$userRows]);
    }
  public function newModel(){
        $DbBrand = DB::table('brand')->get();
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Model.new_model',['brand'=>$DbBrand,'userRows'=>$userRows]);
    }
 public function newColor(){
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Color.new_color',['userRows'=>$userRows]);
    }
public function newCar(){
        $DbModel = DB::table('model')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
        ->select('brand.brandName', 'model.*')
        ->orderByDesc('brand.id')
        ->get();
        $DbColor = DB::table('color')->get();
        $DbCate = DB::table('category')->get();
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Car.new_car',['userRows'=>$userRows , 'model'=>$DbModel , 'color'=>$DbColor , 'cate'=>$DbCate] );
    }
 public function importCar(){
        $userRows = DB::table('users')->where('status', null)->count();
        $importedCarIds = DB::table('importcar')->pluck('carId')->toArray();
        $car = DB::table('car')
        ->leftJoin('model','model.id','car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
        ->leftJoin('color','color.id','car.colorId')
        ->leftJoin('category','category.id','car.categoryId')
        ->select('model.modelName','brand.brandName', 'category.categoryName' ,'color.colorName','car.*')
        ->whereNotIn('car.id', $importedCarIds)
        ->get();
        return view('Admin.Import.import_car',['userRows'=>$userRows , 'importCar'=>$car]);
    }
    public function setSalePrrice()
    {
        $userRows = DB::table('users')->where('status', null)->count();
        $importedCarIds = DB::table('set_sale_price')->pluck('carId')->toArray();
        
        // Fetch the car details along with import price
        $cars = DB::table('car')
            ->leftJoin('model', 'model.id', '=', 'car.modelId')
            ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
            ->leftJoin('color', 'color.id', '=', 'car.colorId')
            ->leftJoin('category', 'category.id', '=', 'car.categoryId')
            ->leftJoin('importcar', 'importcar.carId', '=', 'car.id') // Join with importcar table
            ->select(
                'model.modelName', 
                'brand.brandName', 
                'category.categoryName', 
                'color.colorName', 
                'car.*', 
                'importcar.importPrice' // Select import price
            )
            ->whereNotIn('car.id', $importedCarIds)
            ->get();
    
        return view('Admin.Price.sale_price', [
            'userRows' => $userRows,
            'cars' => $cars
        ]);
    }
    public function newSale(){
        // Count users where status is null
        $userRows = DB::table('users')->where('status', null)->count();
    
        // Get all car IDs from the sale_detail table
        $sale_detail = DB::table('sale_detail')->pluck('carId')->toArray();
    
        // Query for car details with multiple left joins
        $car = DB::table('car')
            ->leftJoin('model', 'model.id', '=', 'car.modelId')
            ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
            ->leftJoin('color', 'color.id', '=', 'car.colorId')
            ->leftJoin('category', 'category.id', '=', 'car.categoryId')
            ->select(
                'model.modelName',
                'brand.brandName',
                'category.categoryName',
                'color.colorName',
                'car.*'
            )
            ->whereNotIn('car.id', $sale_detail)
            ->get();
    
        // Get sale prices with carId as key
        $sale_prices = DB::table('set_sale_price')
            ->select('carId', 'setSalePrice')
            ->pluck('setSalePrice', 'carId')->toArray();
    
        // Query for sale details with customer information
        $sale_details_with_customers = DB::table('customer')->get();
    
        // Pass the data to the view
        return view('Admin.Sale.sale_car', [
            'userRows' => $userRows,
            'Car' => $car,
            'sale_prices' => $sale_prices,
            'sale_details_with_customers' => $sale_details_with_customers
        ]);
    }
    

    public function newCustomer(){
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Customer.customer',['userRows'=>$userRows]);
    }

// ==================================================================================================================================

    public function listCategory(){
        $DbCate = DB::table('category')
                                                ->leftJoin('users','users.id','category.authorId')
                                                ->select('users.name','category.*')
                                                ->orderBy('category.id')
                                                ->get();
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Category.List_category',['cate'=>$DbCate,'userRows'=>$userRows]);
    }

    public function listColor(){
        $DbColor = DB::table('color')
                                                ->leftJoin('users','users.id','color.authorId')
                                                ->select('users.name','color.*')
                                                ->orderBy('color.id')
                                                ->get();
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Color.List_color',['color'=>$DbColor,'userRows'=>$userRows]);
    }


    public function listBrand(){
        $DbBrand = DB::table('brand')
                                                ->leftJoin('users','users.id','brand.authorId')
                                                ->select('users.name','brand.*')
                                                ->orderBy('brand.id')
                                                ->get();
        $userRows = DB::table('users')->where('status', null)->count();                                        
        return view('Admin.Brand.List_brand',['brand'=>$DbBrand,'userRows'=>$userRows]);
    }
public function listModel(){
        $DbModel = DB::table('model')
                                                ->leftJoin('brand','brand.id','model.brandId')
                                                ->leftJoin('users','users.id','model.authorId')
                                                ->select('users.name', 'brand.brandName' ,'model.*')
                                                ->orderByDesc('model.id')
                                                ->get();
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Model.List_model',['model'=>$DbModel,'userRows'=>$userRows]);
    }
public function listCar(Request $request){
    $userRows = DB::table('users')->where('status', null)->count();

    $model = DB::table('model')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
        ->select('brand.id as brandId', 'brand.brandName', 'model.id as modelId', 'model.modelName')
        ->get();

    $query = DB::table('car')
        ->leftJoin('model', 'model.id', '=', 'car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
        ->leftJoin('color', 'color.id', '=', 'car.colorId')
        ->leftJoin('category', 'category.id', '=', 'car.categoryId')
        ->select('model.modelName', 'brand.brandName', 'brand.id as brandId', 'category.categoryName', 'color.colorName', 'car.*');

        if ($request->has('brandID') && $request->get('brandID') != '') {
            $query->where('brand.id', $request->get('brandID'));
        }

    $listCar = $query->get();

    return view('Admin.Car.List_car', ['userRows' => $userRows, 'car' => $listCar, 'model' => $model]);
}
    
    
    

 public function listImport(){
        $userRows = DB::table('users')->where('status', null)->count();
        $carImport = DB::table('importcar')
        ->leftJoin('car','car.id','importcar.carId')
        ->leftJoin('model','model.id','car.modelId')
        ->leftJoin('brand','brand.id','model.brandId')
        ->leftJoin('color','color.id','car.colorId')
        ->leftJoin('users','users.id','importcar.authorId')
        ->select('car.year','model.modelName','brand.brandName','color.colorName', 'users.name' ,'car.vin' ,'car.status','importcar.*')
        ->get();
        return view('Admin.Import.List_import',['userRows'=>$userRows , 'carImport'=>$carImport]);
    }
 public function listSet(){
        $userRows = DB::table('users')->where('status', null)->count();
        $salePrice = DB::table('set_sale_price')
        ->leftJoin('car','car.id','set_sale_price.carId')
        ->leftJoin('model','model.id','car.modelId')
        ->leftJoin('brand','brand.id','model.brandId')
        ->leftJoin('color','color.id','car.colorId')
        ->leftJoin('users','users.id','set_sale_price.authorId')
        ->select('car.year','model.modelName','brand.brandName','color.colorName', 'car.status' , 'users.name' ,'car.vin','set_sale_price.*')
        ->get();
        return view('Admin.Price.List_set_price',['userRows'=>$userRows , 'setsaleprice'=>$salePrice]);
    }
 public function listSale(){
        $userRows = DB::table('users')->where('status', null)->count();
        $sale_detail = DB::table('sale_detail')
        ->leftJoin('car','car.id','sale_detail.carId')
        ->leftJoin('model','model.id','car.modelId')
        ->leftJoin('brand','brand.id','model.brandId')
        ->leftJoin('color','color.id','car.colorId')
        ->leftJoin('users','users.id','sale_detail.authorId')
        ->leftJoin('customer','customer.id','sale_detail.customerId')
        ->select('car.year','model.modelName','brand.brandName','color.colorName', 'customer.name as customerName' , 'customer.contact_number' , 'customer.address' , 'customer.idCard' , 'users.name' ,'car.vin','sale_detail.*')
        ->get();
        return view('Admin.Sale.List_sale_car',['userRows'=>$userRows , 'sale'=>$sale_detail]);
    }

    // public function listIncome(){
    //     $userRows = DB::table('users')->where('status', null)->count();
    //     $income = DB::table('income')
    //     ->leftJoin('sale_detail','sale_detail.id','income.sale_detail_id')
    //     ->leftJoin('car','car.id','sale_detail.carId')
    //     ->leftJoin('model','model.id','car.modelId')
    //     ->leftJoin('brand','brand.id','model.brandId')
    //     ->leftJoin('color','color.id','car.colorId')
    //     ->leftJoin('users','users.id','sale_detail.authorId')
    //     ->select('car.year','model.modelName','brand.brandName','color.colorName', 'users.name' , 'sale_detail.*' ,'car.vin','income.*')
    //     ->get();
    //     return view('Admin.Income.List_income' , ['userRows'=>$userRows ,'income'=>$income ]);
    // }
    public function listIncome(Request $request){
        $userRows = DB::table('users')->where('status', null)->count();
    
        $query = DB::table('income')
            ->leftJoin('sale_detail', 'sale_detail.id', '=', 'income.sale_detail_id')
            ->leftJoin('car', 'car.id', '=', 'sale_detail.carId')
            ->leftJoin('model', 'model.id', '=', 'car.modelId')
            ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
            ->leftJoin('color', 'color.id', '=', 'car.colorId')
            ->leftJoin('users', 'users.id', '=', 'sale_detail.authorId')
            ->select('car.year', 'model.modelName', 'brand.brandName', 'color.colorName', 'users.name', 'sale_detail.*', 'car.vin', 'income.*');
    
        if ($request->has('startdate') && $request->has('enddate')) {
            $startDate = $request->get('startdate');
            $endDate = $request->get('enddate');
            $query->whereBetween('income.created_at', [$startDate, $endDate]);
        }
    
        $income = $query->get();
    
        return view('Admin.Income.List_income', ['userRows' => $userRows, 'income' => $income]);
    }
    

    public function listSoldCar(){
        $userRows = DB::table('users')->where('status', null)->count();
        $listCar = DB::table('car')
        ->leftJoin('model','model.id','car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
        ->leftJoin('color','color.id','car.colorId')
        ->leftJoin('category','category.id','car.categoryId')
        ->select('model.modelName','brand.brandName', 'category.categoryName' ,'color.colorName','car.*')
        ->get();
        return view('Admin.Car.sold_car',['userRows'=>$userRows ,'car'=>$listCar]);
    }

    public function detailCar($id){
        $userRows = DB::table('users')->where('status', null)->count();
        $carDetail = DB::table('car')
        ->leftJoin('model','model.id','car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
        ->leftJoin('color','color.id','car.colorId')
        ->leftJoin('category','category.id','car.categoryId')
        ->select('model.modelName','brand.brandName', 'category.categoryName' ,'color.colorName','car.*')
        ->where('car.id',$id)
        ->get();
        return view('Admin.Car.detail',['userRows'=>$userRows , 'car'=>$carDetail]);
    }

    public function listUsers(){
        $userRows = DB::table('users')->where('status', null)->count();
        $user = DB::table('users')->get();
        return view('Admin.Users.List_user',['userRows'=>$userRows, 'users'=>$user]);
    }

    public function listCustomer(){
        $userRows = DB::table('users')->where('status', null)->count();
        $customer = DB::table('customer')
        ->leftJoin('users','users.id','customer.authorId')
        ->select('users.name as author_name','customer.*')
        ->get();
        return view('/Admin.Customer.List_customer',['userRows'=>$userRows , 'customer'=>$customer]);
    }

// ==================================================================================================================================


    public function UpdateCate($id){
        $DbCate = DB::table('category')->find($id);
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Category.Update_category',['cate'=>$DbCate ,'userRows'=>$userRows]);
    }
    
    public function UpdateColor($id){
        $DbColor = DB::table('color')->find($id);
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Color.Update_color',['color'=>$DbColor ,'userRows'=>$userRows]);
    }


    
    public function UpdateBrand($id){
        $DbCate = DB::table('brand')->find($id);
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Brand.Update_brand',['brand'=>$DbCate,'userRows'=>$userRows]);
    }
    public function UpdateModel($id){
        $DbModel    = DB::table('model')->find($id);
        $brands     = DB::table('brand')->get(); // Fetch all brands
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Model.Update_model', ['model' => $DbModel, 'brands' => $brands ,'userRows'=>$userRows]);
    }

    public function manageUsers(){
        $user = DB::table('users')->where('status', null)->get();
        $userRows = DB::table('users')->where('status', null)->count();
        return view('Admin.Users.Users_access',['users'=>$user , 'userRows'=>$userRows]);
    }
    public function UpdateCar($id){
        $userRows = DB::table('users')->where('status', null)->count();
        $DbCar = DB::table('car')->where('id', $id)->first(); // Using first() instead of get()
        $DbModel = DB::table('model')
            ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
            ->select('brand.*', 'model.*')
            ->get();
        $DbColor = DB::table('color')->get();
        $DbCate = DB::table('category')->get();
    
        return view('Admin.Car.update_car', [
            'userRows' => $userRows,
            'car' => $DbCar,
            'model' => $DbModel,
            'color' => $DbColor,
            'cate' => $DbCate
        ]);
    }

    public function UpdateUser($id){
        $userRows = DB::table('users')->where('status', null)->count();
        $DbUser = DB::table('users')->where('id', $id)->get();
        return view('Admin.Users.Update_users',['userRows' => $userRows , 'users'=>$DbUser]);
    }

    public function UpdateImport($id){
        $userRows = DB::table('users')->where('status', null)->count();
        $DbImport = DB::table('importcar')
        ->where('importcar.id', $id)
        ->leftJoin('car', 'car.id', '=', 'importcar.carId')
        ->leftJoin('model', 'model.id', '=', 'car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
        ->select('brand.brandName', 'model.modelName',  'importcar.*')
        ->first();
        return view('Admin.Import.update_import',['userRows' => $userRows , 'import'=>$DbImport]);
    }
    
    public function UpdateSalePrice($id)
{
    // Fetch the number of users with status as null
    $userRows = DB::table('users')->where('status', null)->count();

    // Fetch the sale price and related car details
    $DbSetPrice = DB::table('set_sale_price')
        ->where('set_sale_price.id', $id)
        ->leftJoin('car', 'car.id', '=', 'set_sale_price.carId')
        ->leftJoin('model', 'model.id', '=', 'car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
        ->select('brand.brandName', 'model.modelName', 'car.id as carId', 'set_sale_price.*')
        ->first();

    // Fetch the import price based on the carId
    $importPrice = DB::table('importcar')
        ->where('carId', $DbSetPrice->carId)
        ->value('importPrice');

    // Pass the data to the view
    return view('Admin.Price.update_set_price', [
        'userRows' => $userRows,
        'setPrice' => $DbSetPrice,
        'importPrice' => $importPrice
    ]);
}

public function UpdateSaleCar($id){
    $userRows = DB::table('users')->where('status', null)->count();
    $DbSale = DB::table('sale_detail')->where('id',$id)->get();
    return view('Admin.Sale.Update_sale_car',['userRows' => $userRows],['sale'=>$DbSale]);
}

public function UpdateCustomer($id){
    $userRows = DB::table('users')->where('status', null)->count();
    $customer = DB::table('customer')->get();
    return view('Admin.Customer.Update',['userRows' => $userRows , 'customer'=>$customer]);
}

// ==================================================================================================================================

   
//=============================================================user=============================================================


public function listCategoryUser(){
    $DbCate = DB::table('category')
                                            ->leftJoin('users','users.id','category.authorId')
                                            ->select('users.name','category.*')
                                            ->orderBy('category.id')
                                            ->get();
    $userRows = DB::table('users')->where('status', null)->count();
    return view('User.Category.List_category',['cate'=>$DbCate,'userRows'=>$userRows]);
}

public function listColorUser(){
    $DbColor = DB::table('color')
                                            ->leftJoin('users','users.id','color.authorId')
                                            ->select('users.name','color.*')
                                            ->orderBy('color.id')
                                            ->get();
    $userRows = DB::table('users')->where('status', null)->count();
    return view('User.Color.List_color',['color'=>$DbColor,'userRows'=>$userRows]);
}


public function listBrandUser(){
    $DbBrand = DB::table('brand')
                                            ->leftJoin('users','users.id','brand.authorId')
                                            ->select('users.name','brand.*')
                                            ->orderBy('brand.id')
                                            ->get();
    $userRows = DB::table('users')->where('status', null)->count();                                        
    return view('User.Brand.List_brand',['brand'=>$DbBrand,'userRows'=>$userRows]);
}
public function listModelUser(){
    $DbModel = DB::table('model')
                                            ->leftJoin('brand','brand.id','model.brandId')
                                            ->leftJoin('users','users.id','model.authorId')
                                            ->select('users.name', 'brand.brandName' ,'model.*')
                                            ->orderByDesc('model.id')
                                            ->get();
    $userRows = DB::table('users')->where('status', null)->count();
    return view('User.Model.List_model',['model'=>$DbModel,'userRows'=>$userRows]);
}
public function listCarUser(Request $request){
    $userRows = DB::table('users')->where('status', null)->count();

    $model = DB::table('model')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
        ->select('brand.id as brandId', 'brand.brandName', 'model.id as modelId', 'model.modelName')
        ->get();

    $query = DB::table('car')
        ->leftJoin('model', 'model.id', '=', 'car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
        ->leftJoin('color', 'color.id', '=', 'car.colorId')
        ->leftJoin('category', 'category.id', '=', 'car.categoryId')
        ->select('model.modelName', 'brand.brandName', 'brand.id as brandId', 'category.categoryName', 'color.colorName', 'car.*');

        if ($request->has('brandID') && $request->get('brandID') != '') {
            $query->where('brand.id', $request->get('brandID'));
        }

    $listCar = $query->get();

    return view('User.Car.List_car', ['userRows' => $userRows, 'car' => $listCar, 'model' => $model]);
}

public function listImportUser(){
    $userRows = DB::table('users')->where('status', null)->count();
    $carImport = DB::table('importcar')
    ->leftJoin('car','car.id','importcar.carId')
    ->leftJoin('model','model.id','car.modelId')
    ->leftJoin('brand','brand.id','model.brandId')
    ->leftJoin('color','color.id','car.colorId')
    ->leftJoin('users','users.id','importcar.authorId')
    ->select('car.year','model.modelName','brand.brandName','color.colorName', 'users.name' ,'car.vin' ,'car.status','importcar.*')
    ->get();
    return view('User.Import.List_import',['userRows'=>$userRows , 'carImport'=>$carImport]);
}
public function listSetUser(){
    $userRows = DB::table('users')->where('status', null)->count();
        $salePrice = DB::table('set_sale_price')
        ->leftJoin('car','car.id','set_sale_price.carId')
        ->leftJoin('model','model.id','car.modelId')
        ->leftJoin('brand','brand.id','model.brandId')
        ->leftJoin('color','color.id','car.colorId')
        ->leftJoin('users','users.id','set_sale_price.authorId')
        ->select('car.year','model.modelName','brand.brandName','color.colorName', 'car.status' , 'users.name' ,'car.vin','set_sale_price.*')
        ->get();
        return view('User.Price.List_set_price',['userRows'=>$userRows , 'setsaleprice'=>$salePrice]);
}
public function listSaleUser(){
    $authorId = Auth::user()->id;
    $userRows = DB::table('users')->where('status', null)->count();
    $sale_detail = DB::table('sale_detail')
    ->leftJoin('car','car.id','sale_detail.carId')
    ->leftJoin('model','model.id','car.modelId')
    ->leftJoin('brand','brand.id','model.brandId')
    ->leftJoin('color','color.id','car.colorId')
    ->leftJoin('users','users.id','sale_detail.authorId')
    ->leftJoin('customer','customer.id','sale_detail.customerId')
    ->select('car.year','model.modelName','brand.brandName','color.colorName', 'customer.name as customerName' , 'customer.contact_number' , 'customer.address' , 'customer.idCard' , 'users.name' ,'car.vin','sale_detail.*')
    ->where('sale_detail.authorId', $authorId)
    ->get();
    return view('User.Sale.List_sale_car',['userRows'=>$userRows , 'sale'=>$sale_detail]);
}

// public function listIncomeUser(){
//     $authorId = Auth::user()->id;
//     $userRows = DB::table('users')->where('status', null)->count();
//     $income = DB::table('income')
//     ->leftJoin('sale_detail','sale_detail.id','income.sale_detail_id')
//     ->leftJoin('car','car.id','sale_detail.carId')
//     ->leftJoin('model','model.id','car.modelId')
//     ->leftJoin('brand','brand.id','model.brandId')
//     ->leftJoin('color','color.id','car.colorId')
//     ->leftJoin('users','users.id','sale_detail.authorId')
//     ->select('car.year','model.modelName','brand.brandName','color.colorName', 'users.name' , 'sale_detail.*' ,'car.vin','income.*')
//     ->where('sale_detail.authorId', $authorId)
//     ->get();
//     return view('User.Income.List_income' , ['userRows'=>$userRows ,'income'=>$income ]);
// }

public function listIncomeUser(Request $request){
    $userRows = DB::table('users')->where('status', null)->count();
    $authorId = Auth::user()->id;
    $query = DB::table('income')
        ->leftJoin('sale_detail', 'sale_detail.id', '=', 'income.sale_detail_id')
        ->leftJoin('car', 'car.id', '=', 'sale_detail.carId')
        ->leftJoin('model', 'model.id', '=', 'car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
        ->leftJoin('color', 'color.id', '=', 'car.colorId')
        ->leftJoin('users', 'users.id', '=', 'sale_detail.authorId')
        ->select('car.year', 'model.modelName', 'brand.brandName', 'color.colorName', 'users.name', 'sale_detail.*', 'car.vin', 'income.*');

    if ($request->has('startdate') && $request->has('enddate')) {
        $startDate = $request->get('startdate');
        $endDate = $request->get('enddate');
        $query->whereBetween('income.created_at', [$startDate, $endDate]);
    }

    $income = $query->where('sale_detail.authorId', $authorId)->get();

    return view('User.Income.List_income', ['userRows' => $userRows, 'income' => $income]);
}
    
public function newSaleUser(){
    // Count users where status is null
    $userRows = DB::table('users')->where('status', null)->count();

    // Get all car IDs from the sale_detail table
    $sale_detail = DB::table('sale_detail')->pluck('carId')->toArray();

    // Query for car details with multiple left joins
    $car = DB::table('car')
        ->leftJoin('model', 'model.id', '=', 'car.modelId')
        ->leftJoin('brand', 'brand.id', '=', 'model.brandId')
        ->leftJoin('color', 'color.id', '=', 'car.colorId')
        ->leftJoin('category', 'category.id', '=', 'car.categoryId')
        ->select(
            'model.modelName',
            'brand.brandName',
            'category.categoryName',
            'color.colorName',
            'car.*'
        )
        ->whereNotIn('car.id', $sale_detail)
        ->get();

    // Get sale prices with carId as key
    $sale_prices = DB::table('set_sale_price')
        ->select('carId', 'setSalePrice')
        ->pluck('setSalePrice', 'carId')->toArray();

    // Query for sale details with customer information
    $sale_details_with_customers = DB::table('customer')->get();

    // Pass the data to the view
    return view('User.Sale.sale_car', [
        'userRows' => $userRows,
        'Car' => $car,
        'sale_prices' => $sale_prices,
        'sale_details_with_customers' => $sale_details_with_customers
    ]);
}
public function newCustomerUser(){
    $userRows = DB::table('users')->where('status', null)->count();
    return view('User.Customer.customer',['userRows'=>$userRows]);
}

public function listSoldCarUser(){
    $userRows = DB::table('users')->where('status', null)->count();
    $listCar = DB::table('car')
    ->leftJoin('model','model.id','car.modelId')
    ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
    ->leftJoin('color','color.id','car.colorId')
    ->leftJoin('category','category.id','car.categoryId')
    ->select('model.modelName','brand.brandName', 'category.categoryName' ,'color.colorName','car.*')
    ->get();
    return view('User.Car.sold_car',['userRows'=>$userRows ,'car'=>$listCar]);
}
   
public function detailCarUser($id){
    $userRows = DB::table('users')->where('status', null)->count();
    $carDetail = DB::table('car')
    ->leftJoin('model','model.id','car.modelId')
    ->leftJoin('brand', 'brand.id', '=', 'model.brandId') 
    ->leftJoin('color','color.id','car.colorId')
    ->leftJoin('category','category.id','car.categoryId')
    ->select('model.modelName','brand.brandName', 'category.categoryName' ,'color.colorName','car.*')
    ->where('car.id',$id)
    ->get();
    return view('User.Car.detail',['userRows'=>$userRows , 'car'=>$carDetail]);
}
    
public function UpdateCustomerUser($id){
    $userRows = DB::table('users')->where('status', null)->count();
    $customer = DB::table('customer')->get();
    return view('User.Customer.Update',['userRows' => $userRows , 'customer'=>$customer]);
}

public function listCustomerUser(){
    $userRows = DB::table('users')->where('status', null)->count();
    $customer = DB::table('customer')
    ->leftJoin('users','users.id','customer.authorId')
    ->select('users.name as author_name','customer.*')
    ->get();
    return view('User.Customer.List_customer',['userRows'=>$userRows , 'customer'=>$customer]);
}
   

   

   
}
