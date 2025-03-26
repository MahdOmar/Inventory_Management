

@extends('layouts.layout')

@section('content')

<div class="row ">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Dashboard</h2>
    
</div>  








<div class="col-lg-12 col-md-12 col-sm-12  ">



  <div class="row">

    <div class="col-md-4 col-xl-3">
      <div class="card bg-c-blue order-card ">
          <div class="card-block">
              <h6 class="m-b-20 text-white">Ventes</h6>
              
              <div class="d-flex justify-content-between ">
                <img src="{{ asset("images/income.png") }}" alt="" width="50" height="40">
              <h3 class="text-right text-white"><span></span>{{ number_format($sales->sum('total_amount') , 2, '.', ' ') }} DA</h3>
              </div>
  
           
  
              <p class="m-b-0 text-white"><span class="f-right"></span></p>
          </div>
      </div>
    </div>
  
    <div class="col-md-4 col-xl-3">
      <div class="card bg-c-green order-card">
          <div class="card-block">
              <h6 class="m-b-20 text-white">Achat</h6>
  
              <div class="d-flex justify-content-between">
                <img src="{{ asset("images/outcome.png") }}" alt="" width="50" height="40">
                <h3 class="text-right text-white"><span>{{ number_format($purchases->sum('Total') , 2, '.', ' ') }} DA</span></h3>
              </div>
             
              <p class="m-b-0 text-white"><span class="f-right"></span></p>
          </div>
      </div>
    </div>
  
    <div class="col-md-4 col-xl-3">
      <div class="card bg-c-yellow order-card">
          <div class="card-block">
              <h6 class="m-b-20 text-white">Profit</h6>
            
              <div class="d-flex justify-content-between">
                <img src="{{ asset("images/profit.png") }}" alt="" width="50" height="40">
                <h3 class="text-right text-white"><span>{{ number_format($profit , 2, '.', ' ') }} DA</span></h3>
              </div>
             
              <p class="m-b-0 text-white"><span class="f-right"></span></p>
          </div>
      </div>
    </div>
  
    <div class="col-md-4 col-xl-3">
      <div class="card bg-c-pink order-card">
          <div class="card-block">
              <h6 class="m-b-20 text-white">Créances</h6>
              
              <div class="d-flex justify-content-between">
                <img src="{{ asset("images/recevable.png") }}" alt="" width="50" height="40">
                <h3 class="text-right text-white"><span>{{ number_format($receivables->receivables , 2, '.', ' ') }} DA</span></h3>
              </div>
              <p class="m-b-0 text-white"><span class="f-right"></span></p>
          </div>
      </div>
    </div>
  
  </div>

  <div class="charts row">
    <div class="card p-4 chart col-md-6 col-lg-6">
      <h4>Ventes / Achats</h4>
      <canvas id=myChart></canvas>
    </div>

    <div class="topSales col-md-6 col-lg-6 ">

      <div class="card p-4">
         <div class="card-head">
          <h4 class="">Profit Par Produit</h4>

         </div>
     <div class="car-body">
      <table  class="table table-striped table-bquotedetailsed table-sm" cellspacing="0" width="100%">
       
        <thead class="bg-primary text-white">
          <tr>
         

        
            <th class="th-sm">Produit
            </th>

            <th class="th-sm">Quantity
            </th>


            <th class="th-sm">Montant
            </th>

            <th class="th-sm">Profit
            </th>

          
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $item)
          <tr>
          
            <td>{{ $item->designation }}</td>
            <td>{{ $item->total_quantity }}</td>
            <td>{{ number_format($item->total_amount, 2, '.', ' ') }}</td>
            <td> <span class="badge badge-success">{{ number_format($item->total_amount  - ($item->price_a * $item->total_quantity ) , 2, '.', ' ') }}</span></td>
           
          </tr>
              
          @endforeach
          

         
        </tbody>
      </table>
    </div>
    </div>

    </div>







  </div>

  <div class="card p-2">
    <form action="{{ route('dashboard.calculate') }}" method="GET">
      @csrf
      <fieldset  class="form-group  p-3" style="border:2px solid #dee2e6 ">
        <legend class="w-auto px-2"><b>Calculer Ventes-Achats-Profits</b></legend>
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
                <label for="">Selectionner <span class="text-danger">*</span></label>                           
  
                <select name="type" id="type" class="form-control show-tick">
                 
                  <option value="sale">Ventes</option>
                  <option value="purchase">Achats</option>
                  <option value="profit">Profits</option>
                
               
              </select>
                
              </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="form-group">
                    <label for="">Date début <span class="text-danger">*</span></label>                           
    
                    <input type="date" class="form-control" name='Date-s' id="date-s" >
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
              <div class="form-group">
                <label for="">Date fin<span class="text-danger">*</span></label>                           
    
                <input type="date" class="form-control" name='Date-e' id="date-e"  >
              </div>
          </div>
    
         
        <div class="col-lg-3 col-md-3 m-2 ">
          <button  id="btn-calculer" class="  btn btn-primary ">Calculer</button>
        
      </div>
    
    <h3 class="mt-2">Resultat: <span class="badge badge-success" id="result"></span> </h3>
    
    </fieldset>
    
    
    
    </form>
  </div>

  <div class="card p-2">
   
      <fieldset  class="form-group  p-3" style="border:2px solid #dee2e6 ">
        <legend class="w-auto px-2"><b>Calculer ZAKAT</b></legend>
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
            
              <div class="form-group">
                <label for="">النصاب <span class="text-danger">*</span></label>                           
  
                <input type="number" class="form-control" name='nisssab' id="nissab" placeholder="النصاب" required>
                
              </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="form-group">
                  <label for="">الرصيد النقدي <span class="text-danger">*</span></label>                           
  
                  <input type="number" class="form-control" name='montant' id="montant" placeholder="الرصيد النقدي" required>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
              <div class="form-group">
                <label for="">قيمة المخزون<span class="text-danger">*</span></label>                           
    
                <input type="number" class="form-control" name='stock' id="stock" placeholder="قيمة المخزون" disabled  value="{{  $stock->amount}}" required>
              </div>
          </div>

          <div class="col-lg-3 col-md-3">
            <div class="form-group">
              <label for="">الديون المرجوة<span class="text-danger">*</span></label>                           
  
              <input type="number" class="form-control" name='debt' id="debt" placeholder="الديون المرجوة"  value="{{  $receivables->receivables}}" required >
            </div>
        </div>
  
    
         
        <div class="col-lg-3 col-md-3 m-2 ">
          <button  id="btn-ZAKAT" class="  btn btn-success ">Calculer ZAKAT</button>
        
      </div>
    
    <h3 class="mt-2">Resultat: <span class="badge badge-success" id="result_zakat"></span> </h3>
    
    </fieldset>
    
    
    
  
  </div>
 
