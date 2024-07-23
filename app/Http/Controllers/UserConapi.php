<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\car;
use App\Models\category;
use App\Models\color;
use App\Models\customer;
use App\Models\importcar;
use App\Models\income;
use App\Models\model_tbl;
use App\Models\salePrice;
use App\Models\sell;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\select;

class UserConapi extends Controller
{
    public function getUser(){       
        $users = DB::table('users')->get();
        echo $users;
    }
   

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:191',
            'email'=> 'required|email|max:191',
            'password'=> 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $registerCheck = User::where('email',$request->email)->orWhere('name',$request->name)->get();
            if(count($registerCheck)!=0){
                return response()->json([
                    'status' => 409,
                    'Message'   => "User already exists"
                ], 409);
            }else{
                $adminExists = User::where('status', 1)->exists();

                $status = $adminExists ? null : 1;
                $register = User::create([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'password'  => Hash::make($request->password),
                    'status'    => $status,
                     'created_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                    'updated_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($register){
                    return response()->json([
                        'status' => 200,
                        'Message' => "Register Successful"
                    ]);
                }else{
                    return response()->json([
                        'status' => 500,
                        'Message' => "Register fail"
                    ]);
                }
            }
            
        }
    }

    public function loginSubmit(Request $request){
            $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'password' => 'required|max:191',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        } else {
            if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
                if (Auth::user()->status === 1) {
                    $token= Auth::user()->createToken('auth-token')->plainTextToken;
                    return response()->json([
                        'status' => 200,
                        'Message' => 'Login Successful',
                        'access_token' => $token
                    ], 200);
                } 
                
                elseif(Auth::user()->status === 0){
                    $token= Auth::user()->createToken('auth-token')->plainTextToken;
                    return response()->json([
                        'status' => 200,
                        'Message' => 'Login Successful',
                        'access_token' => $token
                    ], 200);
                }
                else {
                    Auth::logout();
                    return response()->json([
                        'status' => 403,
                        'Message' => 'Your account is not active. Please contact the administrator.'
                    ], 403);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'Message' => 'Login Failed: Wrong Username or Password'
                ], 404);
            }
        }
    }

    /////////////////////////////////////////////Create///////////////////////////////////////////////////
    public function creatBrand(Request $request){
        $validator = Validator::make($request->all(),[
            'brandName'=> 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $registerCheck = brand::where('brandName',$request->brandName)->get();
            if(count($registerCheck)!=0){
                return response()->json([
                    'status' => 409,
                    'Message'   => "User already exists"
                ], 409);
            }else{
                $register = brand::create([
                    'brandName'      => $request->brandName,
                    'authorId'       => Auth::id(),
                     'created_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                    'updated_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($register){
                    return response()->json([
                        'status' => 200,
                        'Message' => "Create Brand Successful"
                    ]);
                }else{
                    return response()->json([
                        'status' => 500,
                        'Message' => "Create Brand fail"
                    ]);
                }
            }
            
        }
    }
    public function creatColor(Request $request){
        $validator = Validator::make($request->all(),[
            'colorName'=> 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $registerCheck = color::where('colorName',$request->colorName)->get();
            if(count($registerCheck)!=0){
                return response()->json([
                    'status' => 409,
                    'Message'   => "Color already exists"
                ], 409);
            }else{
                $register = color::create([
                    'colorName'      => $request->colorName,
                    'authorId'       => Auth::id(),
                     'created_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                    'updated_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($register){
                    return response()->json([
                        'status' => 200,
                        'Message' => "Create Color Successful"
                    ]);
                }else{
                    return response()->json([
                        'status' => 500,
                        'Message' => "Create Color fail"
                    ]);
                }
            }
            
        }
    }
    public function creatCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'categoryName'=> 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $registerCheck = category::where('categoryName',$request->categoryName)->get();
            if(count($registerCheck)!=0){
                return response()->json([
                    'status' => 409,
                    'Message'   => "Category already exists"
                ], 409);
            }else{
                $register = category::create([
                    'categoryName'      => $request->categoryName,
                    'authorId'       => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                    'updated_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($register){
                    return response()->json([
                        'status' => 200,
                        'Message' => "Create Category Successful"
                    ]);
                }else{
                    return response()->json([
                        'status' => 500,
                        'Message' => "Create Category fail"
                    ]);
                }
            }
            
        }
    }

    public function creatModel(Request $request){
        $validator = Validator::make($request->all(),[
            'modelName'=> 'required|max:191',
            'brandId'        => 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $id = $request->brandId;
            $db = brand::where('id',$id)->select('id')->first();
            $modelCheck = model_tbl::where('modelName',$request->modelName)->get();
            if(count($modelCheck)!=0){
                return response()->json([
                    'status' => 409,
                    'Message'   => "Model already exists"
                ], 409);
            }else{
                if($db){
                    $insert = model_tbl::create([
                        'modelName' => $request->modelName,
                        'brandId'   => $db[0]->id,
                        'authorId'  => Auth::id(),
                        'created_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                        'updated_at' => date('Y-m-d H:i:s', strtotime('+7 hours'))
                    ]);
                    if($insert){
                        return response()->json([
                            'status'    => 200,
                            'Model'     => $insert,
                            'Message'   => "Model Insert Successfull"
                        ]);
                    }
                    else{
                        return response()->json([
                            'status'    => 200,
                            'Message'   => "Model Insert Fail"
                        ]);
                    }
                }else{
                    return response()->json([
                        'status'    => 404,
                        'Message'   => "Brand with ID = ".$id." not found!",
                    ]);
                }
            }
        }
    }

    public function creatCar(Request $request){
        $validator = Validator::make($request->all(),[
            'modelId'=> 'required|max:191',
            'colorId'        => 'required|max:191',
            'categoryId'=> 'required|max:191',
            'year'        => 'required|max:191',
            'vin'=> 'required|max:191',
            'mile'        => 'required|max:191',
            'condition'=> 'required|max:191',
            'status'        => 'required|max:191',
        ]);
        $imageName = rand(1, 99) . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('upload'), $imageName);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $dbModel = model_tbl::where('id',$request->modelId)->select('id')->first();
            $dbColor = color::where('id',$request->colorId)->select('id')->first();
            $dbCate = category::where('id',$request->categoryId)->select('id')->first();
            $vinCheck = car::where('vin',$request->vin)->get();
            if(count($vinCheck)!=0){
                return response()->json([
                    'status' => 409,
                    'Message'   => "Car already exists"
                ], 409);
            }else{
                if($dbModel){
                    if($dbColor){
                        if($dbCate){
                            $createCar = car::create([
                                'modelId'           => $request->modelId,
                                'colorId'           => $request->colorId,
                                'categoryId'        => $request->categoryId,
                                'year'              => $request->year,
                                'vin'               => $request->vin,
                                'mile'              => $request->mile,
                                'condition'         => $request->condition,
                                'status'            => $request->status,
                                'price'             => null,
                                'authorId'          => Auth::user()->id,
                                'image'             => $imageName,
                                'created_at' => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                'updated_at' => date('Y-m-d H:i:s', strtotime('+7 hours'))
                            ]);
                            if($createCar){
                                return response()->json([
                                    'status'    => 200,
                                    'Car'     => $createCar,
                                    'Message'   => "Car Insert Successfull"
                                ]);
                            }
                            else{
                                return response()->json([
                                    'status'    => 500,
                                    'Message'   => "Car Insert Fail"
                                ]);
                            }
                        }else{
                            return response()->json([
                                'status'    => 404,
                                'Message'   => "Category with ID = ".$request->cate." not found!",
                            ]);
                        }
                    }else{
                        return response()->json([
                            'status'    => 404,
                            'Message'   => "Color with ID = ".$request->categoryId." not found!",
                        ]);
                    }
                }else{
                    return response()->json([
                        'status'    => 404,
                        'Message'   => "Model with ID = ".$request->modelId." not found!",
                    ]);
                }
                
            }
        }
    }
    public function createCustomer(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:191',
            'gender'        => 'required|max:191',
            'contact_number'        => 'required|max:191',
            'address'        => 'required|max:191',
            'idCard'        => 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $idCarCheck = customer::where('idCard',$request->idCard)->get();
            if(count($idCarCheck)!=0){
                return response()->json([
                    'status' => 409,
                    'Message'   => "Customer already exists"
                ]);
            }else{
                $insert = customer::create([
                    'name'  => $request->name,
                    'gender'    => $request->gender,
                    'contact_number'    => $request->contact_number,
                    'address'   => $request->address,
                    'idCard'    => $request->idCard,
                    'authorId'  => Auth::user()->id,
                    'created_at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                    'updated_at'    => date('Y-m-d H:i:s', strtotime('+7 hours'))
                ]);
                if($insert){
                    return response()->json([
                        'status'    => 200,
                        'Message'   => "Customer Insert Successfull"
                    ]);
                }
            }
        }
    }
    ///////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////Get ////////////////////////////////////////////////
    public function getBrandById($id){
        $brand = brand::where('id',$id)->first();
        if($brand){
            return response()->json([
                'status' => 200,
                'brand'  => $brand
            ],200);
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => "Brand With ".$id." not Found"
            ],404);
        }
    }
    public function getBrand(){       
        $brand = brand::all();
        if($brand->count()>0){
            return response()->json($data=[
                'status'=>200,
                'Brand'=>$brand
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }
    public function getModel(){       
        $model = model_tbl::all();
        if($model->count()>0){
            return response()->json($data=[
                'status'=>200,
                'Model'=>$model
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }

    public function getSellCar(){
        $sellCar = sell::where('sale_detail.authorId',Auth::user()->id)->get();
        if($sellCar->count()>0){
            return response()->json($data=[
                'status'=>200,
                'List Sell'=>$sellCar
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }

    public function getColor(){       
        $color = color::all();
        if($color->count()>0){
            return response()->json($data=[
                'status'=>200,
                'Color'=>$color
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }
    public function getIncome(){       
        $income = income::leftJoin('sale_detail', 'sale_detail.id', '=', 'income.sale_detail_id')
                        ->select('income.*', 'sale_detail.price as sale_price') // Select the desired fields
                        ->where('sale_detail.authorId',Auth::user()->id)
                        ->get();
    
        if($income->count() > 0){
            return response()->json([
                'status' => 200,
                'Income' => $income
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No records found'
            ], 404);
        }
    }
    

    public function getCategory(){       
        $category = category::all();
        if($category->count()>0){
            return response()->json($data=[
                'status'=>200,
                'Category'=>$category
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }
    public function getCar(){
        $car = car::all();
        if($car->count()>0){
            return response()->json($data=[
                'status'=>200,
                'Cars'=>$car
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }
    public function getCustomer(){
        $customer = customer::all();
        if($customer->count()>0){
            return response()->json($data=[
                'status'=>200,
                'Cars'=>$customer
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }

    public function getSellPrice(){
        $sellPrice = salePrice::all();
        if($sellPrice->count()>0){
            return response()->json($data=[
                'status'=>200,
                'List Sale Price'=>$sellPrice
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }

    public function getImportCarPrice(){
        $car = importcar::all();
        if($car->count()>0){
            return response()->json($data=[
                'status'=>200,
                'Cars'=>$car
            ],200);
        }else{
            return response()->json($data=[
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }

    public function getCategoryById($id){
        $category = category::where('id',$id)->first();
        if($category){
            return response()->json([
                'status' => 200,
                'Category'  => $category
            ],200);
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => "Category With ".$id." not Found"
            ],404);
        }
    }
    public function getCustomerById($id){
        $customer = customer::where('id',$id)->first();
        if($customer){
            return response()->json([
                'status' => 200,
                'Category'  => $customer
            ],200);
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => "Customer With ".$id." not Found"
            ],404);
        }
    }
    
    public function getColorById($id){
        $color = color::where('id',$id)->first();
        if($color){
            return response()->json([
                'status' => 200,
                'Color'  => $color
            ],200);
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => "Color With ".$id." not Found"
            ],404);
        }
    }
    public function getModelById($id){
        $model = model_tbl::where('id',$id)->first();
        if($model){
            return response()->json([
                'status' => 200,
                'Model'  => $model
            ],200);
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => "Model With ".$id." not Found"
            ],404);
        }
    }

    
    public function getCarById($id){
        $car = car::where('id',$id)->first();
        if($car){
            return response()->json([
                'status' => 200,
                'Car'  => $car
            ],200);
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => "Car With ".$id." not Found"
            ],404);
        }
    }
    public function getImportCarPriceById($id){
        $car = importcar::where('carId',$id)->first();
        if($car){
            return response()->json([
                'status' => 200,
                'Car'  => $car
            ],200);
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => "Car With ".$id." not Found"
            ],404);
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////Update////////////////////////////////////
    public function updateBrand($id , Request $request){
        $vaidate = Validator::make($request->all(),[
            'brandName' => 'required|max:191'
        ]);
        if($vaidate->fails()){
            return response()->json([
                'status'    => 500,
                'error'     =>   $vaidate->messages(),
            ],500);
        }else{
            $brandId = brand::find($id);
            if($brandId){
               $brandId->update([
                    'brandName' => $request->brandName,
                    'updated_at'    => date('Y-m-d H:i:s',strtotime('+7 hours'))
               ]);
               return response()->json([
                    'status'    => 200,
                    'Message' => "Brand Update Successfully"
               ],200);
            }else{
                return response()->json([
                    'status'    => 404,
                    'Message'   => "Brand With Id : ".$id." Not Found"
                ],404);
            }
        }
       
    }
    public function updateCategory($id , Request $request){
        $vaidate = Validator::make($request->all(),[
            'categoryName' => 'required|max:191'
        ]);
        if($vaidate->fails()){
            return response()->json([
                'status'    => 500,
                'error'     =>   $vaidate->messages(),
            ],500);
        }else{
            $categoryId = category::find($id);
            if($categoryId){
               $categoryId->update([
                    'categoryName' => $request->categoryName,
                    'updated_at'    => date('Y-m-d H:i:s',strtotime('+7 hours'))
               ]);
               return response()->json([
                    'status'    => 200,
                    'Message' => "Category Update Successfully"
               ],200);
            }else{
                return response()->json([
                    'status'    => 404,
                    'Message'   => "Category With Id : ".$id." Not Found"
                ],404);
            }
        }
       
    }
    public function updateColor($id , Request $request){
        $vaidate = Validator::make($request->all(),[
            'colorName' => 'required|max:191'
        ]);
        if($vaidate->fails()){
            return response()->json([
                'status'    => 500,
                'error'     =>   $vaidate->messages(),
            ],500);
        }else{
            $colorId = color::find($id);
            if($colorId){
               $colorId->update([
                    'colorName' => $request->colorName,
                    'updated_at'    => date('Y-m-d H:i:s',strtotime('+7 hours'))
               ]);
               return response()->json([
                    'status'    => 200,
                    'Message' => "Color Update Successfully"
               ],200);
            }else{
                return response()->json([
                    'status'    => 404,
                    'Message'   => "Color With Id : ".$id." Not Found"
                ],404);
            }
        }
       
    }

    public function updateModel($id , Request $request){
        $vaidate = Validator::make($request->all(),[
            'modelName' => 'required|max:191',
            'brandId' => 'required|max:191'
        ]);
        if($vaidate->fails()){
            return response()->json([
                'status'    => 500,
                'error'     =>   $vaidate->messages(),
            ],500);
        }else{
            $modelID = model_tbl::find($id);
            $id1= $request->brandId;
            $db = brand::where('id',$id1)->select('id')->first();
            if($modelID){
                if($db){
                    $modelID->update([
                        'modelName' => $request->modelName,
                        'brandId'   => $db->id,
                        'updated_at'    => date('Y-m-d H:i:s',strtotime('+7 hours'))
                   ]);
                   return response()->json([
                        'status'    => 200,
                        'Message' => "Model Update Successfully"
                   ],200);
                }else{
                    return response()->json([
                        'status'    => 404,
                        'Message'   => "Brand With Id : ".$db." Not Found"
                    ],404);
                }
            }else{
                return response()->json([
                    'status'    => 404,
                    'Message'   => "Model With Id : ".$id." Not Found"
                ],404);
            }
        }
       
    }

    public function updateCar($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'modelId' => 'sometimes|required|max:191',
            'colorId' => 'sometimes|required|max:191',
            'categoryId' => 'sometimes|required|max:191',
            'year' => 'sometimes|required|max:191',
            'vin' => 'sometimes|required|max:191',
            'mile' => 'sometimes|required|max:191',
            'condition' => 'sometimes|required|max:191',
            'status' => 'sometimes|required|max:191',
            'image' => 'sometimes|image|max:2048', // optional, but if provided, must be an image
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        }
    
        $dbCar = Car::find($id);
    
        if (!$dbCar) {
            return response()->json([
                'status' => 404,
                'Message' => "Car with ID = $id not found!",
            ], 404);
        }
    
        // Check for unique VIN if vin is being updated
        if ($request->has('vin')) {
            $vinCheck = Car::where('vin', $request->vin)->where('id', '!=', $id)->exists();
            if ($vinCheck) {
                return response()->json([
                    'status' => 409,
                    'Message' => "Car with VIN = {$request->vin} already exists"
                ], 409);
            }
        }
    
        // Check if the related model, color, and category IDs exist if provided
        if ($request->has('modelId')) {
            $dbModel = model_tbl::where('id', $request->modelId)->exists();
            if (!$dbModel) {
                return response()->json([
                    'status' => 404,
                    'Message' => "Model with ID = {$request->modelId} not found!",
                ], 404);
            }
        }
    
        if ($request->has('colorId')) {
            $dbColor = Color::where('id', $request->colorId)->exists();
            if (!$dbColor) {
                return response()->json([
                    'status' => 404,
                    'Message' => "Color with ID = {$request->colorId} not found!",
                ], 404);
            }
        }
    
        if ($request->has('categoryId')) {
            $dbCate = Category::where('id', $request->categoryId)->exists();
            if (!$dbCate) {
                return response()->json([
                    'status' => 404,
                    'Message' => "Category with ID = {$request->categoryId} not found!",
                ], 404);
            }
        }
    
        $updateData = [];
    
        // Dynamically build the update data array based on request
        if ($request->has('modelId')) $updateData['modelId'] = $request->modelId;
        if ($request->has('colorId')) $updateData['colorId'] = $request->colorId;
        if ($request->has('categoryId')) $updateData['categoryId'] = $request->categoryId;
        if ($request->has('year')) $updateData['year'] = $request->year;
        if ($request->has('vin')) $updateData['vin'] = $request->vin;
        if ($request->has('mile')) $updateData['mile'] = $request->mile;
        if ($request->has('condition')) $updateData['condition'] = $request->condition;
        if ($request->has('status')) $updateData['status'] = $request->status;
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imageName = rand(1, 99) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $imageName);
            $updateData['image'] = $imageName;
        }
    
        $updateData['authorId'] = Auth::user()->id;
    
        $dbCar->update($updateData);
    
        return response()->json([
            'status' => 200,
            'Car' => $dbCar,
            'Message' => "Car update successful"
        ]);
    }
    

    ///////////////////////////////////////////////////////////////////////////////

    /////////////////////////////Delete///////////////////////////////////////////
    public function deleteBrand($id){
        $brandId = brand::find($id);
        if($brandId){
            $brand = brand::where('id',$id)->delete();
            if($brand){
                return response()->json([
                    'status'    => 200,
                    'Message'   => 'Brand with Id : '.$id.' Delete Successfully'
                ],200);
            }
            else{
                return response()->json([
                    'status'    => 403,
                    'Message'   => 'Brand with Id : '.$id.' Delete Fail'
                ],403);
            }
            
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => 'Brand with Id : '.$id.' Not Found'
            ],404);
        }
    }
    public function deleteCategory($id){
        $categoryId = category::find($id);
        if($categoryId){
            $categoryId = category::where('id',$id)->delete();
            if($categoryId){
                return response()->json([
                    'status'    => 200,
                    'Message'   => 'Category with Id : '.$id.' Delete Successfully'
                ],200);
            }
            else{
                return response()->json([
                    'status'    => 403,
                    'Message'   => 'Category with Id : '.$id.' Delete Fail'
                ],403);
            }
            
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => 'Category with Id : '.$id.' Not Found'
            ],404);
        }
    }
    public function deleteModel($id){
        $modelId = model_tbl::find($id);
        if($modelId){
            $modelId = model_tbl::where('id',$id)->delete();
            if($modelId){
                return response()->json([
                    'status'    => 200,
                    'Message'   => 'Model with Id : '.$id.' Delete Successfully'
                ],200);
            }
            else{
                return response()->json([
                    'status'    => 403,
                    'Message'   => 'Model with Id : '.$id.' Delete Fail'
                ],403);
            }
            
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => 'Model with Id : '.$id.' Not Found'
            ],404);
        }
    }
    public function deleteColor($id){
        $colorId = color::find($id);
        if($colorId){
            $colorId = color::where('id',$id)->delete();
            if($colorId){
                return response()->json([
                    'status'    => 200,
                    'Message'   => 'Color with Id : '.$id.' Delete Successfully'
                ],200);
            }
            else{
                return response()->json([
                    'status'    => 403,
                    'Message'   => 'Color with Id : '.$id.' Delete Fail'
                ],403);
            }
            
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => 'Color with Id : '.$id.' Not Found'
            ],404);
        }
    }
    public function deleteCar($id){
        $carId = car::find($id);
        if($carId){
            $carId = car::where('id',$id)->delete();
            if($carId){
                return response()->json([
                    'status'    => 200,
                    'Message'   => 'Car with Id : '.$id.' Delete Successfully'
                ],200);
            }
            else{
                return response()->json([
                    'status'    => 403,
                    'Message'   => 'Car with Id : '.$id.' Delete Fail'
                ],403);
            }
            
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => 'Car with Id : '.$id.' Not Found'
            ],404);
        }
    }
    public function deleteCustomer($id){
        $customer = customer::find($id);
        if($customer){
            $customer = customer::where('id',$id)->delete();
            if($customer){
                return response()->json([
                    'status'    => 200,
                    'Message'   => 'Customer with Id : '.$id.' Delete Successfully'
                ],200);
            }
            else{
                return response()->json([
                    'status'    => 403,
                    'Message'   => 'Customer with Id : '.$id.' Delete Fail'
                ],403);
            }
            
        }else{
            return response()->json([
                'status'    => 404,
                'Message'   => 'Customer with Id : '.$id.' Not Found'
            ],404);
        }
    }

    ////////////////////////////////////////////////////////////////
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        $token->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Logout successful'
        ], 200);
    }
   //////////////////////////////////////////Access//////////////////////////////////////////
    public function userNotAccess(Request $request){
        $UserDB = User::where('status',null)->get();
        return response()->json([
            'status' => 200,
            'Users' => $UserDB
        ]);
    }

    public function manageUserAccess($id){
        
            $userNotAccessId = User::find($id);
          if($userNotAccessId){
            $userNotAccessId->update([
                'status' => 0,
                'udapted_at'    =>date('Y-m-d H:i:s', strtotime('+7 hours'))
            ]);
            return response()->json([
                'status'    => 200,
                'Users'     => $userNotAccessId,
                'message' => 'Update Successfull'
            ]);
          }
    }   
    ///////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////Import Price //////////////////////

    public function importCarPrice(Request $request){
        $validator = Validator::make($request->all(),[
            'carId'=> 'required|max:191',
            'importPrice'=> 'required|max:191',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error' => $validator->messages()
            ],422);
        }else{
            $DbCarIdCheck = car::where('id',$request->carId)->select('id')->first();
            $DbCarIdCheckIn = importcar::where('carId',$request->carId)->get();
            
            if($DbCarIdCheck){
                if(count($DbCarIdCheckIn)!=0){
                    return response()->json([
                        'status'    => 403,
                        'Message'   => "Car Import Price Exist"
                    ]);
                }else{
                    $Insert = importcar::create([
                        'carId' => $request->carId,
                        'importDate'    => date('Y-m-d h:i:s',strtotime('+7 horus')),
                        'importPrice'   => $request->importPrice,
                        'authorId'  => Auth::user()->id,
                        'created-at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                        'updated_at'    =>date('Y-m-d H:i:s', strtotime('+7 hours'))
                    ]);
                    if($Insert){
                        return response()->json([
                            'status'    => 200,
                            'Message'   => " Car With Id = ".$request->carId." Import Price Success"
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'status'    => 404,
                    'Message'   => " Car With Id = ".$request->carId." Not Found"
                ]);
            }
        }
    }

    public function updateImportPrice($id, Request $request){
        $validator = Validator::make($request->all(), [
            'importPrice' => 'required|max:191',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        }
    
        $car = Car::find($id);
    
        if (!$car) {
            return response()->json([
                'status' => 404,
                'message' => "Car with ID = $id not found"
            ], 404);
        }
    
        $update = ImportCar::where('carId', $car->id)->update([
            'importPrice' => $request->importPrice,
            'updated_at' =>date('Y-m-d H:i:s', strtotime('+7 hours'))
        ]);
    
        if ($update) {
            return response()->json([
                'status' => 200,
                'message' => "Car with ID = $id updated import price successfully"
            ]);
        }
    
        return response()->json([
            'status' => 500,
            'message' => "Failed to update import price for car with ID = $id"
        ], 500);
    }

    public function updateCustomer(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name'=> 'sometimes|max:191',
            'contact_number'=> 'sometimes|max:191',
            'address'=> 'sometimes|max:191',
            'idCard'=> 'sometimes|max:191',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        } else {
            $customer = customer::find($id);
            if (!$customer) {
                return response()->json([
                    'status' => 404,
                    'message' => "Customer with ID = $id not found"
                ], 404);
            }
    
            $updateData = [];
            if ($request->has('name')) {
                $updateData['name'] = $request->name;
            }
            if ($request->has('gender')) {
                $updateData['gender'] = $request->gender;
            }
            if ($request->has('contact_number')) {
                $updateData['contact_number'] = $request->contact_number;
            }
            if ($request->has('address')) {
                $updateData['address'] = $request->address;
            }
            if ($request->has('idCard')) {
                $DbCheck = customer::where('idCard', $request->idCard)->where('id', '!=', $id)->get();
                if (count($DbCheck) != 0) {
                    return response()->json([
                        'status' => 409,
                        'message' => "Customer with ID Card = {$request->idCard} already exists"
                    ], 409);
                }
                $updateData['idCard'] = $request->idCard;
            }
            $updateData['updated_at'] = date('Y-m-d H:i:s', strtotime('+7 hours'));
    
            $update = customer::where('id', $id)->update($updateData);
            if ($update) {
                return response()->json([
                    'status' => 200,
                    'message' => "Customer with ID = $id updated successfully"
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Failed to update customer with ID = $id"
                ], 500);
            }
        }
    }
    
    
    ////////////////////////set sale price///////////////////////////////////////
    public function setSalePrice(Request $request){
        $validator = Validator::make($request->all(), [
            'carId'=> 'required|max:191',
            'setSalePrice'=> 'required|max:191',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        }else{
            $DbCarIdCheck = car::where('id',$request->carId)->select('id')->first();
            $DbCarIdCheckIn = salePrice::where('carId',$request->carId)->get();
            
            if($DbCarIdCheck){
                if(count($DbCarIdCheckIn)!=0){
                    return response()->json([
                        'status'    => 403,
                        'Message'   => "Car Import Price Exist"
                    ]);
                }else{
                    $importPriceExists = importcar::where('carId', $request->carId)->exists();
    
                    if (!$importPriceExists) {
                        return response()->json([
                            'status'    => 404,
                            'Message'   => " Car With Id = ".$request->carId." does not have an import price"
                        ]);
                    }
            
                    $Insert = salePrice::create([
                        'carId' => $request->carId,
                        'setSalePrice'   => $request->setSalePrice,
                        'authorId'  => Auth::user()->id,
                        'effectiveDate'    => date('Y-m-d h:i:s'),
                        'created-at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                        'updated_at'    => date('Y-m-d H:i:s', strtotime('+7 hours'))
                    ]);

                    $update = car::where('id',$request->carId)->update([
                        'price' => $request->setSalePrice,
                        'updated_at'    => date('Y-m-d H:i:s', strtotime('+7 hours'))
                    ]);
                    
                    if($Insert){
                        return response()->json([
                            'status'    => 200,
                            'Message'   => " Car With Id = ".$request->carId." Set Sale Price Success"
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'status'    => 404,
                    'Message'   => " Car With Id = ".$request->carId." Not Found"
                ]);
            }
        }

    }

    public function updateSalePrice(Request $request) {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'carId'        => 'required|max:191',
            'setSalePrice' => 'required|max:191',
        ]);
    
        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        }
    
        // Retrieve the sale price record
        $salePriceRecord = salePrice::where('carId', $request->carId)->first();
    
        // Check if the sale price record exists
        if (!$salePriceRecord) {
            return response()->json([
                'status' => 404,
                'message' => "Sale price record for car with ID = {$request->carId} not found"
            ], 404);
        }
    
        // Update the sale price record
        $salePriceRecord->setSalePrice = $request->setSalePrice;
        $salePriceRecord->updated_at = date('Y-m-d H:i:s', strtotime('+7 hours'));
    
        if ($salePriceRecord->save()) {
            $car = car::find($request->carId);
    
            if (!$car) {
                return response()->json([
                    'status' => 404,
                    'message' => "Car with ID = {$request->carId} not found"
                ], 404);
            }
    
            $car->price = $request->setSalePrice;
            $car->updated_at = date('Y-m-d H:i:s', strtotime('+7 hours'));
    
            if ($car->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => "Car with ID = {$request->carId} updated sale price successfully"
                ]);
            }
    
            return response()->json([
                'status' => 500,
                'message' => "Failed to update car price for car with ID = {$request->carId}"
            ], 500);
        }
    
        return response()->json([
            'status' => 500,
            'message' => "Failed to update sale price for car with ID = {$request->carId}"
        ], 500);
    }

    public function sellCar(Request $request){
        $validator = Validator::make($request->all(), [
            'carId'        => 'required|max:191',
            'customerId'       => 'required|max:191',
            'price'        => 'required|numeric',
        ]);
    
        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        }
    
        // Check if the car is available and has a price
        $car = car::where('id', $request->carId)
                  ->where('status', 'Available')
                  ->first();
    
        if (!$car) {
            return response()->json([
                'status' => 404,
                'message' => "Car with ID = {$request->carId} is not available"
            ], 404);
        }
    
        if (is_null($car->price)) {
            return response()->json([
                'status' => 400,
                'message' => "Car with ID = {$request->carId} does not have a price set and cannot be sold"
            ], 400);
        }
        $currentDateTime = date('Y-m-d H:i:s', strtotime('+7 hours')); 
        // Insert sale record
        $sale = sell::create([
            'carId'     => $request->carId,
            'customerId'    => $request->customerId,
            'price'     => $request->price,
            'authorId'  => Auth::user()->id,
            'saleDate'  => $currentDateTime,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ]);
    
        if (!$sale) {
            return response()->json([
                'status' => 500,
                'message' => "Failed to create sale record for car with ID = {$request->carId}"
            ], 500);
        }
    
       
        $importPrice = importcar::where('carId', $request->carId)->value('importPrice');
        $salePrice = $request->price;
    
        income::create([
            'sale_detail_id' => $sale->id,
            'importPrice'    => $importPrice,
            'profit'         => $salePrice - $importPrice,
            'authorId'       => Auth::user()->id,
            'created_at'     => $currentDateTime,
            'updated_at'     => $currentDateTime
        ]);
    
        // Update car status
        $car->update(['status' => 'Unavailable']);
    
        return response()->json([
            'status' => 200,
            'message' => "Car with ID = {$request->carId} sold successfully"
        ]);
    }
    

    
}
