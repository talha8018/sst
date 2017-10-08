@extends('layouts.master')
@section('title')
    Sale - SST
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="/insert-sale" method="POST"  class=" form-horizontal col-xs-12">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="control-label col-sm-3">Stock Item</label>
                    <div class="col-sm-9">
                        <select class="form-control stocks" id="stock_id" name="stock_id">
                            <option></option>
                            <?php foreach($stock as $s): ?>
                                <option value="{{$s['id']}}" data-qty="{{$s['quantity']}}">{{$s['name']}} ******* [QTY => {{$s['quantity']}} UPP => {{number_format($s['unit_purchase_price'],2)}} USP => {{number_format($s['unit_sale_price'],2)}}]</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Quantity</label>
                    <div class="col-sm-9">
                        <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Quantity">
                    </div>
                </div>

                


                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default">Sale</button>
                    </div>              
                </div>
            </form>



            <div class="clearfix"></div>
            @if ( session()->has('message') )
                <div class="alert alert-success alert-dismissable"><b> Success! </b> {{ session()->get('message') }}</div>
            @endif

            @if ( session()->has('message-del') )
                <div class="alert alert-success alert-dismissable"><b> Success! </b> {{ session()->get('message-del') }}</div>
            @endif
            
            @if ( session()->has('message-up') )
                <div class="alert alert-success alert-dismissable"><b> Success! </b> {{ session()->get('message-up') }}</div>
            @endif
            <hr>
            <form action="/search-sale" method="get">
                <div class="col-md-3">
                    <select class="form-control products" name="pro_id">
                            <option value="">Select Product</option>
                        <?php foreach($products as $p): ?>
                            <option value="{{$p['id']}}">{{$p['name']}}</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="from" class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="submit" class="btn btn-default" name="" value="Search">
                </div>
            </form>
            <div class="clearfix"></div>
            <br>
            <div class="panel panel-default">                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 2%;">#</th>
                            <th>Product Name</th>
                            <th style="width: 2%;">Qty</th>
                            <th>U.P. Price</th>
                            <th>U.S. Price</th>
                            <th>Unit Profit</th>
                            <th>Total Profit</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sale as $key => $s): ?>
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><?php echo $pro_name = App\Product::where('id',$s['pro_id'])->first()->name; ?></td>
                                <td>{{$s['quantity']}}</td>
                                <td>{{number_format($s['unit_purchase_price'],2)}}</td>
                                <td>{{number_format($s['unit_sale_price'],2)}}</td>
                                <td>{{number_format($s['unit_profit'])}}</td>
                                <td>{{number_format($s['total_profit'])}}</td>
                                <td><?php echo Carbon\Carbon::createFromTimeStamp(strtotime($s['created_at']))->diffForHumans(); ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{number_format($total)}}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{ $sale->appends($data)->links() }}
        </div>
    </div>
</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Product</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Product Name</label>
                    <div class="col-sm-9">
                      <input type="text"  class="form-control" id="pro-name" placeholder="Enter Product">
                    </div>
                  </div>
                 <input type="hidden" id='pro-id'>
                  <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="button" class="btn btn-default" id="pro-update">Update</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="css/select2.css">

@endsection

@section('js')
<script src="js/select2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.stocks,.products').select2({ placeholder: 'Choose One'});
    });

    $("#stock_id").on("change",function(){
        var qty = $(this).find(":selected").data("qty");
        $("#quantity").attr("max",qty);
        $("#quantity").attr("min","1");
    });
</script>
@endsection