</div>
@endsection



<script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ asset("js/popper.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<script>

$(document).ready(function(){

  const startDateInput = document.getElementById('date-s');
    const endDateInput = document.getElementById('date-e');

    // Disable dates before start date in the end_date input
    startDateInput.addEventListener('change', () => {
        const startDate = startDateInput.value;
        if (startDate) {
            endDateInput.min = startDate; // Set the minimum selectable date for end_date
        }
    });








  const xValues = ["Janvier","Février",'Mars','Avril','Mai','Juin','Juillet','Aout','Septembre',"Octobre",'Novembre','Decembre'];
  const yValues = <?php echo json_encode($sales_datas)?>;
  const zValues = <?php echo json_encode($purchases_datas)?>

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      label:"Ventes",
      fill: false,
      backgroundColor:"blue",
      borderColor: "blue",
      data: yValues
    },
  {
    label:"Achats",
      fill: false,
      backgroundColor:"red",
      borderColor: "red",
      data: zValues

  }]
  },
  
});
 
  });

  

  




  
  $(document).on('click','#btn-calculer',function(e)
  {
    var token="{{ csrf_token() }}";
    var path="{{ route('dashboard.calculate') }}";
    var data = {
            'type':$('#id').val(),
            'Date-s': $('#date-s').val(),
            'Date-e': $('#date-e').val(),
            
           


          }
          e.preventDefault();
        $.ajax({
            url:path,
            type:"GET",
            dataType:'JSON',
            data:{
                _token:token,
                'type':$('#type').val(),
            'Date-s': $('#date-s').val(),
            'Date-e': $('#date-e').val(),
            },
            success:function(data){
             
              $('#result').html(data.results.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' DA');
          
        
            
            }
        })

  })

  $(document).on('click','#btn-ZAKAT',function(e)
  {
   
    var nissab = parseFloat($('#nissab').val());
    var montant = parseFloat($('#montant').val());
    var stock = parseFloat($('#stock').val());
    var debt = parseFloat($('#debt').val());
    var total = montant + stock + debt;

    console.log(total);
    
    

    if(nissab > total)
  {
    $('#result_zakat').html(total+' DA  لاتوجد عليك زكاة : المبلغ لم يبلغ النصاب ');
  }
  else{

    total = total / 40;
   
    $('#result_zakat').html(total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' DA');

  }








  })




    
 
</script>

