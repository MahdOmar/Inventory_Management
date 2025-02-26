<!doctype html>
<html lang="en">
  <head>
  	<title>Gestion Stock</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" class="rel">
		<link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">

  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="">
				<h1><a href="" class="logo">Gestion Stock</a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="{{ route('dashboard.index') }}" class="{{ (request()->segment(2) == 'stats') ? 'active' : '' }}"><span class="fa fa-home"></span> Dashboard</a>

           

          </li>
         <li>
            <a href="{{ route('products.create') }}"><span class="fa fa-user"></span> Articles</a>
        </li> 
          <li>

            <li><a href="{{ route('products.store') }}" class="has-arrow"><span class="fa fa-sticky-note"></span>Gestion Stock </a>

              <ul>
                <li><a href="{{ route('purchases.index') }}">Achat</a></li>
                <li><a href="{{ route('products.store') }}">Stock</a></li>
            </ul>
           
          </li>

          <li><a href="{{ route('order.index') }}" class="has-arrow"><span class="fa fa-sticky-note"></span>Gestion Commandes </a>
            
        </li>


        <li>
          <a href="{{ route('quotes.index') }}" ><span class="fa fa-user"></span> Gestion Devis</a>
      </li>


          <li><a href="{{ route('sales.index') }}" class="has-arrow"><span class="fa fa-sticky-note"></span>Gestion Ventes </a>
        
        </li>

        

          </li>
       
         
        </ul>

      
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid ">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
          

           

            <div class="collapse navbar-collapse row " id="navbarSupportedContent">
             
                <ul  class="navbar-nav me-auto col-lg-10">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto col-lg-2 ">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle"   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <a href="{{ route('structure.changelayout') }}" class="dropdown-item"  >
                                 Changer Mot de Pass
                             </a>
                            </div>
                        </li>
                    @endguest
                </ul>

                
          
            </div>
          </div>
        </nav>

        <div class="main ">
          <div class="col-lg-12">
             @include('layouts.notification') 
        </div>
          
       @yield('content')

      
      </div>


   
  


		</div>
    <script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ asset("js/popper.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   

   
    <script src="{{ asset("js/main.js") }}"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script src="{{ asset("js/jquery.dataTables.min.js") }}"> </script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>

    <script>
    
    $(document).ready(function () {
      $('#selectedColumn').DataTable({
        "aaSorting": [],
        columnDefs: [{
        orderable: false,
        targets: 3
        }]
      });
        $('.dataTables_length').addClass('bs-select');
    });
   
    </script>
   
  </body>
</html>