@extends('layouts.master')
@section('header')View Supervisor @endsection
@section('body')


	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Supervisor ID</th>
				<th>Name</th>
				<th>Email</th>
			
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		@foreach($supervisor as $this_user)
		<?php	$phone = DB::table('user_details')->where('user_id', $this_user->id)->value('contact_number'); ?>
			<tr id="row_{{$this_user->id}}" >
				<td>{{$this_user->emp_code}}</td>
				<td>{{$this_user->name}}</td>
				<td>{{$this_user->email}}</td>
			
				<td><center><button class="edit-modal btn btn-info" id="{{$this_user->id}}">
				<span class="glyphicon glyphicon-edit"></span> Edit
				</button>

				<button class="delete-modal btn btn-danger" name="{{$this_user->name}}" id="{{$this_user->id}}">
				<span class="glyphicon glyphicon-trash"></span> Delete
				</button></center></td>
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
			
			
		
			
		//Delete Functionality	
			$("#example").on('click', '.delete-modal',function(){
				var value =  $(this).attr('id');
				
				//setting the name in the delete modal
				var name =  $(this).attr('name');
						$("#delModal").modal();
						$("#s_del_name").text(name);
						
						$("#c_delete").click(function(){
							 $.ajax({
							  type:'post',
							  url : '{{URL::to('delete_user')}}',
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
			
	//Edit functionality   - It works. Do not touch !!	
			$("#example").on('click', '.edit-modal',function(){
				
				//Getting the user id from the value of the button clicked
					value =  $(this).attr('id');
					
					//AJAX call to fill user details
					 $.ajax({
							  type:'get',
							  url : '{{URL::to('search_supervisor')}}',
							  data: {
										term : value
									},
							  success:function(data){
								console.log(data);
								$('#id_supervisor').val(data['emp_code']);
								$('#email_supervisor').val(data['email']);
								$('#name_supervisor').val(data['name']);
								$('#number_supervisor').val(data['contact']);
								

							  }
						  })  
						
			//AJAX call to get departments the supervisor is assigned to			
					  $.ajax({
						  type:'get',
						  url : '{{URL::to('get_dept')}}',
						  data: {
									term : value
								},
							
						  success:function(data){
							var i=0;
							console.log(data);
								$(".checkbox").empty();
									$.each(data['supervisor_dept'], function() {
										
																			
										$(".checkbox").append("<a class='btn btn-app'><i class='fa fa-users'></i><strong>"+data['supervisor_dept'][i]['department_name']+"</strong> </a>");

											i++;
									});
									
											
						  } 
						  
					  }); 
						  
				$(".check").addClass('flat');
				$("#myModal").modal();
			});
			
			
	$('#submit').click(function(){
		 
		 value =  $('.edit-modal').attr('id');
		 var s_id =  $('#id_supervisor').val();
		 var s_name =  $('#name_supervisor').val();
		 var s_email =  $('#email_supervisor').val();
		 var s_number =  $('#number_supervisor').val();
		
			 $.ajax({
			  type:'post',
			  
			  url : '{{URL::to('update_user')}}',
			  
			  data : {  'name':s_name,
						's_code':s_id,
						'user_id':value,
						'email':s_email,
						'number':s_number,
						'_token': $('input[name=_token]').val()
																},
						
			  success:function(data){
				if(data)
				  $('#myModal').modal('toggle');
					location.reload();
			  }
		  }) 
	});		 
						
});
	</script>
   
   
   <!-- Modal Edit-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Supervisor</h4>
        </div>
		<hr>
        <div class="modal-body">
        <div class="row">
               
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask">

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="id_supervisor" placeholder="Supervisor Code">
                        <span class="fa fa-language form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="name_supervisor" placeholder="Name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="email_supervisor" placeholder="Email">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="number_supervisor" placeholder="Phone">
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                      </div>
				</form>
					<br>
				 <label for="start_date"><h4><b>Assigned Departments</b></h4></label>
				 <hr>

			<div class="checkbox">
			
                         </div>
                  </div>
        </div>
    
	  
    </div>
	<hr>
	 <div class="modal-footer">
         
                        <center>
                          <button type="button" data-dismiss="modal" class="btn  btn-default">Cancel</button>
                          <button type="submit" id="submit" class="btn btn-success">Update</button>
                       </center>
                    
                    
        </div>
		
  </div>
  </div>
  </div>
  
  
  <!-- Modal Edit Successfull -->
  <div class="modal fade" data-modal-color="green" id="successModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		 <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>Update Succesfull !</center></h4>
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- Modal Edit Successfull -->
  <div class="modal fade" data-modal-color="green" id="successModaldel" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		 <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>Delete Succesfull !</center></h4>
        </div>
      </div>
      
    </div>
  </div>
  
  
  <!-- Modal Delete -->
  <div class="modal fade" data-modal-color="red" id="delModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Delete Supervisor <span id="s_del_name"></span>?</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" id="c_delete" class="btn btn-link">Delete</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>
@endsection