@extends('layouts.master')


@section('header')Return Report @endsection

@section('body')
	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Supervisor</th>
				<th>Tool Name</th>
				<th>Tool Quantity</th>
				<th>Workstation Name</th>
				<th>Shift</th>
				<th>Remarks</th>
			</tr>
		</thead>
		<tbody>
			@foreach($return as $this_return)
			<tr>
					<td>{{ Carbon\Carbon::parse($this_return->date)->toFormattedDateString() }}</td>
					<td>{{$this_return->user_name}}</td>
					<td>{{$this_return->tool_name}}</td>
					<td>{{$this_return->tool_qty}}</td>
					<td>{{$this_return->wk_name}}</td>
					<td>{{$this_return->shift_id}}</td>
					<td>{{$this_return->remarks}}</td>
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
			$('#return_link').addClass("current-page");
			$('#tools_ul').css('display','block');
			
	
});
	</script>
   
@endsection