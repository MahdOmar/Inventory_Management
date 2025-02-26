<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quote;
use App\Models\Quotedetails;
use App\Models\Sale;
use Illuminate\Http\Request;

class QuotedetailsController extends Controller
{
    public function index(String $id)
    {
        $products = Product::all();
        $quote = Quote::find($id);
        $quoteId = $quote->id;


     

     

        $quotedetails = Quotedetails::where('quoteId',$id)->get();

      

        return view(('Quote.details'),compact(['quote','products','quotedetails']));
    }

    public function store(Request $request)
    {
       
        if($request->quotedetailsId != "")
        {
            $this->validate($request,[
                'productId'=>'required|exists:products,id',
                'quoteId'=>'required|exists:quotes,id',
                'quantity'=>'numeric|required|min:1',
                'price'=>'numeric|required|min:0', 
              
              
            ]);
    
            $data = $request->all();
            $quotedetails = Quotedetails::find($request->quotedetailsId);
            $quote = Quote::find($request->quoteId);
            $sale = Sale::where('quoteId',$quote->id)->first();
            $quote->total -= $quotedetails->price * $quotedetails->quantity;
            $quote->total += $request->price * $request->quantity;
           
            if($sale != null)
            {
                $product = Product::find($quotedetails->productId);
                $product->quantity += $quotedetails->quantity;
                $product->save();
                $product_new = Product::find($request->productId);
                $product_new ->quantity -= $request->quantity;
                $product_new->save();
                if($sale->status == "paid" && ($sale->total_amount <  $quote->total))
                {
                    $sale->status ="unpaid";
                    $quote->status = "pending";
                    $sale->save();

                }
                elseif($sale->status == "unpaid" && ($sale->total_amount >=  $quote->total))
                {
                    $sale->status ="paid";
                    $quote->status = "invoice";
                    $sale->save();
                }
            }
            $quote->save();

            $status = $quotedetails->fill($data)->save();
           

            if($status)
            {
                return redirect()->route('quotedetails.index',$quote->id)->with('success','Article a été mis à jour avec succès ');
    
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
                'quoteId'=>'required|exists:quotes,id',
                'quantity'=>'numeric|required|min:1',
                'price'=>'numeric|required|min:0', 
            
              
            ]);

            $product = Product::find($request->productId);

            if( $product->quantity < $request->quantity)
            {
                return back()->with('error','Quantité demandé non disponible');
            }

    
            $data = $request->all();
            $quote = Quote::find($request->quoteId);
            $quote->total += $request->quantity * $request->price;
            $quote->save(); 
            
    
            $status = Quotedetails::create($data);

        
           
            if($status)
            {
                return redirect()->route('quotedetails.index',$quote->id)->with('success','Article Ajouté avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }

        }
       
       
    }

    public function show(String $id)
    {
        $quotedetails = Quotedetails::find($id);

      
        

        return response()->json([
            "quotedetails" => $quotedetails
            
        ]);
       
    }


    public function getPrice(String $id)
    {
        $product = Product::find($id);

        

        return response()->json([
            "product" => $product
            
        ]);
       
    }

    public function destroy(String $id)
    {
        $quotedetails = Quotedetails::find($id);
        $quote = Quote::find($quotedetails->quoteId);
        $quote->total -= $quotedetails->price * $quotedetails->quantity;
        $quote->save();
        $status = $quotedetails->delete();
           
        if($status){
            return redirect()->route('quotedetails.index',$quote->id)->with('success','Article supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }


}
