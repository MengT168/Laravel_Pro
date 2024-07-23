@extends('Admin.master')



@section('Content')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Of Model</h4>
                  <!-- <p class="card-description">
                    Add class <code>.table-{color}</code>
                  </p> -->
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Created_At
                          </th>
                          <th>
                            Updated_At
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                       @foreach ($users as $value )
                            <tr class="table-info">
                                <td>
                                    {{$value->id}}
                                </td>
                                <td>
                                    {{$value->name}}
                                </td>
                                <td>
                                    {{$value->email}}
                                </td>
                                <td>
                                    {{$value->status}}
                                </td>
                                <td>
                                    {{$value->created_at}}
                                </td>
                                <td>
                                    {{$value->updated_at}}
                                </td>
                                <td>
                                   <a href="/admin/update_users/{{$value->id}}" class="btn btn-primary" >Update</a>
                                   <button class="btn btn-danger" onclick="confirmDelete('{{ $value->id }}')">Delete</button>
                                </td>
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
                window.location.href = '/admin/delete_users/' + id;
            }
        })
    }
</script>
@endsection