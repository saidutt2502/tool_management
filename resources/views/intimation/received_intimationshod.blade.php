
@extends('layouts.master')


@section('header')Spares Replaced @endsection

@section('body')
<?php
$curr_user= DB::table('users')->where('id', session('user_id'))->first();
?>
 

	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Breakdown Date and Time</th>
				<th>Machine Handover Date and Time</th>
				<th>Machine Number</th>
				<th>Department</th>
				<th>Attened By</th>
				<th>Total Breakdown</th>
				<th>Action</th>

			</tr>
		</thead>
		<tbody>
			@foreach($intimation as $intimations)
				<tr>
					<?php
					$dept= DB::table('department')->where('id', $intimations->dept_id)->first();
					$user= DB::table('users')->where('id', $intimations->attended_by)->first();
					?>
					<td>{{ date("d M y , h:i a",strtotime($intimations->breakdown_time)) }}</td>
					<td>{{ date("d M y , h:i a",strtotime($intimations->machine_handover)) }}</td>
					<td>{{$intimations->machine_name}}</td>
					<td>{{$dept->department_name}}</td>
					<td>{{$user->name}}</td>
					<td>{{$intimations->totalbreakdown}} hours</td>
					<td><center>
					@if($intimations->status=='Maintenance Confirmed')
					
				     <a href="/spares_details?idd=<?php echo $intimations->id; ?> " class=" btn btn-md btn-primary "><span class="glyphicon glyphicon-pencil"></span>&nbspSpares Details</a>
				    
				    @endif
				    @if($intimations->status=='HOD Verification' && $curr_user->user_type=='2')
				   
				     <a href="/hod_verification?idd=<?php echo $intimations->id; ?> " class=" btn btn-md btn-success " ><span class="glyphicon glyphicon-ok"></span>&nbspVerification</a>
				     @endif
				    
				    @if($intimations->status=='Complete' && $curr_user->user_type=='2')
				    
				     <a href="/hod_verification?idd=<?php echo $intimations->id; ?> " class=" btn btn-md btn-success " ><span class="glyphicon glyphicon-eye-open"></span>&nbspView</a>
				    
				    @endif
				    @if($intimations->status=='Maintenance Complete')
				   
				    --
                    
				    @endif
				    @if($intimations->status=='Complete' && $curr_user->user_type=='3')
                    --
				    @endif
				    @if($intimations->status=='HOD Verification' && $curr_user->user_type=='3')
                    --
				    @endif
				    </center></td>


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

			$("#example").on('click', '.delete-modal',function(){
				var value =  $(this).attr('id');
				
				//setting the name in the delete modal
				var name =  $(this).attr('name');
						$("#delModal").modal();
		
						
						$("#c_delete").click(function(){
							 $.ajax({
							  type:'post',
							  url : '{{URL::to('delete_intimations')}}',
							  data: {
										term : value,
										'_token': $('input[name=_token]').val()
									},
							  success:function(data){
								  if(data)
									  $('#delModal').modal('toggle');
										location.reload();
										

							  }
						  })  
							
						});
			});

			$("#example").on('click', '.detail-modal',function(){
				
				//Getting the tool id from the value of the button clicked
					value =  $(this).attr('id');
					
					//AJAX call to fill user details
					 $.ajax({
							  type:'get',
							  url : '{{URL::to('search_intimations')}}',
							  data: {
										term : value
									},
							  success:function(data){

								$('#machine_name').val(data['machine_name']);
								 
							  }
						  })  
							  
			
				$("#myModal").modal();
			});
			
			
	$('#submit').click(function(){

		 var work_start =  $('#work_start').val();
		 var machine_handover =  $('#machine_handover').val();
		 var details =  $('#details').val();

			 $.ajax({
			  type:'post',
			  
			  url : '{{URL::to('update_intimations')}}',
			  
			  data : {  'work_start':work_start,
						'machine_handover':machine_handover,
						'intimation_id':value,
						'details':details,
						'_token': $('input[name=_token]').val()
																},
						
			  success:function(data){
				if(data){
				  $('#myModal').modal('toggle');
					location.reload();
				}
			  }
		  }) 
	});	
						
});
	</script>

	<!-- Modal Delete -->
  <div class="modal fade" data-modal-color="red" id="delModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Delete Request?</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" id="c_delete" class="btn btn-link">Delete</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>

   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Maintenance Details</h4>
        </div>
		<hr>
        <div class="modal-body">
        <div class="row">
               
                  <div class="x_content">
                    <br />
					  <form class="form-horizontal"  >
                        {{ csrf_field() }}
						
						 	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Machine Name</label>

                            <div class="col-md-6">
                                <input id="machine_name" class="form-control" disabled>
                            </div>
                        </div>


                       	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Work Start Date and Time</label>

                            <div class="col-md-6">
                                <input id="work_start" type="datetime-local" class="form-control" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Machine Handed Date and Time</label>

                            <div class="col-md-6">
                                <input id="machine_handover" type="datetime-local" class="form-control" >
                            </div>
                        </div>

                         <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Breakdown Details</label>

                            <div class="col-md-6">
                                <textarea id="details" type="text" class="form-control" ></textarea>
                            </div>
                        </div>
        </div>
		</form>
    </div>
	<hr>
	 <div class="modal-footer">
         
                        <center>
                          <button type="submit" id="submit" class="btn btn-success">Submit</button>
                          <button type="button" data-dismiss="modal" class="btn  btn-default">Cancel</button>
                        </center>

        </div>

  </div>
  </div>
  </div>
  </div>
   
   
  
  
@endsection