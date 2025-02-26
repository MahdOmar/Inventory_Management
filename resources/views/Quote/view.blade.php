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
                    <div class="invoice-title">
                        <h4 class="float-right font-size-15">Devis #{{ $quote->id }} 
                          @if ($quote->status == "pending")
                          <span class="badge bg-warning font-size-12 ms-2 text-white">En instance</span>
                          @else
                          <span class="badge bg-success font-size-12 ms-2">Facture</span>

                          @endif
                        </h4>
                        <div class="mb-4">
                           <h2 class="mb-1 text-muted">Bootdey.com</h2>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">3184 Spruce Drive Pittsburgh, PA 15201</p>
                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> xyz@987.com</p>
                            <p><i class="uil uil-phone me-1"></i> 012-345-6789</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Doit:</h5>
                                <h5 class="font-size-15 mb-2">{{ ucfirst(trans($quote->client)) }}</h5>
                                
                                <p>{{ $quote->phone }}</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Devis No:</h5>
                                    <p>#{{ $quote->id }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1"> Date:</h5>
                                    <p>{{ $quote->created_at->format('d-m-Y') }}</p>
                                </div>
                                
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    
                    <div class="py-2">
                        <h5 class="font-size-15">Résumé de la commande</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th class="text-end" style="width: 120px;">Total</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                  
                                  @foreach ($quotedetails as $item)

                                  @php
                                      $product = \App\Models\Product::where('id',$item->productId)->first();
                                  @endphp
                                      
                                 
                                   
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14 mb-1">{{ $product->designation }}</h5>
                                                
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->price, 2, '.', ' ') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->quantity * $item->price  , 2, '.', ' ') }}</td>
                                    </tr>

                                    @endforeach
                                   
                                    <tr>
                                        <th scope="row" colspan="3" class="border-0 text-right">Total</th>
                                        <td colspan="2" class="border-0 text-right"><h4 class="m-0 fw-semibold">{{ number_format($quote->total, 2, '.', ' ')  }} DA</h4></td>
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