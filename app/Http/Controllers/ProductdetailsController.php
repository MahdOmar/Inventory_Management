<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchasedetails;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductdetailsController extends Controller
{
    public function index(String $id)
    {
        $product = Product::find($id);
        $purchasedetails = Purchasedetails::where('productId',$id)->get();

        $sales = Sale::all();
        $solddetails = DB::table('quotedetails')
        ->join('quotes', 'quotedetails.quoteId', '=', 'quotes.id')
        ->join('sales', 'sales.quoteId', '=', 'quotes.id')
        ->where('quotedetails.productId', $id)
        ->select(DB::raw('quotedetails.quantity,quotes.client,quotes.id,quotes.created_at,quotedetails.price'))
        ->get();

        error_log($solddetails);



        return view('Product.details',compact(['purchasedetails','product','solddetails']));
    }
}
