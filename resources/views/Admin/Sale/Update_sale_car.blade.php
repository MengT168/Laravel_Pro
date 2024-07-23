@extends('Admin.master')

@section('Content')

<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Update Sale</h4>
      <!-- <p class="card-description">
        Basic form elements
      </p> -->
      <form class="forms-sample" action="/admin/updateSaleSubmit" method="post" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">First Name</label>
          <input type="hidden" value="{{$sale[0]->id}}" name="id" >
          <input type="text" class="form-control" value="{{$sale[0]->firstName}}" name="firstname" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Last Name</label>
          <input type="text" class="form-control" value="{{$sale[0]->lastName}}" name="lastname" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Email</label>
          <input type="text" class="form-control" value="{{$sale[0]->email}}" name="email" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Address</label>
          <input type="text" class="form-control" value="{{$sale[0]->address}}" name="address" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">ID Card</label>
          <input type="text" class="form-control" value="{{$sale[0]->idCard}}" name="idCard" placeholder="Name">
          @if (Session::has('Message'))
            <p style="color: red; text-align: center; margin-top: 5px; " >{{Session::get('Message')}}</p>
          @endif
        </div>
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
        <button class="btn btn-light">Back</button>
      </form>
    </div>
  </div>
</div>
</div>
@endsection
