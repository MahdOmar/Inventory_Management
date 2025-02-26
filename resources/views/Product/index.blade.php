

@extends('layouts.layout')

@section('content')

<div class="row ">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Stock</h2>
    
</div>  








<div class="col-lg-12 col-md-12 col-sm-12  ">



  <div class="card p-4">
   
     
      <div class="body">
        <table id="selectedColumn" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="th-sm">Référence
              </th>
              
              <th class="th-sm">Désignation
              </th>
              <th class="th-sm">Catégorie
              </th>
              
              <th class="th-sm">Quantité
              </th>
              <th class="th-sm">Prix_A
              </th>
              <th class="th-sm">Prix_V
              </th>
           
              <th class="th-sm">Actions
              </th>
            </tr>
          </thead>
          <tbody>
            @if (count($products) > 0)
            <tr>
              @foreach ($products as $product)
              <td>{{ $product->id }}</td>
              <td>{{ $product->designation }}</td>
              <td>{{ $product->category }}</td>
              <td>{{ $product->quantity }}</td>
              <td>{{ $product->price_a }}</td>
              <td>{{ $product->price_v }}</td>
             
              <td>
                <a  href="{{ route('products.edit', $product->id ) }}" data-toggle='tooltip' role="button" title="edit" data-placement="bottom" class="float-left btn btn-sm btn-warning ml-2 "><i class="fa fa-edit " ></i></a>
                <a  href="{{ route('product.historique',$product->id) }}" data-toggle='tooltip' role="button" title="info" data-placement="bottom" class="float-left btn btn-sm btn-primary ml-2 "><i class="fa fa-info"></i></a>
                <form class="float-left ml-2" action="{{ route('products.destroy',$product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a data-toggle='tooltip' title="delete" data-id="{{ $product->id }}"  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>
  
                </form>


              </td>
                  
             
             
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
        swal("Your Article is safe!",{
          icon:"success",
        });
        }
        });
        

        

  })



    
 
</script>