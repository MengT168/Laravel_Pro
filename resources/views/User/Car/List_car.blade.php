@extends('User.master')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
@import url('https://fonts.googleapis.com/css?family=Open+Sans');
@import url('https://fonts.googleapis.com/css?family=Montserrat');
    #ads {
    margin: 30px 0 30px 0;
   
}

#ads .card-notify-badge {
        position: absolute;
        left: -10px;
        top: -20px;
        background: #f2d900;
        text-align: center;
        border-radius: 30px 30px 30px 30px; 
        color: #000;
        padding: 5px 10px;
        font-size: 14px;

    }

#ads .card-notify-year {
        position: absolute;
        right: -10px;
        top: -20px;
        background: #ff4444;
        border-radius: 50%;
        text-align: center;
        color: #fff;      
        font-size: 14px;      
        width: 50px;
        height: 50px;    
        padding: 15px 0 0 0;
}


#ads .card-detail-badge {      
        background: #f2d900;
        text-align: center;
        border-radius: 30px 30px 30px 30px;
        color: #000;
        padding: 5px 10px;
        font-size: 14px;        
    }

   

#ads .card:hover {
            background: #fff;
            box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

#ads .card-image-overlay {
        font-size: 20px;
        
    }


#ads .card-image-overlay span {
            display: inline-block;              
        }


#ads .ad-btn {
        text-transform: uppercase;
        width: 150px;
        height: 40px;
        border-radius: 80px;
        font-size: 16px;
        line-height: 35px;
        text-align: center;
        border: 3px solid #e6de08;
        display: block;
        text-decoration: none;
        margin: 20px auto 1px auto;
        color: #000;
        overflow: hidden;        
        position: relative;
        background-color: #e6de08;
    }

#ads .ad-btn:hover {
            background-color: #e6de08;
            color: #1e1717;
            border: 2px solid #e6de08;
            background: transparent;
            transition: all 0.3s ease;
            box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
        }

#ads .ad-title h5 {
        text-transform: uppercase;
        font-size: 18px;
    }
</style>
<div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Of Car</h4>
                  <div class="table-responsive pt-3">
                  <form action="/user/list_car" method="get" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <select name="brandID" id="brandID" class="form-control">
                        <option value="">Select Brand</option>
                        @foreach ($model as $value)
                            <option value="{{ $value->brandId }}" >
                                {{ $value->brandName }} 
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary mx-2">Search</button>
                </form>
                  <a href="/user/sold_car" class="btn btn-primary" >Check Sold Car</a>
                  <a href="/user/list_car" class="btn btn-primary" >Refresh</a>
                    <div class="row" id="ads">
       
    @foreach ($car as $value )
    @if ($value->status =="Available")
    <div class="col-md-4">
       
       <div class="card rounded">
            <div class="card-image" style="width: fit-content; height: fit-content; ;" >
                
                <span class="card-notify-badge">{{$value->categoryName}}</span>
                <span class="card-notify-year">{{$value->year}}</span>
                <img class="img-fluid" src="/upload/{{$value->image}}" alt="Alternate Text" style="height: 280px; width: 500px; "  />
            </div>
            <div class="card-image-overlay m-auto">
                <span class="card-detail-badge">{{$value->condition}}</span>
                <span class="card-detail-badge">${{$value->price}}</span>
                <span class="card-detail-badge">Mile : {{$value->mile}}</span>
            </div>
            <div class="card-body text-center">
                <div class="ad-title m-auto">
                    <h5>{{$value->brandName}} - {{$value->modelName}}</h5>
                </div>
                <a class="ad-btn" href="/user/detail/{{$value->id}}">View</a>
            </div>
        </div>
       
    </div>
    @endif
    
                @endforeach
    
</div>  
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
                window.location.href = '/user/delete_model/' + id;
            }
        })
    }
</script>
@endsection