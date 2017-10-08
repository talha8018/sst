<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Product;

class StockController extends Controller
{
    public function show()
    {
    	$stock = Stock::where('status','1')->orderBy('quantity','asc')->get()->toArray();
        $products = Product::where('status','1')->get()->toArray();
    	return view('stock',compact('stock','products'));
    }

    public function insert()
    {
    	$input = request();
    	Stock::create([
            'pro_id' => $input['pro_id'],
            'quantity' => $input['quantity'],
            'unit_purchase_price' => $input['upp'],
    		'unit_sale_price' => $input['usp'],
    		'description' => $input['description'],
            'status'    => 1
    	]);

        if(Stock::where('pro_id',$input['pro_id'])->exists()===true)
        {
            Stock::where('pro_id',$input['pro_id'])->where('status','1')->update([
                'unit_sale_price'   => $input['usp']
            ]);
        }
    	return redirect('/stock')->with('message','Stock has been added.');
    }

    
    public function delete($id)
    {
        Stock::where('id',$id)->update([
            'status'    => 0
        ]);
        return redirect('/stock')->with('message-del','Stock has been deleted.');

    }

    public function update()
    {
        $input = request();

        Stock::where('id',$input['id'])->update([
            'quantity' => $input['qty']
        ]);
        echo '1';
    }

}
