@extends('layouts.master')

@section('header')Stock History @endsection
@section('body')
                   
	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Tool Code</th>
				<th>Name</th>
				<th>Quantity</th>
				<th>Added by</th>
				<th>Added on</th>
			</tr>
		</thead>
		<tbody>
			@foreach($stock as $this_stock)
			<tr>
				<td>{{$this_stock->code}}</td>
				<td>{{$this_stock->name}}</td>
				<td>{{$this_stock->quantity}}</td>
				<td>{{$this_stock->user_name}}</td>
				<td>{{ Carbon\Carbon::parse($this_stock->added_on)->toFormattedDateString() }}</td>
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