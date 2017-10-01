@extends('layouts.master')
@section('title')
    Products - SST
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="/insert-product" method="POST"  class=" form-horizontal col-xs-12">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="control-label col-sm-3">Product Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="product" placeholder="Enter Product">
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
                            <th>Name</th>
                            <th style="width: 13%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$p['name']}}</td>
                            <td>
                                <a href="#" data-id="{{$p['id']}}" data-name="{{$p['name']}}" data-toggle="modal" data-target="#myModal" class="edit">
                                 Edit
                                </a>
                                |
                                <a href="/delete-product/{{$p['id']}}">
                                  Delete
                                </a>
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
@endsection

@section('js')
<script>
    $(".edit").click(function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        $("#pro-name").val(name);
        $("#pro-id").val(id);
    });
    $("#pro-update").click(function(){
        var name = $("#pro-name").val();
        var id = $("#pro-id").val();

        $.ajax({
            url     : '/update-product',
            type    : 'post',
            data    : {'id':id,'name':name,"_token": "{{ csrf_token() }}"},
            success : function(result){
                if (result=='1') {
                    location.reload();
                }
            }
        })
    });
</script>
@endsection
