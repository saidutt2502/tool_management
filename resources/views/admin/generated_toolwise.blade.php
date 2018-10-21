
@extends('layouts.master')


@section('header')Tool Wise Report @endsection

@section('body')

 <a href="tool_wise_report"><img src="/images/back.png" height="50px" width="50px"></a><br><br>

	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
			<th>Date</th>
			<th>Supervisor</th>
			<th>Tool Name</th>
			<th>Tool Quantity</th>
			<th>Shift</th>
			<th>Workstation Name</th>
			<th>Line Name</th>
			<th>Product Name</th>
			</tr>
		</thead>
		
	<tbody>

		@foreach($toolwise as $this_toolwise)
		<?php
		if($this_toolwise->lineid!=0)
		{
			$linename=DB::table('lines')->where('id',$this_toolwise->lineid)->value('name');
		}
		if($this_toolwise->productid!=0)
		{
			$productname=DB::table('products')->where('id',$this_toolwise->productid)->value('name');
		}
		?>
		<tr>

			<td>{{ Carbon\Carbon::parse($this_toolwise->date)->toFormattedDateString() }}</td>
			<td>{{$this_toolwise->user_name}}</td>
			<td>{{$this_toolwise->tool_name}}</td>
			<td>{{$this_toolwise->tool_qty}}</td>
			<td>{{$this_toolwise->shift_id}}</td>
			<td>{{$this_toolwise->wk_name}}</td>
			<td>@if($this_toolwise->lineid==0) No Line @else {{$linename}} @endif</td>
			<td>@if($this_toolwise->productid==0) No Product @else {{$productname}} @endif</td>
		</tr>
		@endforeach
		    <tr><td colspan="8" align="right"><h2>Total Issued: {{$total}}</h2></td></tr>
	</tbody>
	</table>
  

	<script>
	$(document).ready(function() {
		
		
			$('#example').DataTable( {
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});

			$('#tools_li').addClass("active");
			$('#issue_link').addClass("current-page");
			$('#tools_ul').css('display','block');
			
});
	</script>
   
@endsection
  