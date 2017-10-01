<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function show()
    {
    	$products = Product::where('status','1')->get()->toArray();
    	return view('products',compact('products'));
    }

    public function insert()
    {
    	$input = request();
    	Product::create([
    		'name' => $input['product'],
    		'status' => 1
    	]);
    	return redirect('/products')->with('message','Product has been added.');
    }

    public function update()
    {
    	$input = request();

    	Product::where('id',$input['id'])->update([
    		'name' => $input['name']
    	]);
    	echo '1';
    }

    public function delete($id)
    {
    	Product::where('id',$id)->update([
    		'status'	=> 0
    	]);
    	return redirect('/products')->with('message-del','Product has been deleted.');

    }
}
