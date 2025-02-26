<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Quote;
use App\Models\Quotedetails;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sales = Sale::all();
        $purchases = Purchase::all();
        $quotes = Quote::all();
        $stock = Product:: select(DB::raw('sum(quantity * price_v ) as amount'))->first();

                         
        $receivables = DB::table('quotes')
        ->join('sales', 'quotes.id', '=', 'sales.quoteId')
        ->select(DB::raw('sum(quotes.total - sales.total_amount) as receivables '))
        ->first();




        $saled_quotes = Quote::where('status','invoice')->get();
        $sales_month = Sale::whereYear('created_at', date('Y'))

                              ->select(DB::raw('sum(total_amount ) as amount'))
                              ->groupBy(DB::raw("Month(created_at) "))
                              ->pluck('amount');

        $purchases_month = Purchase::whereYear('Date', date('Y'))

                              ->select(DB::raw('sum(Total) as amount'))
                              ->groupBy(DB::raw("Month(Date) "))
                              ->pluck('amount');                     

         
          $Months = Sale::select(DB::raw('Month(created_at)as month'))
                              ->whereYear('created_at', date('Y'))
                              ->groupBy(DB::raw("Month(created_at) "))
                              
                              ->pluck('month'); 

         $Months_p = Purchase::select(DB::raw('Month(Date) as month'))
                               ->whereYear('purchases.Date', date('Y'))
                              ->groupBy(DB::raw("Month(Date) "))
                              ->pluck('month');  
                              
              $products = DB::table('quotedetails')
                              ->join('quotes', 'quotedetails.quoteId', '=', 'quotes.id')
                              ->join('products', 'quotedetails.productId', '=', 'products.id')
                              ->select(
                                  'products.id', 
                                  'products.designation', 
                                  'products.price_a',
                                  DB::raw('SUM(quotedetails.quantity) as total_quantity'),
                                  DB::raw('SUM(quotedetails.price * quotedetails.quantity) as total_amount')
                              )
                              ->where('quotes.status', 'invoice') // Only include quotes with status = invoice
                              ->groupBy('products.id', 'products.designation') // Group by product ID and name
                              ->get(); 
                              
                              error_log($products);




                              
          $sales_datas = array(0,0,0,0,0,0,0,0,0,0,0,0);    
          $purchases_datas = array(0,0,0,0,0,0,0,0,0,0,0,0);  
          
          
          foreach($Months as $index => $month)
          {
           if(count($sales_month) > 0  )
           {

             $sales_datas[$month-1] = $sales_month[$index]  ;

           }
           else{
            $sales_datas[$month-1] = 0;
           }
        }
        
        foreach($Months_p as $index => $month)
        {
         if(count($purchases_month) > 0  )
         {

           $purchases_datas[$month-1] = $purchases_month[$index]  ;

         }
         else{
          $purchases_datas[$month-1] = 0;
         }
      }
      


        $profit = 0;

        foreach($saled_quotes as $item)
        {
            $quotedetails = Quotedetails::where('quoteId',$item->id)->get();
             foreach ($quotedetails as $qt) {
               
                $product = Product::find($qt->productId);
                $profit += ($qt->price * $qt->quantity) - ($product->price_a * $qt->quantity);
             }

        }

    
        return view('Dashboard.index',compact(['sales','purchases','quotes','profit','sales_datas','purchases_datas','products','stock','receivables']));
    }

    public function calculate()
    {
      if(request('type') == "sale")
      {

      
      $sales = Sale::whereBetween(DB::raw('DATE(created_at)'), [request('Date-s'), request('Date-e')])->sum('total_amount');

      return response()->json([
        "results" => $sales

                                   ]);

    }

    elseif(request('type') == "purchase")
    {
      $purchases = Purchase::whereBetween(DB::raw('DATE(created_at)'), [request('Date-s'), request('Date-e')])->sum('Total');

      return response()->json([
        "results" => $purchases

                                   ]);

    }

    else
    {
      $saled_quotes = DB::table('quotes') 
      ->join('sales', 'quotes.id', '=', 'sales.quoteId')
      ->whereBetween(DB::raw('DATE(sales.created_at)'), [request('Date-s'), request('Date-e')])
      ->select('quotes.*')
      ->get();

      $profit = 0;

      foreach($saled_quotes as $item)
      {
          $quotedetails = Quotedetails::where('quoteId',$item->id)->get();
           foreach ($quotedetails as $qt) {
             
              $product = Product::find($qt->productId);
              $profit += ($qt->price * $qt->quantity) - ($product->price_a * $qt->quantity);
           }

      }

      return response()->json([
        "results" => $profit

                                   ]);

    }



    }


    

}
