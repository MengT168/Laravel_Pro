@extends('Admin.master')

@section('Content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Update Import Price</h4>
      
      <form class="forms-sample" action="/admin/UpdateimportSubmit" method="post" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Import Car</label>
         
          <select name="importcartxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
         
            <option value="{{$import->id}}">
                {{$import->brandName}}/{{$import->modelName}}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Import Price</label>
          <input type="text" value="{{$import->importPrice}}" class="form-control" name="pricetxt" placeholder="price">
          <input type="hidden" value="{{$import->id}}" class="form-control" name="id" placeholder="price">
        </div>
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
</div>
@endsection