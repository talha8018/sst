<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Stock;
use App\Product;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this_profit =Sale::whereDate('created_at','>=',Carbon::now()->startOfMonth())
            ->whereDate('created_at','<=',Carbon::now())
            ->select(DB::raw('sum(total_profit) as profit'),DB::raw('sum(quantity) as qty'),'pro_id')->orderBy('profit','desc')->groupBy('pro_id')->limit(10)->get()->toArray();

        $last_profit =Sale::whereDate('created_at','>=',Carbon::now()->startOfMonth()->subMonth())
            ->whereDate('created_at','<=',Carbon::now()->startOfMonth()->subSecond())
            ->select(DB::raw('sum(total_profit) as profit'),DB::raw('sum(quantity) as qty'),'pro_id')->orderBy('profit','desc')->groupBy('pro_id')->limit(10)->get()->toArray();
            
        return view('home',compact('this_profit','last_profit'));
    }
}
