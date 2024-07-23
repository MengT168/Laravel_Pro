@extends('master')

@section('Content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">New Car Model</h4>
      <!-- <p class="card-description">
        Basic form elements
      </p> -->
      <form class="forms-sample" action="/carSubmit" method="post" enctype="multipart/form-data" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Car Model Name</label>
         
          <select name="modeltxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $model as $value )
            <option value="{{$value->id}}">
                {{$value->brandName}}/{{$value->modelName}}
            </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Color</label>
         
          <select name="colortxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $color as $value )
            <option value="{{$value->id}}">
                {{$value->colorName}}
            </option>
            @endforeach
          </select>
          
         
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Category</label>
         
          <select name="catetxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $cate as $value )
            <option value="{{$value->id}}">
                {{$value->categoryName}}
            </option>
            @endforeach
          </select>
          
         
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Year</label>
          <input type="text" class="form-control" name="yeartxt" placeholder="Year">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Vehicle Identification Number</label>
          <input type="text" class="form-control" name="vintxt" placeholder="VIN">
        </div>
        <!-- <div class="form-group">
          <label for="exampleInputName1">Price</label>
          <input type="text" class="form-control" name="pricetxt" placeholder="Price">
        </div> -->
        <div class="form-group">
          <label for="exampleInputName1">Status</label>
          <select name="statustxt" id="" class="form-control" >
            <option value="Available">Available</option>
            <option value="Unvailable">Unvailable</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Condition</label>
          <select name="conditiontxt" id="" class="form-control" >
            <option value="Used">Used</option>
            <option value="New">New</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Mileage </label>
          <input type="text" class="form-control" name="miletxt" placeholder="Mile">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Image</label>
          <input type="file" class="form-control" name="img">
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