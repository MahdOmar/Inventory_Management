<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchasedetails;
use Illuminate\Http\Request;

class PurchasedetailsController extends Controller
{
    public function index(string $id)
    {  
        

        $products = Product::all();
        $purchase = Purchase::find($id);
    
  
        $purchasedetails = Purchasedetails::where('purchaseId',$id)->get();

        error_log(count($purchasedetails));
        
        return view('Purchases.details',compact(['products','purchase','purchasedetails']));
    }

    public function store(Request $request)
    {

        if($request->purchasedetails_id != "")
        {
            $this->validate($request,[
                'productId'=>'required|exists:products,id',
                'purchaseId'=>'required|exists:purchases,id',
                'quantity'=>'numeric|required|min:1',
                'price_a'=>'numeric|required|min:0',
               
              
            ]);
    
            $data = $request->all();
            $purchasedetails = Purchasedetails::find($request->purchasedetails_id);
            $status = $purchasedetails->fill($data)->save();
            if($status)
            {
                return redirect()->route('purchase.details', $request->purchaseId)->with('success','Article a été mis à jour avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }


        }
        else
        {
            $this->validate($request,[
               'productId'=>'required|exists:products,id',
                'purchaseId'=>'required|exists:purchases,id',
                'quantity'=>'numeric|required|min:1',
                'price_a'=>'numeric|required|min:0',
              
            ]);
    
            $data = $request->all();
            
            $product = Product::find($request->productId);
             $purchase = Purchase::find($request->purchaseId);
             $purchase->Total += $request->price_a * $request->quantity;
             $purchase->save();
            $product->quantity += $request->quantity;

            $price = $request->price_a * $request->quantity;
            $quantity = $request->quantity;

            $purchases = Purchasedetails::where('productId',$request->productId)->get();

            foreach ($purchases as $purchase) {
               if($purchase->productId == $product->id)
               {
                $quantity += $purchase->quantity;
                $price += $purchase->quantity * $purchase->price_a;

               }
            }

            $product->price_a = ceil($price / $quantity)  ;


            $product->save();
    
            $status = Purchasedetails::create($data);
            if($status)
            {
                return redirect()->route('purchase.details',$request->purchaseId)->with('success','Article ajouté avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }

        }
       
       

    }

    public function show(String $id)
    {
    
        $purchasedetails = Purchasedetails::find($id);

      
        

        return response()->json([
            "purchasedetails" => $purchasedetails
            
        ]);
    }


    public function destroy(string $id)
    {
        $purchasedtails = Purchasedetails::find($id);
        $purchase = Purchase::find($purchasedtails->purchaseId);
        $product = Product::find($purchasedtails->productId);
        $status = $purchasedtails->delete();

           
        if($status){

         
            $price = 0 ;
            $quantity = 0; 

            $purchases = Purchasedetails::where('productId',$product->id)->get();

            if(count($purchases) > 0) 
            {
                foreach ($purchases as $purchase) {
                    if($purchase->productId == $product->id)
                    {
                     $quantity += $purchase->quantity;
                     $price += $purchase->quantity * $purchase->price_a;
     
                    }
                 }
     
                 $product->price_a = ceil($price / $quantity)  ;
                 $product->quantity = $quantity;
     
                
            }
            else
            {
                $product->price_a = 0;
                $product->quantity = 0;

            }

          

            $product->save();

            
            return redirect()->route('purchase.details',$purchase->id)->with('success','Article supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }

}
