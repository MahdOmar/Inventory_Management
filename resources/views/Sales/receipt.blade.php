<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
  <link rel="stylesheet" href="{{ asset("css/style.css") }}">

  <style>
            body{    margin-top:20px;
                     background-color:#eee;
                 }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0,0,0,.125);
            border-radius: 1rem;
        }
  </style>
  
</head>
<body>




<div class="container">
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title d-flex justify-content-between">
                      <div class="brand">
                        <div class="">
                           <h2 class="mb-1 text-muted">Bootdey.com</h2>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">3184 Spruce Drive Pittsburgh, PA 15201</p>
                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> xyz@987.com</p>
                            <p><i class="uil uil-phone me-1"></i> 012-345-6789</p>
                        </div>
                      </div>
                      <div class="col-sm-6 floath-right">
                        <div class="text-muted text-sm-end ml-4">
                            <div class="row">
                           
                            <div class="mt-4 col-lg-6 col-md-6 ">
                              <h5 class="font-size-15 mb-1"> Devis:</h5>
                              <p>#DV-00{{ $quote->id }}</p>
                          </div>
                          <div class="mt-4 col-md-6 col-lg-6">
                            <h5 class="font-size-15 mb-1"> Date:</h5>
                            <p>{{ now()->format('d-m-Y') }}</p>
                        </div>
                        </div>

                          <div class="text-muted mt-4">
                            <h5 class="font-size-16 mb-3">Doit:</h5>
                            <h5 class="font-size-15 mb-2">{{ ucfirst(trans($quote->client)) }}</h5>
                            
                            <p>{{ $quote->phone }}</p>
                        </div>
                            
                        </div>
                    </div>
                     
                    </div>

                    <hr class="my-4">

                    
                    <!-- end row -->
                    
                    <div class="py-2">
                        <h5 class="font-size-15 text-center mb-4">Reçu de Paiement</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.Devis</th>
                                        <th class="text-center">Montant Payé</th>
                                        <th class="text-center">Date</th>
                                       
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                  <tr>
                                    <td
                                    class="text-center">#DV-00{{ $quote->id }}</td>
                                    <td  class="text-center">{{ number_format($payment->amount, 2, '.', ' ')  }} DA</td>
                                    <td  class="text-center">{{ $payment->created_at->format('d-M-Y')}}</td>
                                  </tr>

                                  <tr>
                                    <th scope="row" colspan="2" class="border-0 text-right">Total Payé</th>
                                    <td  class="border-0 text-center">{{ number_format($sale->total_amount, 2, '.', ' ')  }} DA</td>
                                </tr>

                                <tr>
                                  <th scope="row" colspan="2" class="border-0 text-right">Reste</th>
                                  <td  class="border-0 text-center"> {{ number_format($quote->total - $sale->total_amount, 2, '.', ' ')  }} DA</td>
                              </tr>
                                  
                               
                                    <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                        <div class="d-print-none mt-4">
                            <div class="float-right">
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
</div>


<script src="{{ asset("js/jquery.min.js") }}"></script>
<script src="{{ asset("js/popper.js") }}"></script>
<script src="{{ asset("js/bootstrap.min.js") }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
</html>