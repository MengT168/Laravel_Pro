<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class backController extends Controller
{

//==============================================================================================================

    public function registerSubmit(Request $request){
        $username = $request->input('username');
        $email = $request->input('email');
        $pass = Hash::make($request->input('password'));

        $registerCheck = DB::table('users')->where('email',$email)->orWhere('name',$username)->get();

        if(count($registerCheck)!=0){
            return redirect('/register')->with('Message','User Already Exists');
        }else{
            $adminExist = DB::table('users')->where('status',1)->exists();
            $status = $adminExist ? null : 1;
            DB::table('users')->insert([
                                        'name'          =>$username,
                                        'email'         =>$email,
                                        'password'      =>$pass,
                                        'status'        =>$status,
                                        'created_at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                        'updated_at'    =>  date('Y-m-d H:i:s', strtotime('+7 hours')),
            ]);
            return redirect('/');
        }
    }
    // public function loginSubmit(Request $request){
    //     if(Auth::attempt(['name'=>$request->input('username') , 'password'=>$request->input('password') ],true)){
    //         if(Auth::user()->status == '1')
    //         return redirect('/admin/dashboard');

    //         elseif(Auth::user()->status == '0')
    //         return redirect('/user/dashboard');
    //     }
       
    //     else{
    //         return redirect('/')->with('Message','Wrong Username or Password or Need Admin to Access');
    //     }
    // }
    public function loginSubmit(Request $request) {
        if (Auth::attempt(['name' => $request->input('username'), 'password' => $request->input('password')], true)) {
            if (Auth::user()->status == '1') {
                return redirect('/admin/dashboard');
            } elseif (Auth::user()->status == '0') {
                return redirect('/user/dashboard');
            } else {
                Auth::logout();
                return redirect('/')->with('Message', 'Your account has not been approved by an admin.');
            }
        } else {
            return redirect('/')->with('Message', 'Wrong Username or Password');
        }
    }
    

    public function logout()
    {
        Auth::logout();
       
        return redirect('/');
    }

    public function categorySubmit(Request $request){
        $carCate = $request->catetxt;
        $cateCheck = DB::table('category')->where('categoryName',$carCate)->get();
        if(count($cateCheck)!=0){
            return redirect('/admin/new_category')->with('Message','Category Already Exists');
        }
        else{
            if($carCate != ""){
                $cate = DB::table('category')->insert([
                                    'categoryName'  => $carCate,
                                    'authorId'      => Auth::user()->id,
                                    'created_at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                    'updated_at'    =>  date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($cate){
                    return redirect('/admin/list_category',);
                }
            }
            else{
                return redirect('/admin/new_category')->with('Message','Invalid Input');
            }
        }
    }

    public function colorSubmit(Request $request){
        $colortxt = $request->colortxt;
        $colorCheck = DB::table('color')->where('colorName',$colortxt)->get();
        if(count($colorCheck)!=0){
            return redirect('/admin/new_category')->with('Message','Category Already Exists');
        }
        else{
            if($colortxt != ""){
                $color = DB::table('color')->insert([
                                    'colorName'  => $colortxt,
                                    'authorId'      => Auth::user()->id,
                                    'created_at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                    'updated_at'    =>  date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($color){
                    return redirect('/admin/list_color',);
                }
            }
            else{
                return redirect('/admin/new_color')->with('Message','Invalid Input');
            }
        }
    }

    public function brandSubmit(Request $request){
        $carbrand = $request->brandtxt;
        $brandCheck = DB::table('brand')->where('brandName',$carbrand)->get();
        if(count($brandCheck)!=0){
            return redirect('/admin/new_category')->with('Message','Brand Already Exists');
        }
        else{
            if($carbrand != ""){
                $brand = DB::table('brand')->insert([
                                'brandName'     => $carbrand,
                                'authorId'      => Auth::user()->id,
                                'created_at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                'updated_at'    =>  date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($brand){
                    return redirect('/admin/list_brand',);
                }
            }
            else{
                return redirect('/admin/new_brand')->with('Message','Invalid Input');
            }
        }
    }

    
    public function modelSubmit(Request $request){
        $modeltxt = $request->modeltxt;
        $brandtxt = $request->brandtxt;
        $ModelCheck = DB::table('model')->where('modelName',$modeltxt)->get();
        if(count($ModelCheck)!=0){
            return redirect('/new_model')->with('Message','Model Already Exists');
        }
        else{
            if($modeltxt != ""){
                $model = DB::table('model')->insert([
                                        'modelName'         => $modeltxt,
                                        'brandId'           => $brandtxt,
                                        'authorId'          => Auth::user()->id,
                                        'created_at'        => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                        'updated_at'        =>  date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($model){
                    return redirect('/admin/list_model',);
                }
            }
            else{
                return redirect('/admin/new_model')->with('Message','Invalid Input');
            }
        }
    }

    public function carSubmit(Request $request){
        if($request->hasFile('img')){

            $file = $request->file('img');
            $fileName = rand(1,99).''.$file->getClientOriginalName();
            $path = 'upload';
            $file ->move($path,$fileName);
        }else{
            $fileName = "default_image.png";
        }
        $modeltxt = $request->modeltxt;
        $colortxt = $request->colortxt;
        $catetxt = $request->catetxt;
        $yeartxt = $request->yeartxt;
        $vintxt = $request->vintxt;
        $statustxt = 'Available';
        $conditiontxt= $request->conditiontxt;
        $miletxt= $request->miletxt;
       
        $CarCheck = DB::table('car')->where('vin',$vintxt)->get();
        if(count($CarCheck)!=0){
            return redirect('/new_car')->with('Message','vin Already Exists');
        }
        else{
            if($modeltxt != "" && $yeartxt!= "" && $vintxt !="" ){
                $model = DB::table('car')->insert([
                                        'modelId'         => $modeltxt,
                                        'colorId'           => $colortxt,
                                        'categoryId'           => $catetxt,
                                        'year'           => $yeartxt,
                                        'vin'           => $vintxt,
                                        'mile'           => $miletxt,
                                        'condition'           => $conditiontxt,
                                        'status'           => $statustxt,
                                        'authorId'          => Auth::user()->id,
                                        'image'           => $fileName,
                                        'created_at'        => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                        'updated_at'        =>  date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($model){
                    return redirect('/admin/list_car',);
                }
            }
            else{
                return redirect('/admin/new_car')->with('Message','Invalid Input');
            }
        }
    }
   

   
    
    public function importSubmit(Request $request){
        $importcartxt = $request->importcartxt;
        $pricetxt = $request->pricetxt;
        $importCheck = DB::table('importcar')->where('carId',$importcartxt)->get();
        if(count($importCheck)!=0){
            return redirect('/admin/new_model')->with('Message','import Already Exists');
        }
        else{
            if($importcartxt != ""){
                $model = DB::table('importcar')->insert([
                                        'carId'         => $importcartxt,
                                        'importDate'    => date('Y-m-d H:i:s',strtotime('+7 hours')),
                                        'importPrice'           => $pricetxt,
                                        'authorId'          => Auth::user()->id,
                                        'created_at'        => date('Y-m-d H:i:s', strtotime('+7 hours')),
                                        'updated_at'        =>  date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($model){
                    return redirect('/admin/list_import');
                }
            }
            else{
                return redirect('/admin/import_car')->with('Message','Invalid Input');
            }
        }
    }
    public function setSalePrice(Request $request) {
        $cartxt = $request->input('cartxt');
        $sale_price = $request->input('sale_price');
        $currentDateTime = date('Y-m-d H:i:s', strtotime('+7 hours')); 
    
        if (!empty($cartxt)) {
            // Check if the car has an import price in the importcar table
            $importPriceExists = DB::table('importcar')->where('carId', $cartxt)->exists();
    
            if (!$importPriceExists) {
                return redirect('/admin/set_sale_price')->with('Message', 'Cannot set sale price: Car does not have an import price');
            }
    
            DB::transaction(function () use ($cartxt, $sale_price, $currentDateTime) {
                // Insert the new sale price into the set_sale_price table
                DB::table('set_sale_price')->insert([
                    'carId' => $cartxt,
                    'setSalePrice' => $sale_price,
                    'authorId'  => Auth::user()->id,
                    'effectiveDate' => $currentDateTime,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime
                ]);
    
                // Update the car price in the car table
                DB::table('car')
                    ->where('id', $cartxt)
                    ->update(['price' => $sale_price]);
            });
    
            return redirect('/admin/list_set')->with('Message', 'Update successful');
        } else {
            return redirect('/admin/set_sale_price')->with('Message', 'Invalid input');
        }
    }
    
    
    public function saleSubmit(Request $request) {
        $cartxt = $request->input('cartxt');
        $customerId = $request->customertxt;
        $sale_price = $request->input('price');
        $currentDateTime = date('Y-m-d H:i:s', strtotime('+7 hours'));
    
        if (!empty($cartxt)) {
            $salePrice = DB::table('set_sale_price')
                ->where('carId', $cartxt)
                ->value('setSalePrice');
    
            $importPrice = DB::table('importcar')
                ->where('carId', $cartxt)
                ->value('importPrice');
    
            // Check if both sale price and import price are available
            if (is_null($salePrice) || is_null($importPrice)) {
                return redirect('/admin/new_sale')->with('Message', 'Cannot sell car without both import price and sale price.');
            }
    
            DB::transaction(function () use ($cartxt, $sale_price, $currentDateTime, $customerId, $importPrice) {
                // Insert the new sale price into the sale_detail table
                DB::table('sale_detail')->insert([
                    'carId' => $cartxt,
                    'customerId' => $customerId,
                    'price' => $sale_price,
                    'authorId' => Auth::user()->id,
                    'saleDate' => $currentDateTime,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime
                ]);
    
                $sale_detailID = DB::table('sale_detail')
                    ->where('carId', $cartxt)
                    ->value('id');
    
                $sale_price = DB::table('sale_detail')
                    ->where('id', $sale_detailID)
                    ->value('price');
    
                DB::table('income')->insert([
                    'sale_detail_id' => $sale_detailID,
                    'importPrice' => $importPrice,
                    'profit' => $sale_price - $importPrice,
                    'authorId' => Auth::user()->id,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime
                ]);
    
                // Update the car status in the car table
                DB::table('car')
                    ->where('id', $cartxt)
                    ->update(['status' => "Unavailable"]);
            });
    
            return redirect('/admin/list_sale')->with('Message', 'Insert successful');
        } else {
            return redirect('/admin/new_sale')->with('Message', 'Invalid input');
        }
    }

    public function customerSubmit(Request $request){
        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;
        $idCard = $request->idCard;
        $gender = $request->input('gender');


        $DbCheck = DB::table('customer')->where('idCard',$idCard)->get();

        if(count($DbCheck) !=0 )
        {
            return redirect('/admin/new_customer')->with('Message','Customer Already Exist');
        }else{
            if($name && $phone && $address && $idCard){
                $insert = DB::table('customer')->insert([
                    'name'  => $name,
                    'gender'    => $gender,
                    'contact_number' => $phone,
                    'address'   => $address,
                    'idCard'    => $idCard,
                    'authorId'  => Auth::user()->id,
                    'created_at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                    'updated_at'    => date('Y-m-d H:i:s', strtotime('+7 hours'))
                ]);
                if($insert){
                    return redirect('/admin/list_customer')->with('Message','Insert Success');
                }
            }else{
                return redirect('/admin/new_customer')->with('Message','Invalid Input');
            }
        }


    }


//==============================================================================================================

    
    
    public function updateCategorySubmit(Request $request){
        $carCate = $request->catetxt;
        $id = $request->id;
        $cateCheck = DB::table('category')->where('categoryName',$carCate)->get();
        if(count($cateCheck)!=0){
             return redirect('/edit_carcate/'.$id)->with('Message','Category Already Exists');
        }
        else{
            if($carCate != ""){
                $cate = DB::table('category')->where('id',$id)->update([
                                    'categoryName'      => $carCate,
                                    'updated_at'        => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($cate){
                    return redirect('/list_category')->with('Message','Update Success');
                }
            }
            else{
                return redirect('/edit_carcate/'.$id)->with('Message','Invalid Input');
            }
        }
    }
    public function updateColorSubmit(Request $request){
        $colortxt = $request->colortxt;
        $id = $request->id;
        $cateCheck = DB::table('color')->where('colorName',$colortxt)->get();
        if(count($cateCheck)!=0){
             return redirect('/edit_color/'.$id)->with('Message','Category Already Exists');
        }
        else{
            if($colortxt != ""){
                $cate = DB::table('color')->where('id',$id)->update([
                                    'colorName'      => $colortxt,
                                    'updated_at'        => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($cate){
                    return redirect('/admin/list_color')->with('Message','Update Success');
                }
            }
            else{
                return redirect('/admin/edit_color/'.$id)->with('Message','Invalid Input');
            }
        }
    }
 public function updateBrandSubmit(Request $request){
        $carbrand = $request->brandtxt;
        $id = $request->id;
        $brandCheck = DB::table('brand')->where('brandName',$carbrand)->get();
        if(count($brandCheck)!=0){
             return redirect('/edit_carcate/'.$id)->with('Message','Category Already Exists');
        }
        else{
            if($carbrand != ""){
                $brand = DB::table('brand')->where('id',$id)->update([
                                        'brandName'         => $carbrand,
                                        'updated_at'        => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($brand){
                    return redirect('/list_brand')->with('Message','Update Success');
                }
            }
            else{
                return redirect('/edit_brand/'.$id)->with('Message','Invalid Input');
            }
        }
    }
 public function updateModelSubmit(Request $request){
        $modeltxt = $request->modeltxt;
        $brandtxt = $request->brandtxt;
        $id = $request->id;
        $modelcheck = DB::table('model')->where('modelName',$modeltxt)->get();
        if(count($modelcheck)!=0){
             return redirect('/edit_model/'.$id)->with('Message','Model Already Exists');
        }
        else{
            if($modeltxt != ""){
                $model = DB::table('model')->where('id',$id)->update([
                                                'modelName'         => $modeltxt,
                                                'brandId'           => $brandtxt,
                                                'updated_at'        => date('Y-m-d H:i:s', strtotime('+7 hours')),
                ]);
                if($model){
                    return redirect('/list_model')->with('Message','Update Success');
                }
            }
            else{
                return redirect('/edit_model/'.$id)->with('Message','Invalid Input');
            }
        }
    }
 public function UpdateUser($id){
        $user = DB::table('users')->where('id',$id)->update([
            'status'    => 0
        ]);
        if($user){
            return redirect('/admin/manage_users');
        }
    }

    public function updateUsersSubmit(Request $request)
{
    // Retrieve the user from the database
    $Dbuser = DB::table('users')->where('id', $request->id)->first();

    // Get the new values from the request
    $name = $request->name;
    $email = $request->email;
    $password = $request->password;
    $status = $request->status;
    $id = $request->id;

    if (($name != $Dbuser->name || $email != $Dbuser->email) &&
        DB::table('users')->where('id', '!=', $id)->where(function($query) use ($name, $email) {
            $query->where('name', $name)->orWhere('email', $email);
        })->exists()) {
        return redirect('/admin/update_users/' . $id)->with('Message', 'User Already Exists');
    }

    $updateData = [
        'name' => $name,
        'email' => $email,
        'status' => $status,
        'updated_at' => now(),
    ];

    if ($password != $Dbuser->password) {
        $updateData['password'] = Hash::make($password);
    }

    if (!empty($name) && !empty($email) && !empty($password) ) {
        // Perform the update
        $user = DB::table('users')->where('id', $id)->update($updateData);
        if ($user) {
            return redirect('/admin/list_users')->with('Message', 'Update Success');
        }
    } else {
        return redirect('/admin/update_users/' . $id)->with('Message', 'Invalid Input');
    }
}

   
    public function updateCarSubmit(Request $request){
        $Dbcar = DB::table('car')->where('id', $request->id)->first();
        
        if($request->hasFile('img')){
            $file = $request->file('img');
            $fileName = rand(1, 99) . $file->getClientOriginalName();
            $path = 'upload';
            $file->move($path, $fileName);
        } else {
            $fileName = $Dbcar->image;
        }
        
        $modeltxt = $request->modeltxt;
        $colortxt = $request->colortxt;
        $catetxt = $request->catetxt;
        $yeartxt = $request->yeartxt;
        $vintxt = $request->vintxt;
        $pricetxt = $request->pricetxt;
        $statustxt = $request->statustxt;
        $conditiontxt = $request->conditiontxt;
        $miletxt = $request->miletxt;
    
        if ($vintxt != $Dbcar->vin) {
            $CarCheck = DB::table('car')->where('vin', $vintxt)->count();
            if ($CarCheck != 0) {
                return redirect('/admin/edit_car/' . $request->id)->with('Message', 'VIN already exists');
            }
        }
        
        if ($modeltxt != "" && $yeartxt != "" && $vintxt != "") {
            $model = DB::table('car')->where('id', $request->id)->update([
                'modelId'     => $modeltxt,
                'colorId'     => $colortxt,
                'categoryId'  => $catetxt,
                'year'        => $yeartxt,
                'vin'         => $vintxt,
                'mile'        => $miletxt,
                'condition'   => $conditiontxt,
                'status'      => $statustxt,
                'image'       => $fileName,
                'updated_at'  => date('Y-m-d H:i:s', strtotime('+7 hours')),
            ]);
    
            if ($model) {
                return redirect('/admin/list_car');
            }
        } else {
            return redirect('/admin/edit_car/' . $request->id)->with('Message', 'Invalid Input');
        }
    }
    
    

    public function updateImportSubmit(Request $request){
        $price = $request->pricetxt;
        if($price!=''){
            $Update = DB::table('importcar')->where('id',$request->id)->update([
                'importPrice' => $price,
                'updated_at' => now()
            ]);
            if($Update){
                return redirect('/admin/list_import')->with('Message','Update Success');
            }else{
                
                return redirect('/admin/edit_importCar/'.$request->id)->with('Message','Update Fail');
            }
        }else{
            return redirect('/admin/edit_importCar/'.$request->id)->with('Message','Invalid Input');
        }
    }

    public function updateSaleSubmit(Request $request){
        $fname = $request->firstname;
        $lname = $request->lastname;
        $email = $request->email;
        $address = $request->address;
        $idCard = $request->idCard;
        if($fname && $lname && $email && $address && $idCard ){
            $update = DB::table('sale_detail')->where('id',$request->id)->update([
                'firstName' => $fname,
                'lastName'  => $lname,
                'email'     => $email,
                'address'   => $address,
                'idCard'    => $idCard,
                'updated_at'  => date('Y-m-d H:i:s', strtotime('+7 hours')),
            ]);
            if($update){
                return redirect('/admin/list_sale')->with('Message','Update Success');
            }else{
                return redirect('/admin/edit_sale/'.$request->id)->with('Message','Update Fail');
            }
        }else{
            return redirect('/admin/edit_sale/'.$request->id)->with('Message','Invalid Input');
        }
    }

    public function updateCustomerSubmit(Request $request){
    

    // Retrieve validated data
    $idCard = $request->idCard;
    $dataToUpdate = [];

    // Dynamically build the update array
    if ($request->filled('name')) {
        $dataToUpdate['name'] = $request->name;
    }
    if ($request->filled('phone')) {
        $dataToUpdate['contact_number'] = $request->phone;
    }
    if ($request->filled('address')) {
        $dataToUpdate['address'] = $request->address;
    }
    if ($request->filled('gender')) {
        $dataToUpdate['gender'] = $request->gender;
    }

    // Add the updated_at timestamp
    $dataToUpdate['updated_at'] = now();

    // Check if the customer exists
    $DbCheck = DB::table('customer')->where('idCard', $idCard)->first();

    if ($DbCheck) {
        if($request->name != "" && $request->phone !="" && $request->address !="" && $request->idCard !="" ){
            // Update the existing customer
        $update = DB::table('customer')
        ->where('id', $request->id)
        ->update($dataToUpdate);

    if ($update) {
        return redirect('/admin/list_customer')->with('Message', 'Update Success');
    } else {
        return redirect('/admin/new_customer')->with('Message', 'Update Failed');
    }
        }else{
            return redirect('/admin/edit_customer/'.$request->id)->with('Message', 'Invalid Input');
        }
        
    } else {
        return redirect('/admin/new_customer')->with('Message', 'Customer Not Found');
    }
    }

//==============================================================================================================


    public function deleteCate($id){
        $delete = DB::table('category')->where('id',$id)->delete();
        if($delete){
            return redirect('/admin/list_category');
        }

    }
    
    public function deleteModel($id){
        $delete = DB::table('model')->where('id',$id)->delete();
        if($delete){
            return redirect('/admin/list_model');
        }

    }
    public function deleteBrand($id){
        $delete = DB::table('brand')->where('id',$id)->delete();
        if($delete){
            return redirect('/admin/list_brand');
        }
    }
    public function deleteColor($id){
        $delete = DB::table('color')->where('id',$id)->delete();
        if($delete){
            return redirect('/admin/list_color');
        }
    }
    public function deleteUsers($id){
        $delete = DB::table('users')->where('id',$id)->delete();
        if($delete){
            return redirect('/admin/list_users');
        }

    }
    public function deleteCustomer($id){
        $delete = DB::table('customer')->where('id',$id)->delete();
        if($delete){
            return redirect('/admin/list_customer');
        }
    }
    public function saleSubmitUser(Request $request) {
        $cartxt = $request->input('cartxt');
        $customerId = $request->customertxt;
        $sale_price = $request->input('price');
        $currentDateTime = date('Y-m-d H:i:s', strtotime('+7 hours')); 
    
      
    
        if (!empty($cartxt)) {
            DB::transaction(function () use ($cartxt, $sale_price, $currentDateTime ,$customerId ) {

                $salePrice = DB::table('set_sale_price')
                ->where('carId', $cartxt)
                ->value('setSalePrice');

                
            
            // Retrieve the import price from the importcar table
            $importPrice = DB::table('importcar')
                ->where('carId', $cartxt)
                ->value('importPrice');


                // Insert the new sale price into the set_sale_price table
                DB::table('sale_detail')->insert([
                    'carId' => $cartxt,
                    'customerId'    => $customerId,
                    'price' => $sale_price,
                    'authorId'  => Auth::user()->id,
                    'saleDate' => $currentDateTime,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime
                ]);

                $sale_detailID = DB::table('sale_detail')
                ->where('carId', $cartxt)
                ->value('id');

                $sale_price = DB::table('sale_detail')
                ->where('id', $sale_detailID)
                ->value('price');


                DB::table('income')->insert([
                    'sale_detail_id' => $sale_detailID,
                    // 'salePrice'=> $sale_price,
                    'importPrice' =>$importPrice,
                    'profit' =>$sale_price-$importPrice,
                    'authorId' => Auth::user()->id,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime
                ]);
    
                // Update the car price in the car table
                DB::table('car')
                    ->where('id', $cartxt)
                    ->update(['status' => "Unavailable"]);
            });
            return redirect('/user/list_sale')->with('Message', 'Insert successful');
        } else {
            return redirect('/user/new_sale')->with('Message', 'Invalid input');
        }
    }

    public function updateCustomerSubmitUser(Request $request){
    

        // Retrieve validated data
        $idCard = $request->idCard;
        $dataToUpdate = [];
    
        // Dynamically build the update array
        if ($request->filled('name')) {
            $dataToUpdate['name'] = $request->name;
        }
        if ($request->filled('phone')) {
            $dataToUpdate['contact_number'] = $request->phone;
        }
        if ($request->filled('address')) {
            $dataToUpdate['address'] = $request->address;
        }
        if ($request->filled('gender')) {
            $dataToUpdate['gender'] = $request->gender;
        }
    
        // Add the updated_at timestamp
        $dataToUpdate['updated_at'] = now();
    
        // Check if the customer exists
        $DbCheck = DB::table('customer')->where('idCard', $idCard)->first();
    
        if ($DbCheck) {
            if($request->name != "" && $request->phone !="" && $request->address !="" && $request->idCard !="" ){
                // Update the existing customer
            $update = DB::table('customer')
            ->where('id', $request->id)
            ->update($dataToUpdate);
    
        if ($update) {
            return redirect('/user/list_customer')->with('Message', 'Update Success');
        } else {
            return redirect('/user/new_customer')->with('Message', 'Update Failed');
        }
            }else{
                return redirect('/user/edit_customer/'.$request->id)->with('Message', 'Invalid Input');
            }
            
        } else {
            return redirect('/user/new_customer')->with('Message', 'Customer Not Found');
        }
        }

        public function customerSubmitUser(Request $request){
            $name = $request->name;
            $phone = $request->phone;
            $address = $request->address;
            $idCard = $request->idCard;
            $gender = $request->input('gender');
    
    
            $DbCheck = DB::table('customer')->where('idCard',$idCard)->get();
    
            if(count($DbCheck) !=0 )
            {
                return redirect('/user/new_customer')->with('Message','Customer Already Exist');
            }else{
                if($name && $phone && $address && $idCard){
                    $insert = DB::table('customer')->insert([
                        'name'  => $name,
                        'gender'    => $gender,
                        'contact_number' => $phone,
                        'address'   => $address,
                        'idCard'    => $idCard,
                        'authorId'  => Auth::user()->id,
                        'created_at'    => date('Y-m-d H:i:s', strtotime('+7 hours')),
                        'updated_at'    => date('Y-m-d H:i:s', strtotime('+7 hours'))
                    ]);
                    if($insert){
                        return redirect('/user/list_customer')->with('Message','Insert Success');
                    }
                }else{
                    return redirect('/user/new_customer')->with('Message','Invalid Input');
                }
            }
    
    
        }
}
