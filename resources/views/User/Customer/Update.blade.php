@extends('User.master')

@section('Content')

<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Update Sale</h4>
      <!-- <p class="card-description">
        Basic form elements
      </p> -->
      <form class="forms-sample" action="/user/updateCustomerSubmit" method="post" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Name</label>
          <input type="hidden" value="{{$customer[0]->id}}" name="id" >
          <input type="text" class="form-control" value="{{$customer[0]->name}}" name="name" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Gender</label>
            <select class="form-control" name="gender" id="">
               <option value="Male" {{ $customer[0]->gender == 'Male' ? 'selected' : '' }}  >Male</option>
               <option value="Female" {{ $customer[0]->gender == 'Female' ? 'selected' : '' }} >Female</option>
            </select>
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Phone</label>
          <input type="text" class="form-control" value="{{$customer[0]->contact_number}}" name="phone" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Address</label>
          <input type="text" class="form-control" value="{{$customer[0]->address}}" name="address" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">ID Card</label>
          <input type="text" class="form-control" value="{{$customer[0]->idCard}}" name="idCard" placeholder="Name">
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
