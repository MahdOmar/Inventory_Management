<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::orderByDesc("created_at")->get();

     
        return view('Orders.index',compact(['orders']));
    }

    public function store(Request $request)
    {

        if($request->order_id != "")
        {
            $this->validate($request,[
                'client'=>'string|required',
                'phone'=>'string|required',
                'designation'=>'string|required',
                'quantity'=>'numeric|required',
                'status'=>'nullable|in:completed,not_completd'
              
            ]);
    
            $data = $request->all();
            $order = Order::find($request->order_id);
            $status = $order->fill($data)->save();
            if($status)
            {
                return redirect()->route('order.index')->with('success','Commande a été mis à jour avec succès ');
    
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
                'designation'=>'string|required',
                'quantity'=>'numeric|required',
                'status'=>'nullable|in:completed,not_completd'
              
            ]);
    
            $data = $request->all();
            
    
            $status = order::create($data);
            if($status)
            {
                return redirect()->route('order.index')->with('success','Commande créer avec succès ');
    
            }
            else
            {
                return back()->with('error','Something went wrong');
    
            }

        }
       
       

    }


    public function show(String $id)
    {
        error_log("/////////////////////***********************");
    
        $order = Order::find($id);
        error_log($order);
        return response()->json([
            "order" => $order
        ]);
    }

    public function destroy(string $id)
    {
        $order = Order::find($id);
        $status = $order->delete();
           
        if($status){
            return redirect()->route('order.index')->with('success','Commande supprimé avec Succès');
        }
        else{
            return back()->with('error','Something went wrong');
        }
    }






}
