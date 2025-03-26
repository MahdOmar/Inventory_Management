<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('Product.index',compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Product.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'designation'=>'string|required',
            'category'=>'in:elec,plafond|required',
            'price_v'=>'numeric|required',
          
        ]);

        $data = $request->all();
        $product = Product::where('designation',$request->designation)->exists();
        if($product){
            return back()->with('error','Article existe déja !!');
            
        }
        
       $data['quantity'] = 0;
       $data['price_a'] = 0;

        $status = Product::create($data);
        if($status)
        {
            return redirect()->route('products.create')->with('success','Achat créer avec succès ');

        }
        else
        {
            return back()->with('error','Something went wrong');

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('Product.edit',compact(['product']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $this->validate($request,[
            'designation'=>'string|required',
            'category'=>'in:elec,plafond|required',
            'price_v'=>'numeric|required',
          
        ]);
            $data = $request->all();
            $product = Product::find($id);
            $status = $product->fill($data)->save();
            if($status)
            {
                return redirect()->route('products.index', $request->projet_id)->with('success','Article a été mis à jour avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $status = $product->delete();
           
        if($status){
            return redirect()->route('products.index')->with('success','Article supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }
}
