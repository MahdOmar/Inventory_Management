<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Quotedetails;
use App\Models\Sale;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(String $id)
    {
        $payment = Payment::find($id);
        $sale = Sale::find($payment->saleId);
        
        return response()->json([
            "payment" => $payment,
            "sale" => $sale
        ]);
    }

    public function view(String $id)
    {
        $payment = Payment::find($id);
        $sale =Sale::find($payment->saleId);
        $quote = Quote::find($sale->quoteId);
        

        
       return view('Sales.receipt',compact(['quote','payment','sale']));
    }

    public function destroy(String $id)
    {
        $payment = Payment::find($id);

        
        $sale = Sale::find($payment->saleId);
        $quote = Quote::find($sale->quoteId);
        $sale->total_amount -= $payment->amount;
        if($sale->status == "paid")
        {
            $sale->status = "partial";
        }
        if($quote->status == "invoice")
        {
            $quote->status = "pending";
            $quote->save();
        }
        $sale->save();
        $status = $payment->delete();
        $payments = Payment::where('saleId',$sale->id)->get();
        if(count($payments) == 0)
        { 
            $quote = Quote::find($sale->quoteId);
            $quotedetails = Quotedetails::where('quoteId',$sale->quoteId)->get();

            foreach ($quotedetails as $item) {
               
                $product = Product::find($item->productId);
                $product->quantity += $item->quantity;
                $product->save();
            }

            $quote->status = "pending";
            $quote->save();


            $sale->delete();
        }
           
        if($status){
            return redirect()->route('sales.index')->with('success','Devis supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }
}
