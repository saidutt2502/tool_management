
@extends('layouts.master')


@section('header')Issue Report @endsection

@section('body')

	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
			<th>Date</th>
			<th>Issue ID</th>
			<th>Supervisor</th>
			<th>Tool Name</th>
			<th>Tool Quantity</th>
			<th>Department</th>
			<th>Workstation Name</th>
			<th>Shift</th>
			</tr>
		</thead>
		
	<tbody>

		@foreach($issue as $this_issue)
		<tr>
			<td>{{$this_issue->date}}</td>
			<td>{{$this_issue->id}}</td>
			<td>{{$this_issue->user_name}}</td>
			<td>{{$this_issue->tool_name}}</td>
			<td>{{$this_issue->tool_qty}}</td>
			<td>{{$this_issue->dept_name}}</td>
			<td>{{$this_issue->wk_name}}</td>
			<td>{{$this_issue->shift_id}}</td>
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

			$('#tools_li_s').addClass("active");
			$('#issue_link_s').addClass("current-page");
			$('#tools_ul_s').css('display','block');
			
});
	</script>
   
@endsection
  