<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Stock;
use App\Product;
use Carbon\Carbon;

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
        $sale = Sale::whereDate('created_at','>=',Carbon::now()->startOfMonth())->whereDate('created_at','<=',date('Y-m-d'))->orderBy('created_at','desc')->simplePaginate($this -> per_page);
        
        $total = Sale::whereDate('created_at','>=',Carbon::now()->startOfMonth())->whereDate('created_at','<=',date('Y-m-d'))->sum('total_profit');
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
        
        $sale = Sale::whereDate('created_at','>=',$input['from'])->whereDate('created_at','<=',$input['to']);
        $total = Sale::whereDate('created_at','>=',$input['from'])->whereDate('created_at','<=',$input['to']);
        if(!empty($input['pro_id']))
        {
        	$sale = $sale->where('pro_id',$input['pro_id']);
        	$total = $total->where('pro_id',$input['pro_id']);
        }

        $sale = $sale->orderBy('created_at','desc')->simplePaginate($this -> per_page);
        $total = $total->sum('total_profit');

        $products = Product::where('status','1')->get()->toArray();
        $data = ['pro_id'=>$input['pro_id'],'from'=>$input['from'],'to'=>$input['to']];
    	return view('sale',compact('sale','stock','total','products','data'));
        
    }


}
