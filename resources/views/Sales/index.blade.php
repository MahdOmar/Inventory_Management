

@extends('layouts.layout')

@section('content')


  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Ventes</h2>
    
  </div>  



   
  <div class=" d-flex justify-content-around mb-3">
    @php
   
    $total_sales = $sales->sum('total_amount');
    $today_sales = \App\Models\Payment::whereDate('created_at',Illuminate\Support\Carbon::today())->sum('amount');
   @endphp
    

      <div class="caisse_total d-flex">
        <img src="{{ asset('images/caisse.png') }}" alt=""  width="80" height="120">
        <h4 class="ml-4 mt-4" >Total: <b class="text-primary">{{ number_format($total_sales, 2, '.', ' ')  }} DA </b></h4>
  
      </div>
  
      <div class="caisse_today d-flex">
        <img src="{{ asset('images/caisse_today.png')  }}" alt="" width="80" height="120">
        <h4   class="ml-4 mt-4" >Aujourd'hui: <b class="text-success">{{ number_format($today_sales, 2, '.', ' ')  }} DA </b></h4>
      </div>
  
  
  
  
    

  </div>
  
 

 









<div class=" d-flex ">

  <div class="card  p-2 w-25">
    <form action="" method="POST">
      @csrf
      <fieldset  class="form-group  p-3" style="bquotedetails:2px solid #dee2e6 ">
        <legend class="w-auto px-2"><b>Details Vente</b></legend>
       
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
          

          <input type="text" class="form-control d-none" name='saleId' id = "saleId"value=""  >
          
  
           
              <div class="form-group col-lg-12 col-md-12">
                <label for=""> Devis <span class="text-danger">*</span></label>                           

                <select name="quoteId" id="quoteId" class="form-control show-tick">
                  <option value="">-- Selectionner --</option>
                  @foreach ($quotes as $quote)
                  <option value="{{ $quote->id }} {{old('quoteId') == $quote->id ? 'selected' : ''}}">#{{ $quote->id }} de {{ $quote->client }}</option>
                      
                  @endforeach
               
              </select>
              </div>
          
  
        
     
          
           
               

                <div class="form-group col-lg-12 col-md-12">
                  <label for="">Montant <span class="text-danger">*</span></label>                           
  
                  <input type="double" class="form-control" name='amount' id="amount" placeholder="Montant" >
              </div>
           
              
          
    
         
        <div class="col-lg-3 col-md-3 m-2 ">
          <button type="submit" id="btn" class="  btn btn-primary ">Ajouter</button>
        
      </div>
    
    
    
    </fieldset>
    
    
    
    </form>

  </div>

 



  <div class=" flex-grow-1 card p-4 ml-2">
   
     
      <div class="body">
        <table id="selectedColumn" class="table table-striped table-bquotedetailsed table-sm" cellspacing="0" width="100%">
          <thead>
            <tr>
           

             <th class="th-sm"> Num

             </th>
              <th class="th-sm">Devis
              </th>

              <th class="th-sm">Client
              </th>


              <th class="th-sm">Montant
              </th>

              <th class="th-sm">Date
              </th>

            
              

              <th class="th-sm">Actions
              </th>
            </tr>
          </thead>
          <tbody>

             @if (count($payments) > 0)
          

              @foreach ($payments as $item)
              <tr>
                   @php
                    $sale = \App\Models\Sale::find($item->saleId);
                    $quote = \App\Models\Quote::find($sale->quoteId);
                  
                   @endphp
                     <td>{{ $item->id }}</td>
                     <td>#{{ $quote->id }}</td>
                     <td>{{ $quote->client }}</td>
                     <td>{{ number_format($item->amount, 2, '.', ' ')  }}</td>
                     <td>{{ $item->created_at->format('d-m-Y')  }}</td>
                  
                     <td>
                      
                       <form class="float-left ml-2" action="{{ route('payment.destroy',$item->id) }}" method="POST">
                           @csrf
                           <a  href="{{ route("payment.print",$item->id) }}" data-toggle='tooltip' role="button" title="info" data-placement="bottom" class="float-left btn btn-sm btn-success mr-2 " target="_blank"><i class="fa fa-print"></i></a>
                          
                           <a data-toggle='tooltip' title="delete" data-id=""  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>
         
                       </form>
                      </td>


                    </tr>
              @endforeach
             
            @else
                
            @endif 

           
          </tbody>
        </table>
      
      
         
      </div>
          
      </div>
  </div>

  <div class="  card p-4 ml-2">
   
     <h4 class="text-primary">Recap</h4>
    <div class="body">
      <table id="selectedColumn" class="table table-striped table-bquotedetailsed table-sm" cellspacing="0" width="100%">
        <thead class="bg-primary text-white">
          <tr>
         

           <th class="th-sm"> Num

           </th>
            <th class="th-sm">Devis
            </th>

            <th class="th-sm">Client
            </th>


            <th class="th-sm">Montant Payé
            </th>

            <th class="th-sm">Montant Reste
            </th>

            <th class="th-sm">Status
            </th>

          
            

            <th class="th-sm">Actions
            </th>
          </tr>
        </thead>
        <tbody>

          @if (count($sales) > 0)
           @foreach ($sales as $item)
           <tr>
            @php
            
             $quote = \App\Models\Quote::find($item->quoteId);
             $total_paid = \App\Models\Payment::where('saleId',$item->id)->sum('amount');
            
            @endphp
              <td>{{ $item->id }}</td>
              <td>#{{ $quote->id }}</td>
              <td>{{ $quote->client }}</td>
              <td>{{ number_format($total_paid, 2, '.', ' ')  }}</td>
              <td>{{ number_format($quote->total - $total_paid, 2, '.', ' ')  }}</td>
              <td>
                @if ($item->status == 'paid')

                Payé
                    
                @else
                    Partiel
                @endif
              </td>
           
              <td>
                <a  href="{{ route("sale.print",$item->id) }}" data-toggle='tooltip' role="button" title="info" data-placement="bottom" class="float-left btn btn-sm btn-success ml-2 " target="_blank"><i class="fa fa-print"></i></a>
               
                <form class="float-left ml-2" action="{{ route('sales.destroy',$item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                   
                    <a data-toggle='tooltip' title="delete" data-id=""  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>
  
                </form>
               </td>


             </tr>

               
           @endforeach
              
          @else
              
          @endif

           
         
        </tbody>
      </table>
    
    
       
    </div>
        
    </div>
  

 

@endsection

<script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ asset("js/popper.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>



 
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




  $(document).on('change','#quoteId',function(e)
  {
    var id =  $('#quoteId').val();

    console.log('fdkfdks'+id);
    


          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        var token="{{ csrf_token() }}";
        var path="{{ route('sale.price',':id') }}".replace(':id',id);
       
        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                id:id
            },
            success:function(data){

               
               $('#amount').val(data.total);
             

            
            }
        })
        

  })




    
 
</script>