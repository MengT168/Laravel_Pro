@extends('Admin.master')

@section('Content')
<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">New Customer</h4>
      <form class="forms-sample" action="/admin/customerSubmit" method="post" >
        @csrf
        <div class="form-group">
            <label for="lname">Name</label>
            <input type="text" class="form-control" name="name" placeholder="last name">
        </div>
        <div class="form-group">
            <label for="lname">Name</label>
            <select name="gender" class="form-control" >
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone" placeholder="phone">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" placeholder="address">
        </div>
        <div class="form-group">
            <label for="idcard">ID Card</label>
            <input type="text" class="form-control" name="idCard" placeholder="ID Card">
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

                    