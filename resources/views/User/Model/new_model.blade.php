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
      <form class="forms-sample" action="/modelSubmit" method="post" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Car Model Name</label>
          <input type="text" class="form-control" name="modeltxt" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Car Brand Name</label>
         
          <select name="brandtxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
          @foreach ( $brand as $value )
            <option value="{{$value->id}}">
                {{$value->brandName}}
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