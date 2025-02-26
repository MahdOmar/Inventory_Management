

@extends('layouts.layout')

@section('content')

<div class="row ">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Achats</h2>
    
</div>  








<div class="col-lg-12 col-md-12 col-sm-12  ">

  <form action="{{ route('purchases.store') }}" method="POST">
    @csrf
    <fieldset  class="form-group  p-3" style="border:2px solid #dee2e6 ">
      <legend class="w-auto px-2"><b>Informations Achat</b></legend>
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
            <input type="text" class="form-control d-none" name='purchase_id' id = "purchase_id"value=""  >
            <div class="form-group">
              <label for="">Fournisseur <span class="text-danger">*</span></label>                           

              <input type="text" class="form-control" name='Supplier' id="supplier" placeholder="Fournisseur" >
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
              <div class="form-group">
                  <label for="">Date <span class="text-danger">*</span></label>                           
  
                  <input type="date" class="form-control" name='Date' id="date" placeholder="date" >
              </div>
          </div>
          <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <label for="">Montant <span class="text-danger">*</span></label>                           
  
                <input type="number" class="form-control" name='Total' id='total' placeholder="Montant" >
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
              <th class="th-sm">Référence
              </th>

              <th class="th-sm">Fournisseur
              </th>

              
              <th class="th-sm">Date
              </th>
              <th class="th-sm">Montant
              </th>
              
        
              <th class="th-sm">Actions
              </th>
            </tr>
          </thead>
          <tbody>
          
            
              @foreach ($purchases as $purchase)
              <tr>
              <td>{{ $purchase->id }}</td>
              <td>{{ $purchase->Supplier }}</td>
              <td>{{ $purchase->Date }}</td>
              <td>{{number_format($purchase->Total , 2, '.', ' ') }}</td>
              <td><a  onclick="getDetail({{ $purchase->id }})" data-toggle='tooltip' role="button" title="edit" data-placement="bottom" class="float-left btn btn-sm btn-warning ml-2 "><i class="fa fa-edit " ></i></a>
                <a  href="{{ route('purchase.details',$purchase->id) }}" data-toggle='tooltip' role="button" title="info" data-placement="bottom" class="float-left btn btn-sm btn-primary ml-2 "><i class="fa fa-info"></i></a>
                <form class="float-left ml-2" action="{{ route('purchases.destroy',$purchase->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a data-toggle='tooltip' title="delete" data-id="{{ $purchase->id }}"  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>
  
                </form></td>
              </tr>
                  
              @endforeach
            
             
            
           
                  
            
              
             
           
                
         
           
           
        
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
        var path="{{ route('purchases.show',':id') }}".replace(':id',id);

        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                id:id
            },
            success:function(data){
               $('#purchase_id').val(data.purchase.id);
               $('#supplier').val(data.purchase.Supplier);
               $('#date').val(data.purchase.Date);
               $('#total').val(data.purchase.Total);
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