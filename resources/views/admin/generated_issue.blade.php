
@extends('layouts.master')


@section('header')Issue Report @endsection

@section('body')

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

		@foreach($issue as $this_issue)
		<?php
		if($this_issue->lineid!=0)
		{
			$linename=DB::table('lines')->where('id',$this_issue->lineid)->value('name');
		}
		if($this_issue->productid!=0)
		{
			$productname=DB::table('products')->where('id',$this_issue->productid)->value('name');
		}
		?>
		<tr>

			<td>{{ Carbon\Carbon::parse($this_issue->date)->toFormattedDateString() }}</td>
			<td>{{$this_issue->user_name}}</td>
			<td>{{$this_issue->tool_name}}</td>
			<td>{{$this_issue->tool_qty}}</td>
			<td>{{$this_issue->shift_id}}</td>
			<td>{{$this_issue->wk_name}}</td>
			<td>@if($this_issue->lineid==0) No Line @else {{$linename}} @endif</td>
			<td>@if($this_issue->productid==0) No Product @else {{$productname}} @endif</td>
		</tr>
		@endforeach
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
  