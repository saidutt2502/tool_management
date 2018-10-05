
@extends('layouts.master')


@section('header')View Administrators @endsection

@section('body')

	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Email</th>
				<th>Last Login</th>
			</tr>
		</thead>
		<tbody>
			@foreach($admin as $this_admin)
				<tr>
					<td>{{$this_admin->emp_code}}</td>
					<td>{{$this_admin->name}}</td>
					<td>{{$this_admin->email}}</td>
				
					<td>{{ Carbon\Carbon::parse($this_admin->login)->toDayDateTimeString() }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
   
        <!-- /page content -->

      
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