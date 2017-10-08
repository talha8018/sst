@extends('layouts.master')
@section('title')
    Home - SST
@endsection
@section('content')
<div class="container">
 
        
<div class="row">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-md-3">
        <div class="well">
          <h4 class="text-danger"><span class="label label-success pull-right"> 2,650</span> Monthly </h4>
          9% less than last month
        </div>
      </div>
      <div class="col-md-3">
        <div class="well">
          <h4 class="text-success"><span class="label label-success pull-right">+ 3%</span> Returning </h4>
        </div>
      </div>
      <div class="col-md-3">
        <div class="well">
          <h4 class="text-primary"><span class="label label-primary pull-right">201</span> Sales </h4>
        </div>
      </div>
      <div class="col-md-3">
        <div class="well">
          <h4 class="text-success"><span class="label label-success pull-right">+ 24%</span> Pageviews </h4>
        </div>
      </div>
    </div><!--/row-->    
  </div><!--/col-12-->
</div><!--/row-->
</div>
@endsection

@section('css')
<style type="text/css">
    .well
    {
        background-color: #fff;
    }
</style>
@endsection

@section('js')
@endsection
