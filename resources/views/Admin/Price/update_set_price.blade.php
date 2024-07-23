@extends('Admin.master')

@section('Content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Update Sale Price</h4>
                <form class="forms-sample" action="/admin/set_sale_price" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Car</label>
                        <select name="cartxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
                                <option value="{{ $setPrice->id }}" >
                                    {{ $setPrice->brandName }}/{{ $setPrice->modelName }}
                                </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sale_price">Price</label>
                        <input type="text" value="{{$importPrice}}" class="form-control" id="sale_price" name="sale_price" placeholder="Price">
                    </div>
                    @if (Session::has('Message'))
                        <p style="color: red; text-align: center; margin-top: 5px;">{{ Session::get('Message') }}</p>
                    @endif 
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="button" class="btn btn-light" onclick="window.location='{{ url()->previous() }}'">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
