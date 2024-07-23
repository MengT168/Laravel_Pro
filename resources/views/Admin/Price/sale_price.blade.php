@extends('Admin.master')

@section('Content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Set Sale Price</h4>
                <form class="forms-sample" action="/admin/set_sale_price" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Car</label>
                        <select name="cartxt" class="form-control form-control-lg" id="exampleFormControlSelect1">
                            @foreach ($cars as $car)
                                <option value="{{ $car->id }}" data-import-price="{{ $car->importPrice }}">
                                    {{ $car->brandName }}/{{ $car->modelName }}/{{ $car->colorName }}/{{ $car->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sale_price">Price</label>
                        <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="Price">
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
        const carSelect = document.getElementById('exampleFormControlSelect1');
        const priceInput = document.getElementById('sale_price');

        carSelect.addEventListener('change', function() {
            const selectedOption = carSelect.options[carSelect.selectedIndex];
            const importPrice = selectedOption.getAttribute('data-import-price');
            priceInput.value = importPrice ? importPrice : '';
        });

        // Trigger change event on page load to set the initial value
        carSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
