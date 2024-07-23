@extends('User.master')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Of Sale</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                         
                          <th>
                            Car
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Phone
                          </th>
                          <th>
                            Address
                          </th>
                          <th>
                            ID Card
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Author Name
                          </th>
                          <th>
                            Sale Date
                          </th>
                          <!-- <th>
                            Action
                          </th> -->
                        </tr>
                      </thead>
                      <tbody>
                       @foreach ($sale as $value )
                            <tr class="table-info">
                                <td>
                                {{$value->brandName}} / {{$value->modelName}} / {{$value->year}} / {{$value->colorName}} / {{$value->vin}}
                                </td>
                                <td>
                                {{$value->customerName}}
                                </td>
                                <td>
                                    {{$value->contact_number}}
                                </td>
                                <td>
                                    {{$value->address}}
                                </td>
                                <td>
                                    {{$value->idCard}}
                                </td>
                                <td>
                                    {{$value->price}} $
                                </td>
                                <td>
                                    {{$value->name}}
                                </td>
                                <td>
                                    {{$value->saleDate}}
                                </td>
                                <!-- <td>
                                   <a href="/admin/edit_sale/{{$value->id}}" class="btn btn-primary" >Edit</a>
                                   <button class="btn btn-danger" onclick="confirmDelete('{{ $value->id }}')">Delete</button>
                                </td> -->
                                </tr>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete_sale/' + id;
            }
        })
    }
</script>
@endsection