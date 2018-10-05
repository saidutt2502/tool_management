@extends('layouts.master')

@section('header')View Stock @endsection
@section('body')
                   
	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Tool Code</th>
				<th>Name</th>
				<th>Available</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tool as $this_tool)
			<tr>
				<td>{{$this_tool->tool_code}}</td>
				<td>{{$this_tool->name}}</td>
				<td>{{$this_tool->available}}</td>
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
    } );
} );
	</script>
@endsection