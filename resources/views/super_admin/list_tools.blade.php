@extends('layouts.master')

@section('header'){{ $dept }} - Tools @endsection

@section('body')
				  
	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Tool Code</th>
				<th>Name</th>
				<th>Available</th>
				<th>Tool Limit</th>
			</tr>
		</thead>
	<tbody>
		@foreach($tool as $this_tool)
			<tr id="row_{{$this_tool->id}}" >
				<td id="code_{{$this_tool->id}}">{{$this_tool->tool_code}}</td>
				<td id="name_{{$this_tool->id}}">{{$this_tool->name}}</td>
				<td id="available_{{$this_tool->id}}">{{$this_tool->available}}</td>
				<td id="limit_{{$this_tool->id}}">{{$this_tool->tool_limit}}</td>
			</tr>
		@endforeach
	</tbody>
	</table>
	</div>
	
<script>

	$(document).ready(function() {
			$('#example').DataTable( {
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});
	});		
</script>
@endsection