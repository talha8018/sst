@extends('layouts.master')
@section('title')
    Stock - SST
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="/insert-stock" method="POST"  class=" form-horizontal col-xs-12">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="control-label col-sm-3">Product Name</label>
                    <div class="col-sm-9">
                        <select class="form-control products" name="pro_id">
                                <option value="">Select Product</option>
                            <?php foreach($products as $p): ?>
                                <option value="{{$p['id']}}">{{$p['name']}}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Quantity</label>
                    <div class="col-sm-9">
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Unit Purchase Price</label>
                    <div class="col-sm-9">
                        <input type="number" name="upp" class="form-control" placeholder="Unit Purchase Price">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Unit Sale Price</label>
                    <div class="col-sm-9">
                        <input type="number" name="usp" class="form-control" placeholder="Unit Sale Price">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Description</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="description" rows="4"></textarea>
                    </div>
                </div>



                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default">Add</button>
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
            <div class="panel panel-default">                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 2%;">#</th>
                            <th>Product Name</th>
                            <th style="width: 2%;">Qty</th>
                            <th style="width: 8%;">U.P. Price</th>
                            <th style="width: 8%;">U.S. Price</th>
                            <th>Description</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($stock as $key => $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><?php echo $pro_name = App\Product::where('id',$p['pro_id'])->first()->name; ?></td>
                            <td>{{$p['quantity']}}</td>
                            <td>{{number_format($p['unit_purchase_price'],2)}}</td>
                            <td>{{number_format($p['unit_sale_price'],2)}}</td>
                            <td>{{$p['description']}}</td>

                            <td>
                                <div class="dropup">
                                    <button class="btn btn-danger btn-xs" type="button" data-toggle="dropdown">   Delete <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="/delete-stock/{{$p['id']}}">Delete</a></li>
                                    </ul>
                                    |
                                    <a href="#" data-id="{{$p['id']}}" data-name="{{$pro_name}}" data-qty="{{$p['quantity']}}" data-upp="{{number_format($p['unit_purchase_price'],2)}}" data-usp="{{number_format($p['unit_sale_price'],2)}}" data-toggle="modal" data-target="#myModal" class="edit"> Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Quantity</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Product Name</label>
                    <div class="col-sm-9">
                      <input type="text" readonly="readonly" class="form-control" id="pro-name" placeholder="Enter Product">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Purchase Price</label>
                    <div class="col-sm-9">
                      <input type="text" readonly="readonly" class="form-control" id="m-upp" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Sale Price</label>
                    <div class="col-sm-9">
                      <input type="text" readonly="readonly" class="form-control" id="m-usp" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Quantity</label>
                    

                    <div class="col-sm-3">
                      <input type="text" readonly="readonly" class="form-control" id="m-qty-old" >
                    </div>
                    
                    <span class="dot-plus">+</span>

                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="m-qty-new" >
                    </div>
                    <span class="dot-equal">=</span>
                    <div class="col-sm-3">
                      <input type="text" readonly="readonly" class="form-control" id="m-qty-equal" >
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
<style type="text/css">
    .dot-plus
    {
        position: absolute;
        left: 49%;
        font-size: 30px;
        top: 57%;
    }
    .dot-equal
    {
        position: absolute;
        font-size: 30px;
        top: 56%;
        right: 24%;
    }
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: -13px;
        z-index: 1000;
        display: none;
        min-width: 84px;
    }
</style>
@endsection

@section('js')
<script src="js/select2.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        $('.products').select2({ placeholder: 'Choose One'});
    });


    $(".edit").click(function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var upp = $(this).data('upp');
        var usp = $(this).data('usp');
        var qty = $(this).data('qty');

        $("#pro-name").val(name);
        $("#pro-id").val(id);
        $("#m-upp").val(upp);
        $("#m-usp").val(usp);
        $("#m-qty-old").val(qty);

        $("#m-qty-equal").val(parseInt(qty));
    });


    $("#m-qty-new").keyup(function(){
        var old = $("#m-qty-old").val();
        var ne = $(this).val();
        if(ne=="")
        {
            ne=0;
        }
        $("#m-qty-equal").val(parseInt(old) + parseInt(ne));
    })

    $("#pro-update").click(function(){
        var qty = $("#m-qty-equal").val();
        var id = $("#pro-id").val();

        $.ajax({
            url     : '/update-stock',
            type    : 'post',
            data    : {'id':id,'qty':qty,"_token": "{{ csrf_token() }}"},
            success : function(result){
                if (result=='1') 
                {
                        location.reload();
                }
            }
        })
    });
</script>
@endsection
