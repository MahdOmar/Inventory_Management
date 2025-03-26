<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchasedetails;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       $purchases = Purchase::orderBy('created_at','DESC')->get();


        return view('Purchases.index',compact(['purchases']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if($request->purchase_id != "")
        {
            $this->validate($request,[
                'Supplier'=>'string|required',
                'Date'=>'date|required',
                'Total'=>'numeric|required',
              
            ]);
    
            $data = $request->all();
            $purchase = Purchase::find($request->purchase_id);
            $status = $purchase->fill($data)->save();
            if($status)
            {
                return redirect()->route('purchases.index', $request->purchase_id)->with('success','Achat a été mis à jour avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }


        }
        else
        {
            $this->validate($request,[
                'Supplier'=>'string|required',
                'Date'=>'date|required',
                'Total'=>'numeric|required',
              
            ]);
    
            $data = $request->all();
            
            error_log(print_r($data));
    
            $status = Purchase::create($data);
            if($status)
            {
                return redirect()->route('purchases.index')->with('success','Achat créer avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }

        }
       
       

    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
    
        $purchase = Purchase::find($id);
        
        return response()->json([
            "purchase" => $purchase
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {

      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $purchase = Purchase::find($id);
       

        $status = $purchase->delete();
           
        if($status){

            $products = Product::all();
            
            

            
        {
            
            foreach ($products as $product) {

                $quantity = 0 ;
                $price = 0 ;

                $purchasedetails = Purchasedetails::where('productId',$product->id)->get();
                if(count($purchasedetails) > 0)
                {
                    foreach ($purchasedetails as $purchase) {
                      
                        
                         $quantity += $purchase->quantity;
                         $price += $purchase->quantity * $purchase->price_a;
         
                       
                     }

                     $product->price_a = ceil($price / $quantity)  ;
                     $product->quantity = $quantity;

                }
              

                $product->save();


                
             }
 
            
 
            
        }





            return redirect()->route('purchases.index')->with('success','Achat supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }
}
