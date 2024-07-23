@extends('Admin.master')

@section('Content')

<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Update Car Model</h4>
      <!-- <p class="card-description">
        Basic form elements
      </p> -->
      <form class="forms-sample" action="/admin/updateModelSubmit" method="post" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Car Model Name</label>
          <input type="hidden" name="id" value="{{$model->id}}" >
          <input type="text" class="form-control" value="{{$model->modelName}}" name="modeltxt" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Brand Name</label>
          <select name="brandtxt" class="form-control">
                <!-- <option value="">Select a Brand</option> -->
            @foreach($brands as $value1)
                <option value="{{ $value1->id }}" @if($value1->id == $model->brandId) selected @endif>
                    {{ $value1->brandName }}
                </option>
            @endforeach
        </select>
          @if (Session::has('Message'))
            <p style="color: red; text-align: center; margin-top: 5px; " >{{Session::get('Message')}}</p>
          @endif
        </div>
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
        <button class="btn btn-light">Cancel</button>
      </form>
    </div>
  </div>
</div>
</div>
@endsection
