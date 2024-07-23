@extends('Admin.master')

@section('Content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Import New Car</h4>
      
      <form class="forms-sample" action="/admin/importSubmit" method="post" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Import Car</label>
         
          <select name="importcartxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $importCar as $value )
            <option value="{{$value->id}}">
                {{$value->brandName}}/{{$value->modelName}}/{{$value->colorName}}/{{$value->year}}
            </option>
          @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Import Price</label>
          <input type="text" class="form-control" name="pricetxt" placeholder="price">
        </div>
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
</div>
@endsection