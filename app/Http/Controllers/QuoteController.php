<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quote;
use App\Models\Quotedetails;
use App\Models\Sale;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $quotes = Quote::orderBy('created_at','DESC')->get();
        return view(('Quote.index'),compact(['products','quotes']));
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
       
        if($request->quote_id != "")
        {
            $this->validate($request,[
                'client'=>'string|required',
                'phone'=>'string|required',
              
              
            ]);
    
            $data = $request->all();
            $order = Quote::find($request->quote_id);
            $status = $order->fill($data)->save();
            if($status)
            {
                return redirect()->route('quotes.index')->with('success','Devis a été mis à jour avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }


        }
        else
        {
            $this->validate($request,[
                'client'=>'string|required',
                'phone'=>'digits:10|required',
            
              
            ]);
    
            $data = $request->all();
            $data['total'] = 0;
            
    
            $status = Quote::create($data);
            $quote = Quote::latest()->first();

        
           
            if($status)
            {
                return redirect()->route('quotedetails.index',$quote->id)->with('success','Devis créer avec succès ');
    
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
        $quote = Quote::find($id);
        
        return response()->json([
            "quote" => $quote
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    public function view(String $id)
    {
        $quote = Quote::find($id);
        $quotedetails = Quotedetails::where('quoteId',$quote->id)->get();

        
       return view('Quote.view',compact(['quote','quotedetails']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    public function passingCustomer()
    {
        $quote = new Quote();
        $quote->client = 'Client de Passage';
        $quote->phone = '-';
        $quote->total = 0;
        $quote->status  = 'invoice';
        $quote->save();
        $sale =new Sale();
        $sale->quoteId = $quote->id;
        $sale->total_amount = $quote->total;
        $sale->status = 'paid';
        $sale->save();

        return redirect()->route('quotedetails.index',$quote->id);

    }






    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $quote = Quote::find($id);
        $status = $quote->delete();
           
        if($status){
            return redirect()->route('quotes.index')->with('success','Devis supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }
}
