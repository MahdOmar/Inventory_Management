<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Quotedetails;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::where('status','pending')->where('total','>',0)->get();
        $payments = Payment::orderBy('created_at','DESC')->get();
        $sales = Sale::all();
        
        return view('Sales.index',compact(['quotes','payments','sales']));
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
       
      
            $this->validate($request,[
                'quoteId'=>'required |exists:quotes,id',
                'status'=>'nullable|in:unpaid,partial,paid',
                'amount'=>'numeric|required|min:0',
              
              
            ]);
    
            
            $sale = Sale::where('quoteId',$request->quoteId)->first();

            if($sale) 
            {
                $quote = Quote::find($sale->quoteId);
                if($sale->total_amount + $request->amount > $quote->total )
                {
                    return back()->with('error','Montant total est supérieur au Montant du devis, il reste '.number_format($quote->total - $sale->total_amount, 2, '.', ' ').' DA');
                }
                
                $payment = new Payment();
                $payment->saleId = $sale->id;
                $payment->amount = $request->amount;
                $payment->save();
                $sale->total_amount += $request->amount;
                if($sale->total_amount == $quote->total)
                {
                    $sale->status = "paid";
                    $quote->status = "invoice";
                    
                }
                $sale->save();
                $quote->save();

                return redirect()->route('sales.index',$quote->id)->with('success','Vente Ajouté avec succès ');




            }

            else{

                $sale = new Sale();
                $quote = Quote::find($request->quoteId);
                $sale->quoteId = $request->quoteId;
                $sale->total_amount = $request->amount;
                if($request->amount == $quote->total)
                {
                    $sale->status = 'paid';
                    $quote->status ="invoice";
                    $quote->save();

                }
                else if($request->amount == 0)
                {
                   
                    $sale->status = 'unpaid';
                }
                else
                {
                    $sale->status = 'partial';
                }
               

                

                
                $quotedetails = Quotedetails::where('quoteId',$sale->quoteId)->get();

                foreach ($quotedetails as $item) {
                   
                    $product = Product::find($item->productId);
                   if($product->quantity < $item->quantity)
                   {
                    return back()->with('error',$product->designation.' Quantité non disponible');
                   }
                }

                foreach ($quotedetails as $item) {
                   
                    $product = Product::find($item->productId);
                    $product->quantity -= $item->quantity;
                    $product->save();
                }
                $sale->save();
                $payment = new Payment();
                $payment->saleId = $sale->id;
                $payment->amount = $request->amount;
                $payment->save();
               

               
                if($payment)
                {
                    return redirect()->route('sales.index',$quote->id)->with('success','Vente Ajouté avec succès ');
        
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
        $sale = Sale::find($id);
        $quote = Quote::find($sale->quoteId);
        $quotedetails = Quotedetails::where('quoteId',$quote->id)->get();

        
       return view('Sales.invoice',compact(['quote','sale','quotedetails']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }


    public function getTotal(String $id)
    { 
       
        $quote = Quote::find($id);
        $sale = Sale::where('quoteId',$quote->id)->first();

        if($sale)
        {
            $payments = Payment::where('saleId',$sale->id)->get();
        if(count($payments) > 0){
          
            $total = $quote->total - $payments->sum('amount');
        }
        else{
            $total = $quote->total;
        }

        }

        else{
            $total = $quote->total;
        }
       
        
       
      
        

        return response()->json([
            "total" => $total
            
        ]);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $sale = Sale::find($id);
        $quote = Quote::find($sale->quoteId);


        $quotedetails = Quotedetails::where('quoteId',$sale->quoteId)->get();

        foreach ($quotedetails as $item) {
           
            $product = Product::find($item->productId);
            $product->quantity += $item->quantity;
            $product->save();
        }

        $quote->status = "pending";
        $quote->save();
        $status = $sale->delete();

           
        if($status){
            return redirect()->route('sales.index')->with('success','Vente supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }
}
