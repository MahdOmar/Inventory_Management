

@extends('layouts.layout')

@section('content')

<div class="row ">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Ajouter Article</h2>
    
</div>  


<div class="col-lg-12 col-md-12 col-sm-12  ">



  <div class="card p-4">
     
      <div class="body">

          <form action="{{ route('products.store') }}" method="POST">
              @csrf
           
          <fieldset  class="form-group  p-3" style="border:2px solid #dee2e6 ">
            <legend class="w-auto px-2"> <b>Article</b> </legend>
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

                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                      <label for=""> Désignation <span class="text-danger">*</span></label>                           
  
                      <input type="text" class="form-control" name='designation' placeholder="Designation" >
                     </div>
                  </div>

                  <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label for=""> Catégorie <span class="text-danger">*</span></label>                           
  
                      <select name="category" id="orienter" class="form-control show-tick">
                        <option value="">-- Selectionner --</option>
                     
                        <option value="elec" {{old('category') == 'elec' ? 'selected' : ''}}>Eléctricité</option>
                        <option value="plafond" {{old('category') == 'plafond' ? 'selected' : ''}}>Faux Plafond</option>
                    </select>
                     </div>
                  </div>

                

                  <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label for=""> Prix_V <span class="text-danger">*</span></label>                           
  
                      <input type="number" step="0.01" class="form-control" name='price_v' placeholder="Prix Vendre" >
                     </div>
                  </div>
           

            </div>




          </fieldset>
         
          
           
              <div class="col-sm-12">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="submit" class="btn btn-outline-secondary">Cancel</button>
              </div>

          </form> 

          </div>
          
      </div>
  </div>
</div>

@endsection


