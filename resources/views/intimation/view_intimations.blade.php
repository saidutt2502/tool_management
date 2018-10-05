
@extends('layouts.master')


@section('header')View Intimations @endsection

@section('body')
 <a href="/create_intimations" class="btn btn-primary">&nbsp<span class="fa fa-plus"></span>&nbspNew&nbspIntimation&nbsp&nbsp</a><br><br>

	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Breakdown Date and Time</th>
				<th>Reporting Date and Time</th>
				<th>Machine Number</th>
				<th>Department</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($intimation as $intimations)
				<tr>
					<?php
					$dept= DB::table('department')->where('id', $intimations->dept_id)->first();
					$user= DB::table('users')->where('id', $intimations->added_by)->first();
					?>
					<td>{{ date("d M y , h:i a",strtotime($intimations->breakdown_time)) }}</td>
					<td>{{ date("d M y , h:i a",strtotime($intimations->reporting_time)) }}</td>
					<td>{{$intimations->machine_name}}</td>
					<td>{{$dept->department_name}}</td>
					@if($intimations->status=='Maintenance Complete')
					<td><center>
				    <button class="confirm-modal btn btn-success md" id="{{$intimations->id}}"><span class="glyphicon glyphicon-ok"></span> Confirm Completion</button>
				    </center></td>
					@else
					<td>--</td>
				    @endif
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
        ],
        "order": [[ 0, "desc" ]]
    });

			$("#example").on('click', '.confirm-modal',function(){
				
				//Getting the tool id from the value of the button clicked
					value =  $(this).attr('id');


			 $.ajax({
			  type:'post',
			  
			  url : '{{URL::to('confirm_intimations')}}',
			  
			  data : {  
						'intimation_id':value,
						'_token': $('input[name=_token]').val()
																},
						
			  success:function(data){
				if(data){
					location.reload();
				}
			  }
		  }) 
					
					
			});
			
			
	
						
});
	</script>
   
   
  
  
@endsection