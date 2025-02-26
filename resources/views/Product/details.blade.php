

@extends('layouts.layout')

@section('content')

<div class="row ">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Stock / {{  $product->designation }} / Historique</h2>
    
</div>  








<div class="col-lg-12 col-md-12 col-sm-12  ">



  <div class="card p-4">
   
     
      <div class="body">
        <table  class="table table-striped table-bordered table-sm p-2" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="th-sm">Référence
              </th>

              <th class="th-sm">Fournisseur / Client
              </th>
              
              <th class="th-sm">Date
              </th>
              
              <th class="th-sm">Quantité
              </th>
              <th class="th-sm">Prix_A / Prix_V
              </th>
            
             
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="5" class="text-center text-white bg-primary">Achat</th>
             
            </tr>
            @php
            $total_quantity_purchase = 0;
        @endphp
            @if (count($purchasedetails) > 0)
          
            <tr>
              @foreach ($purchasedetails as $item)

              @php
                  $total_quantity_purchase += $item->quantity;
              @endphp

              <td>{{ $item->purchaseId }}</td>
              <td>{{ \App\Models\Purchase::find($item->purchaseId)->Supplier }}</td>
              <td>{{ \App\Models\Purchase::find($item->purchaseId)->Date }}</td>
            
              <td>{{ $item->quantity }}</td>
              <td>{{ $item->price_a }}</td>
             
             
                  
             
             
            </tr>
            @endforeach
             
            @else
            
            @endif

            <tr class=" text-white bg-primary">
              <th colspan="3" class="text-center ">Total Quantité Acheté</th>
              <th colspan="2" class="">{{ $total_quantity_purchase }}</th>

              
            </tr>

            <tr>
              <th colspan="5" class="text-center text-white bg-success">Ventes</th>

            </tr>

            @php
            $total_quantity_sold = 0;
        @endphp
      
            @if (count($solddetails) > 0)
         
        <tr>
         

          @foreach ($solddetails as $item)
          @php
          $total_quantity_sold += $item->quantity;
      @endphp
        
          <td>{{ $item->id }}</td>
          <td>{{ $item->client }}</td>
          <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y')  }}</td>
      
          <td>{{ $item->quantity }}</td>
          <td>{{ $item->price }}</td>
         
         
              
         
         
        </tr>
        @endforeach
         

            @endif
                
        
            <tr class=" text-white bg-success">
              <th colspan="3" class="text-center ">Total Quantité Vendus</th>
              <th colspan="2" class="">{{ $total_quantity_sold }}</th>

              
            </tr>

          
         
         
           
           
        
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