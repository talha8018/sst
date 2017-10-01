<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class StockController extends Controller
{
    public function show()
    {
    	$products = Stock::where('status','1')->get()->toArray();
    	return view('products',compact('products'));
    }

    public function insert()
    {
    	$input = request();
    	Stock::create([
    		'name' => $input['product'],
    		'status' => 1
    	]);
    	return redirect('/products')->with('message','Product has been added.');
    }
}
