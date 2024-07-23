@extends('Admin.master')

@section('Content')

<div class="row">
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Update Color</h4>
      <!-- <p class="card-description">
        Basic form elements
      </p> -->
      <form class="forms-sample" action="/admin/updateColorSubmit" method="post" >
        @csrf
        <div class="form-group">
          <label for="exampleInputName1">Color Name</label>
          <input type="hidden" name="id" value="{{$color->id}}" >
          <input type="text" class="form-control" value="{{$color->colorName}}" name="colortxt" placeholder="Name">
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
