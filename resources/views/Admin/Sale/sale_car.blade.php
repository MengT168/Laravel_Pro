@extends('Admin.master')

@section('Content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sale</h4>
                <form class="forms-sample" action="/admin/sale" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Car</label>
                        <select name="cartxt" class="form-control form-control-lg" id="carSelect">
                            <option value="">Select a car</option>
                            @foreach ($Car as $car)
                                <option value="{{ $car->id }}" data-price="{{ $sale_prices[$car->id] ?? '' }}">
                                    {{ $car->brandName }}/{{ $car->modelName }}/{{ $car->colorName }}/{{ $car->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Customer</label>
                        <select name="customertxt" class="form-control form-control-lg" id="carSelect">
                            <option value="">Select a car</option>
                            @foreach ($sale_details_with_customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{$customer->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" id="priceInput" placeholder="price">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carSelect = document.getElementById('carSelect');
        const priceInput = document.getElementById('priceInput');

        carSelect.addEventListener('change', function() {
            const selectedOption = carSelect.options[carSelect.selectedIndex];
            const recommendedPrice = selectedOption.getAttribute('data-price');
            priceInput.value = recommendedPrice ? recommendedPrice : '';
        });
    });
</script>
@endsection
