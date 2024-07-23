@extends('master')

@section('Content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Set Sale Price</h4>
                <form class="forms-sample" action="/set_sale_price" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Car</label>
                        <select name="cartxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
                            @foreach ($cars as $car)
                                <option value="{{ $car->id }}">
                                    {{ $car->brandName }}/{{ $car->modelName }}/{{ $car->colorName }}/{{ $car->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sale_price">Price</label>
                        <input type="text" class="form-control" name="sale_price" placeholder="Price">
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
