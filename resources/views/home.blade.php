@extends('layouts.master')
@section('title')
		Home - SST
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<h4>This Month Top 10 Records</h4>
			@if(count($this_profit)>0)
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Product Name</th>
						<th>Qty</th>
						<th>Profit</th>
					</tr>
				</thead>
				<tbody>
					<?php $tqty = 0; $tprofit=0; ?>
					@foreach($this_profit as $key => $val)
						<?php $tqty = $tqty + $val['qty'];  ?>
						<?php $tprofit = $tprofit + $val['profit'];  ?>
						<tr>
							<td>{{$key+1}}</td>
							<td><?php echo $pro_name = App\Product::where('id',$val['pro_id'])->first()->name; ?></td>
							<td>{{$val['qty']}}</td>
							<td>{{number_format($val['profit'])}}</td>
						</tr>
					@endforeach
						<tr>
							<td></td>
							<td></td>
							<td><b>{{$tqty}}</b></td>
							<td><b>{{number_format($tprofit)}}</b></td>
						</tr>
				</tbody>
			</table>
			@else
				<div class="alert alert-danger">No Record Found</div>
			@endif
		</div>
		<div class="col-sm-6">
			<h4>Last Month Top 10 Records</h4>
			@if(count($last_profit)>0)
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Product Name</th>
						<th>Qty</th>
						<th>Profit</th>
					</tr>
				</thead>
				<tbody>
					<?php $lqty = 0; $lprofit=0; ?>
					@foreach($last_profit as $key => $val)
						<?php $lqty = $lqty + $val['qty'];  ?>
						<?php $lprofit = $lprofit + $val['profit'];  ?>
						<tr>
							<td>{{$key+1}}</td>
							<td><?php echo $pro_name = App\Product::where('id',$val['pro_id'])->first()->name; ?></td>
							<td>{{$val['qty']}}</td>
							<td>{{number_format($val['profit'])}}</td>
						</tr>
					@endforeach
						<tr>
							<td></td>
							<td></td>
							<td><b>{{$lqty}}</b></td>
							<td><b>{{number_format($lprofit)}}</b></td>
						</tr>
				</tbody>
			</table>
			@else
				<div class="alert alert-danger">No Record Found</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('css')

@endsection

@section('js')
@endsection
