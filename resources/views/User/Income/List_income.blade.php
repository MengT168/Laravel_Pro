@extends('User.master')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="col-lg-12 stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">List Of Income</h4>

      <!-- Search Form -->
      <form action="/user/list_income" method="GET">
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="startdate">Start Date</label>
            <input type="date" class="form-control" id="startdate" name="startdate" value="{{ request()->get('startdate') }}">
          </div>
          <div class="form-group col-md-5">
            <label for="enddate">End Date</label>
            <input type="date" class="form-control" id="enddate" name="enddate" value="{{ request()->get('enddate') }}">
          </div>
          <div class="form-group col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </div>
      </form>

      <div class="table-responsive pt-3">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Car</th>
              <th>Sale Price</th>
              <th>Import Price</th>
              <th>Profit Money</th>
              <th>Author Name</th>
              <th>Sale Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($income as $value)
            <tr class="table-info">
              <td>{{ $value->id }}</td>
              <td>{{ $value->brandName }} / {{ $value->modelName }} / {{ $value->year }} / {{ $value->colorName }} / {{ $value->vin }}</td>
              <td>{{ $value->price }} $</td>
              <td>{{ $value->importPrice }} $</td>
              <td>{{ $value->profit }} $</td>
              <td>{{ $value->name }}</td>
              <td>{{ $value->created_at }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
