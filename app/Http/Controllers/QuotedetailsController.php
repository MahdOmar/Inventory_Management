<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Quotedetails;
use App\Models\Sale;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

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
                /* Return quantity back to stock */
                
                $product = Product::find($quotedetails->productId);
                $product->quantity += $quotedetails->quantity;
                $product->save();

                /* End Return quantity back to stock */

                $product_new = Product::find($request->productId);

                /* Check if quantity Exists */
                if($request->quantity > $product->quantity)
                {
                    return back()->with('error','Quantité demandé non disponible');
                }
                /* End Check if quantity Exists */

                $product_new ->quantity -= $request->quantity;
                $product_new->save();

                /**  Check for sale status and update according to the situation */
                if($sale->status == "paid" && ($sale->total_amount <  $quote->total))
                {
                    $sale->status ="unpaid";
                    $quote->status = "pending";
                    $sale->save();
                    $quote->save();

                }
                elseif($sale->status == "unpaid" && ($sale->total_amount >=  $quote->total))
                {
                    $sale->status ="paid";
                    $quote->status = "invoice";
                    $sale->save();
                    $quote->save();

                }
                /**  End Check for sale status and update according to the situation */

                /**********  Passing Customer  ************/
                if($quote->client == 'Client de Passage')
                {
                    $payment = Payment::where('saleId',$sale->id)->first();
                    $payment->amount -= $quotedetails->price * $quotedetails->quantity;
                    $payment->amount += $request->price * $request->quantity;
                    $payment->save();
                    
                }

                /* End Passing Customer */
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
            if($quote->client =='Client de Passage'){
                $sale = Sale::where('quoteId',$quote->id)->first();
                $sale->total_amount = $quote->total;
                $sale->save();
                $payment = Payment::where('saleId',$sale->id)->first();
                if($payment)
                {
                    $payment->amount += $request->quantity * $request->price;
                }
                else{
                    $payment = new Payment();
                    $payment->saleId = $sale->id;
                    $payment->amount = $request->quantity * $request->price;

                }
           
                $payment->save();
            }

            $sale = Sale::where('quoteId',$quote->id)->first();
            if($sale)
            {
                $product->quantity -= $request->quantity;
                $product->save();

                if($sale->status == "paid" && ($sale->total_amount <  $quote->total))
                {
                    $sale->status ="unpaid";
                    $quote->status = "pending";
                    $sale->save();
                    $quote->save();

                }
                elseif($sale->status == "unpaid" && ($sale->total_amount >=  $quote->total))
                {
                    $sale->status ="paid";
                    $quote->status = "invoice";
                    $sale->save();
                    $quote->save();
                }


            }
            
    
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
        $sale =Sale::where('quoteId',$quote->id)->first();
        if($quote->client == "Client de Passage")
        {
            $sale->total_amount = $quote->total;
            $payment = Payment::where('saleId',$sale->id)->first();
            $payment->amount = $quote->total;
            $sale->save();
            $payment->save();
        }
        // Return quantity back to stock 
        if($sale)
        {
            $product = Product::find($quotedetails->productId);
            $product->quantity += $quotedetails->quantity;
            $product->save();

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
      


        $status = $quotedetails->delete();
       
           
        if($status){
            return redirect()->route('quotedetails.index',$quote->id)->with('success','Article supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }


}
