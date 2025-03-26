

@extends('layouts.layout')

@section('content')

<div class="row ">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="{{ route('purchases.index') }}" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Achats / Détails</h2>
    
</div>  








<div class="col-lg-12 col-md-12 col-sm-12  ">

  <form action="{{ route('details.store', $purchase->id ) }}" method="POST">
    @csrf
    <fieldset  class="form-group  p-3" style="border:2px solid #dee2e6 ">
      <legend class="w-auto px-2"><b>Détails Achat N° {{ $purchase->id }} </b></legend>
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
         
     
        <div class="col-lg-6 col-md-6">
          <input type="text" class="form-control d-none" name='purchasedetails_id' id = "purchasedetails_id" value=""  >
          <input type="text" class="form-control d-none" name='purchaseId' id = "purchaseId" value="{{ $purchase->id }}"  >

          <div class="form-group">
            <label for=""> Article <span class="text-danger">*</span></label>                           

            <select name="productId" id="productId"  class="selectpicker form-control show-tick"  data-live-search="true">
              <option value="">-- Selectionner --</option>
              @foreach ($products as $product)
              <option value="{{ $product->id }} {{old('productId') == $product->id ? 'selected' : ''}}">{{ $product->designation }}</option>
                  
              @endforeach
           
          </select>
           </div>
        </div>

        <div class="col-lg-6 col-md-6">
          <div class="form-group">
            <label for=""> Quantité <span class="text-danger">*</span></label>                           

            <input type="number" class="form-control" id= "quantity"name='quantity' step="0.01" placeholder="Quantité" >
           </div>
        </div>

      

        <div class="col-lg-6 col-md-6">
          <div class="form-group">
            <label for=""> Prix_A <span class="text-danger">*</span></label>                           

            <input type="number" step="0.01" class="form-control" id="price_a" name='price_a' placeholder="Prix Achat" >
           </div>
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
              <th class="th-sm">Article
              </th>

              <th class="th-sm">Quantité
              </th>

              
              <th class="th-sm">Prix_A
              </th>
             
        
              <th class="th-sm">Actions
              </th>
            </tr>
          </thead>
          <tbody>

            
           
           
            

              @if (count($purchasedetails) > 0 )
              <tr>

                @foreach ($purchasedetails as $item)

              @php
              $product = \App\Models\Product::where('id',$item->productId)->first();
              @endphp

              <td>{{ $product->designation }}</td>
              <td>{{ $item->quantity }}</td>
              <td>{{ $item->price_a }}</td>
           
              <td><a  onclick="getDetail({{  $item->id }})" data-toggle='tooltip' role="button" title="edit" data-placement="bottom" class="float-left btn btn-sm btn-warning ml-2 "><i class="fa fa-edit " ></i></a>
              
                <form class="float-left ml-2" action="{{ route('details.destroy',$item->id) }}" method="POST">
                    @csrf
                    
                   
                    <a data-toggle='tooltip' title="delete" data-id=""  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>
  
                </form></td>
              </tr>
              
              @endforeach
                  
              @else
                  
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
  
  

        var token="{{ csrf_token() }}";
        var path="{{ route('details.show',':id') }}".replace(':id',id);

        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                id:id
            },
            success:function(data){
              
               $('#productId').val(data.purchasedetails.productId+" ").change();
               $('#quantity').val(data.purchasedetails.quantity);
               $('#price_a').val(data.purchasedetails.price_a);



               $('#purchasedetails_id').val(data.purchasedetails.id);
               console.log( data.purchasedetails.id);
               
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