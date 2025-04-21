

@extends('layouts.layout')

@section('content')

<div class="row ">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Commandes</h2>
    
</div>  








<div class="col-lg-12 col-md-12 col-sm-12  ">

  <form action="{{ route('order.store') }}" method="POST">
    @csrf
    <fieldset  class="form-group  p-3" style="border:2px solid #dee2e6 ">
      <legend class="w-auto px-2"><b>Informations Commande</b></legend>
      <div class="row clearfix">
        <div class="col-lg-12 ">
         
              
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{$error}}</li>
                      
                  @endforeach
              </ul>
  
          </div>
         
              
          @endif
        </div>
          <div class="col-lg-3 col-md-3">
            <input type="text" class="form-control d-none" name='order_id' id = "order_id"value=""  >
            <div class="form-group">
              <label for="">Client <span class="text-danger">*</span></label>                           

              <input type="text" class="form-control" name='client' id="client" placeholder="Client" >
            </div>
          </div>

          <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <label for="">Téléphone <span class="text-danger">*</span></label>                           
  
                <input type="phone" class="form-control" name='phone' id='phone' placeholder="Téléphone" >
            </div>
        </div>

          <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <label for="">Designation <span class="text-danger">*</span></label>                           
  
                <input type="text" class="form-control" name='designation' id='designation' placeholder="Designation" >
            </div>
        </div>

      


          <div class="col-lg-3 col-md-3">
              <div class="form-group">
                  <label for="">Quantity <span class="text-danger">*</span></label>                           
  
                  <input type="double" class="form-control" name='quantity' id="quantity" placeholder="Quantity" >
              </div>
          </div>
        
  
       
      <div class="col-lg-3 col-md-3 m-2 ">
        <button type="submit" id="btn" class="  btn btn-primary ">Ajouter</button>
      
    </div>
  
  
  
  </fieldset>
  
  
  
  </form>



  <div class="card p-4">
   
     
      <div class="body">
        <table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead>
            <tr>
           

              <th class="th-sm">Client
              </th>
              <th class="th-sm">Téléphone
              </th>

              <th class="th-sm">Désignation
              </th>

              <th class="th-sm">Quantity
              </th>

              

              
              <th class="th-sm">Date
              </th>
             
              <th class="th-sm">Status
              </th>

              
        
              <th class="th-sm">Actions
              </th>
            </tr>
          </thead>
          <tbody>

            @if (count($orders) > 0)
            
              @foreach ($orders as $order)
              <tr>
              <td>{{ $order->client }}</td>
              <td>{{ $order->phone }}</td>
              <td>{{ $order->designation }}</td>
              <td>{{ $order->quantity }}</td>
              <td>{{ $order->created_at->format('d-m-Y')  }}</td>
              @if ($order->status == "not_completed")
              <td class="text-danger" style="font-size: 20px"> <i class="fa fa-spinner  m-1"></i></i>En attente</td>
                
              @else
              <td class="text-success" style="font-size: 20px"> <i class="fa fa-check-square  m-1 " > </i>Livré</td>
              @endif
              <td><a  onclick="getDetail({{ $order->id }})" data-toggle='tooltip' role="button" title="edit" data-placement="bottom" class="float-left btn btn-sm btn-warning ml-2 "><i class="fa fa-edit " ></i></a>
                <a  href="" data-toggle='tooltip' role="button" title="info" data-placement="bottom" class="float-left btn btn-sm btn-primary ml-2 "><i class="fa fa-info"></i></a>
                <form class="float-left ml-2" action="{{ route('order.destroy',$order->id) }}" method="POST">
                    @csrf
                  
                    <a data-toggle='tooltip' title="delete" data-id="{{ $order->id }}"  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>
  
                </form></td>
              </tr>
                  
              @endforeach

            
              
            @endif
          

                  
            
              
             
           
                
         
           
           
        
        </table>
      
      
         
      </div>
          
      </div>
  </div>
  

 

@endsection


<script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ asset("js/popper.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

function getDetail(id)
    {
  console.log(id);
  

        var token="{{ csrf_token() }}";
        var path="{{ route('order.show',':id') }}".replace(':id',id);
       
        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                id:id
            },
            success:function(data){
               $('#order_id').val(data.order.id);
               $('#client').val(data.order.client);
               $('#phone').val(data.order.phone);
               $('#designation').val(data.order.designation);
               $('#quantity').val(data.order.quantity);

               $('#btn').html('Update');


          
        
            
            }
        })
    }

 
  $(document).on('click','.dltBtn',function(e)
  {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        var form = $(this).closest('form');
        var dataId = $(this).data('id');
        e.preventDefault();
        
       
        swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
      
        form.submit();
        swal("Poof! Your imaginary file has been deleted!", {
          icon: "success",
        });
        } else {
        swal("Your imaginary file is safe!");
        }
        });
        

        

  })



    
 
</script>
