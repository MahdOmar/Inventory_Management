

@extends('layouts.layout')

@section('content')


  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="{{ route('quotes.index') }}" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Devis / Détails</h2>
    
  </div>  


<div class="card">
    <fieldset  class="form-group  p-3" style="bquotedetails:2px solid #dee2e6 ">
      <legend class="w-auto px-2"><b>Informations Devis N° {{ $quote->id }} </b></legend>
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
            <input type="text" class="form-control d-none" name='quoteId' id = "quoteId"value="{{ $quote->id }}"  >
            <div class="form-group">
              <label for="">Client <span class="text-danger">*</span></label>                           

              <input type="text" class="form-control" name='client' id="client"  value="{{ $quote->client }}" disabled>
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
              <div class="form-group">
                  <label for="">Téléphone <span class="text-danger">*</span></label>                           
  
                  <input type="phone" class="form-control" name='phone' id="phone" value="{{ $quote->phone }}" disabled >
              </div>
          </div>

          <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <label for="">Date <span class="text-danger">*</span></label>                           

                <input type="text" class="form-control" name='phone' id="phone" value="{{ $quote->created_at->format('d-m-Y')}}" disabled >
            </div>
        </div>
        
  
       
      
  
  
  
  </fieldset>
  
</div>
  

 









<div class=" d-flex ">

  <div class="card  p-2">
    <form action="{{ route('quotedetails.store', $quote->id ) }}" method="POST">
      @csrf
      <fieldset  class="form-group  p-3" style="bquotedetails:2px solid #dee2e6 ">
        <legend class="w-auto px-2"><b>Details Devis</b></legend>
       
          <div class="">
           
                
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
          
          <input type="text" class="form-control d-none" name='quotedetailsId' id = "quotedetailsId" value=""  >
          <input type="text" class="form-control d-none" name='quoteId' id = "quoteId"value="{{ $quote->id }}"  >
          
  
            <div class="">
              <div class="form-group">
                <label for=""> Article <span class="text-danger">*</span></label>                           

                <select name="productId" id="productId" class="form-control show-tick">
                  <option value="">-- Selectionner --</option>
                  @foreach ($products as $product)
                  <option value="{{ $product->id }} {{old('productId') == $product->id ? 'selected' : ''}}">{{ $product->designation }}</option>
                      
                  @endforeach
               
              </select>
              </div>
          </div>
  
        
  
  
            <div class=" row">
                <div class="form-group col-lg-6 col-md-6">
                    <label for="">Quantity <span class="text-danger">*</span></label>                           
    
                    <input type="double" class="form-control" name='quantity' id="quantity" placeholder="Quantity" >
                </div>

                <div class="form-group col-lg-6 col-md-6">
                  <label for="">Prix <span class="text-danger">*</span></label>                           
  
                  <input type="double" class="form-control" name='price' id="price" placeholder="Prix de Vente" >
              </div>

             

              
            </div>

          
          
    
       <div class="row">
          <div class="col-md-4 col-lg-4 ">
            <button type="submit" id="btn" class="  btn btn-primary m-2 ">Ajouter</button>

          </div>
         
       </div>

      
       
    
    
   
    
    </fieldset>
    
    
    
    </form>

  </div>

 



  <div class=" flex-grow-1 card p-4 ml-2">
   
     
      <div class="body">
        <table id="selectedColumn" class="table table-striped table-bquotedetailsed table-sm" cellspacing="0" width="100%">
          <thead>
            <tr>
           

             
              <th class="th-sm">Désignation
              </th>

              <th class="th-sm">Quantity
              </th>

              <th class="th-sm">Prix Unitaire
              </th>

              

              
              <th class="th-sm">Montant
              </th>
             
              <th class="th-sm">Actions
              </th>
            </tr>
          </thead>
          <tbody>

            @if (count($quotedetails) > 0)
            @php
                $total = 0;
            @endphp

              @foreach ($quotedetails as $item)
              <tr>
                   @php
                    $product = \App\Models\Product::where('id',$item->productId)->first();
                    $total += $item->price * $item->quantity;
                   @endphp
                     <td>{{ $product->designation }}</td>
                     <td>{{ $item->quantity }}</td>
                     <td>{{ number_format($item->price, 2, '.', ' ') }}</td>
                     <td>{{ number_format($item->price * $item->quantity, 2, '.', ' ')  }}</td>
                  
                     <td><a  onclick="getDetail({{  $item->id }})" data-toggle='tooltip' role="button" title="edit" data-placement="bottom" class="float-left btn btn-sm btn-warning ml-2 "><i class="fa fa-edit " ></i></a>
                      
                       <form class="float-left ml-2" action="{{ route('quotedetails.destroy',$item->id) }}" method="POST">
                           @csrf
                           
                          
                           <a data-toggle='tooltip' title="delete" data-id=""  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>
         
                       </form>
                      </td>


                    </tr>
              @endforeach
              <tr>
                <th colspan="3" class="text-right">Total</th>
                <td class="d-none" ></td>
                <td class="d-none"></td>
                <td colspan="2" class="text-success"><b>{{ number_format($total, 2, '.', ' ')  }} DA </b></td>
                <td class="d-none"></td>
              </tr>
                
            @else
                
            @endif

           
          </tbody>
        </table>
      
        <div class="col-lg-12 col-md-12 mt-4  ">
          <a  href="{{ route("quote.print",$quote->id) }}" data-toggle='tooltip' role="button" title="Imprimer" data-placement="bottom" class="float-right btn btn-sm btn-success ml-2 ">Imprimer</a>
        </div>
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
        var path="{{ route('quotedetails.show',':id') }}".replace(':id',id);
       
        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                id:id
            },
            success:function(data){
               $('#quotedetailsId').val(data.quotedetails.id);
               $('#productId').val(data.quotedetails.productId+" ").change();
               $('#quantity').val(data.quotedetails.quantity);
               $('#price').val(data.quotedetails.price);
             

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


  $(document).on('change','#productId',function(e)
  {
    var id =  $('#productId').val();
console.log('yeeeeeeeeees');


          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        var token="{{ csrf_token() }}";
        var path="{{ route('quotedetails.price',':id') }}".replace(':id',id);
       
        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                id:id
            },
            success:function(data){

               
               $('#price').val(data.product.price_v);
               $('#quantity').val(data.product.quantity);
             

              


          
        
            
            }
        })
        

  })





    
 
</script>