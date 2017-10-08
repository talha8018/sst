<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Stock;
use App\Product;

class SaleController extends Controller
{
	
	public function __construct()
	{
		$this -> per_page = 50;
	}

	public function show()
    {
        $stock = Stock::where('stocks.status','1')
        				->join('products','products.id','=','stocks.pro_id')
        				->orderBy('name','asc')
        				->get(['stocks.*','products.name'])->toArray();
        $sale = Sale::orderBy('created_at','desc')->simplePaginate($this -> per_page);
        $total = Sale::sum('total_profit');
        $products = Product::where('status','1')->get()->toArray();
        $data = [];
    	return view('sale',compact('sale','stock','total','products','data'));
    }

    public function insert()
    {
    	$input = request();
    	$stock_id = $input['stock_id'];
    	$qty = $input['quantity'];


    	$stock = Stock::where("id",$stock_id)->where("status","1")->first();
        $update_qty = $stock['quantity'] - $qty;

        if(Stock::where("id",$stock_id)->update(['quantity'=>$update_qty]))
    	{
    		$unit_profit = $stock['unit_sale_price'] - $stock['unit_purchase_price'];
    		$total = $qty * $unit_profit;
    		Sale::create([
    			'pro_id' => $stock['pro_id'],
    			'stock_id'	=> $stock_id,
    			'quantity' => $qty,
    			'unit_purchase_price' => $stock['unit_purchase_price'],
    			'unit_sale_price'	=> $stock['unit_sale_price'],
    			'unit_profit'	=>	$unit_profit,
    			'total_profit'	=> $total,
    			'status'	=>1,
    		]);
    	}
    	return redirect('/sale')->with('message','Sale has been added.');
    }

    public function search()
    {
        $input = request();
        $stock = Stock::where('stocks.status','1')
        				->join('products','products.id','=','stocks.pro_id')
        				->orderBy('name','asc')
        				->get(['stocks.*','products.name'])->toArray();
        $sale = Sale::where('pro_id',$input['pro_id'])->orderBy('created_at','desc')->simplePaginate($this -> per_page);
        $total = Sale::where('pro_id',$input['pro_id'])->sum('total_profit');
        $products = Product::where('status','1')->get()->toArray();
        $data = ['pro_id'=>$input['pro_id']];
    	return view('sale',compact('sale','stock','total','products','data'));
        
    }


}
