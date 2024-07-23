@extends('Admin.master')

@section('Content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Update Users</h4>
      <!-- <p class="card-description">
        Basic form elements
      </p> -->
      <form class="forms-sample" action="/admin/UpdateUserSubmit" method="post" >
        @csrf
        @foreach ($users as $value )
        <div class="form-group">
            <input type="hidden" name="id" value="{{$value->id}}" >
          <label for="exampleInputName1">Name</label>
          <input type="text" value="{{$value->name}}" class="form-control" name="name" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Email</label>
          <input type="text" value="{{$value->email}}" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Password</label>
          <input type="password" value="{{$value->password}}" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Status</label>
          <select name="status" id="" class="form-control" >
            <option value="1" @if($value->status == 1) selected @endif >Admin</option>
            <option value="0"  @if($value->status == 0) selected @endif >User</option>
            <option value=""  @if($value->status == 0) selected @endif >Band</option>
          </select>
          @if (Session::has('Message'))
            <p style="color: red; text-align: center; margin-top: 5px; " >{{Session::get('Message')}}</p>
          @endif
        </div>
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
        <a href="/admin/list_users" class="btn btn-success" >Back</a>
        @endforeach
      </form>
    </div>
  </div>
</div>
</div>
@endsection