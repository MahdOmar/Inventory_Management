

@extends('layouts.layout')

@section('content')


  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Devis</h2>
    
  </div>  


  <form action="{{ route('quotes.store') }}" method="POST">
    @csrf
    <fieldset  class="form-group  p-3" style="border:2px solid #dee2e6 ">
      <legend class="w-auto px-2"><b>Informations Devis</b></legend>
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
            <input type="text" class="form-control d-none" name='quote_id' id = "quote_id"value=""  >
            <div class="form-group">
              <label for="">Client <span class="text-danger">*</span></label>                           

              <input type="text" class="form-control" name='client' id="client" placeholder="Client" >
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
              <div class="form-group">
                  <label for="">Téléphone <span class="text-danger">*</span></label>                           
  
                  <input type="phone" class="form-control" name='phone' id="phone" placeholder="Téléphone" >
              </div>
          </div>
        
  
       
      <div class="col-lg-3 col-md-3 m-2 mt-4 ">
        <button type="submit" id="btn" class="  btn btn-primary mt-2  ">Ajouter</button>
      
    </div>

    <div class="col-lg-3 col-md-3 m-2 mt-4 ">
      <a href="{{ route('quote.customer') }}" id="btn" class=" btn btn-success mt-2  "> Client de Passage</a>
    
  </div>
  
  
  
  </fieldset>
  
  
  
  </form>

  <div class=" flex-grow-1 card p-4 ml-2">
   
     
    <div class="body">
      <table id="selectedColumn" class="table table-striped table-bquoteed table-sm" cellspacing="0" width="100%">
        <thead>
          <tr>
         

           
            <th class="th-sm">Référence
            </th>

            <th class="th-sm">Client
            </th>

            <th class="th-sm">Téléphone
            </th>

            

            
            <th class="th-sm">Total
            </th>

            <th class="th-sm">Status
            </th>

            <th class="th-sm">Date
            </th>

           
           
            <th class="th-sm">Actions
            </th>
          </tr>
        </thead>
        <tbody>

          @if (count($quotes) > 0)
          @foreach ($quotes as $quote)

          <tr>
            <td>{{ $quote->id }}</td>
            <td>{{ $quote->client }}</td>
            <td>{{ $quote->phone }}</td>
            <td>{{ number_format($quote->total, 2, '.', ' ')  }}</td>
            @if ($quote->status == "pending")
            <td class="text-danger" style="font-size: 20px"> <i class="fa fa-spinner  m-1"></i></i><b>En instance</b></td>
              
            @else
            <td class="text-success" style="font-size: 20px"> <i class="fa fa-check-square  m-1 " > </i><b>Vendu</b></td>
            @endif
            <td>{{ $quote->created_at->format('d-m-Y')  }}</td>
            <td><a  onclick="getDetail({{ $quote->id }})" data-toggle='tooltip' role="button" title="edit" data-placement="bottom" class="float-left btn btn-sm btn-warning ml-2 "><i class="fa fa-edit " ></i></a>
              <a  href="{{ route("quotedetails.index",$quote->id) }}" data-toggle='tooltip' role="button" title="info" data-placement="bottom" class="float-left btn btn-sm btn-primary ml-2 "><i class="fa fa-info"></i></a>
              <a  href="{{ route("quote.print",$quote->id) }}" data-toggle='tooltip' role="button" title="info" data-placement="bottom" class="float-left btn btn-sm btn-success ml-2 "><i class="fa fa-print"></i></a>
              <form class="float-left ml-2" action="{{ route('quotes.destroy',$quote->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                
                  <a data-toggle='tooltip' title="delete" data-id="{{ $quote->id }}"  data-placement="bottom" class="dltBtn btn btn-sm btn-danger text-white"><i class="fa fa-trash " ></i></a>

              </form></td>
            </tr>
              
          @endforeach
              
          @else
              
          @endif

         
        </tbody>
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
        var path="{{ route('quotes.show',':id') }}".replace(':id',id);
       
        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                id:id
            },
            success:function(data){
               $('#quote_id').val(data.quote.id);
               $('#client').val(data.quote.client);
               $('#phone').val(data.quote.phone);
               

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