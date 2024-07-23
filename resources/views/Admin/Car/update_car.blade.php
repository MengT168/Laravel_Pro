@extends('Admin.master')

@section('Content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Update Car Model</h4>
     
      <form class="forms-sample" action="/admin/UpdatecarSubmit" method="post" enctype="multipart/form-data" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Car Model Name</label>
         
          <select name="modeltxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $model as $value )
          <option value="{{ $value->id }}" @if($car && $value->id == $car->modelId) selected @endif>
                {{$value->brandName}}/{{$value->modelName}}
            </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Color</label>
         
          <select name="colortxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $color as $value )
          <option value="{{ $value->id }}" @if($value->id == $car->colorId) selected @endif>
                {{$value->colorName}}
            </option>
            @endforeach
          </select>
          
         
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Category</label>
         
          <select name="catetxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $cate as $value )
          <option value="{{ $value->id }}" @if($value->id == $car->categoryId) selected @endif>
                {{$value->categoryName}}
            </option>
            @endforeach
          </select>
          
         
        </div>
       
        
        
        <div class="form-group">
          <label for="exampleInputName1">Year</label>
          <input type="text" value="{{$car->year}}"  class="form-control" name="yeartxt" placeholder="Year">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Vehicle Identification Number</label>
          <input type="text" value="{{$car->vin}}"  class="form-control" name="vintxt" placeholder="VIN">
        </div>
      
        <div class="form-group">
          <label for="exampleInputName1">Status</label>
          <select name="statustxt" id="" class="form-control" >
            <option value="Available" @if($car->status == 'Available') selected @endif>Available</option>
            <option value="Unvailable" @if($car->status == 'Unvailable') selected @endif>Unvailable</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Condition</label>
          <select name="conditiontxt" id="" class="form-control" >
          <option value="Used" @if($car->condition == 'Used') selected @endif>Used</option>
        <option value="New" @if($car->condition == 'New') selected @endif>New</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Mileage </label>
          <input type="text" value="{{$car->mile}}"  class="form-control" name="miletxt" placeholder="Mile">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Image</label>
          <input type="hidden" name="id" value="{{$car->id}}" >
          <input type="file" class="form-control" name="img">
          <img src="/upload/{{$car->image}}" height="100" alt="">
        </div>
       
        @if (Session::has('Message'))
            <p style="color: red; text-align: center; margin-top: 5px; " >{{Session::get('Message')}}</p>
          @endif
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
</div>
@endsection