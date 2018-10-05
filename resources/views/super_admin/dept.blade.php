
@extends('layouts.master')


@section('header')Manage Departments @endsection

@section('body')
	
		<button class="btn btn-primary pull-right"  id="add_modal">
		<span class="glyphicon glyphicon-plus"></span> Add Departments
		</button>


	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Department Id</th>
				<th>Department Name</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($dept as $this_dept)
				<tr id="row_{{$this_dept->id}}" >
					<td>{{$this_dept->id}}</td>
					<td>{{$this_dept->department_name}}</td>
					<td><center>
					<button class="delete-modal btn btn-danger" name="{{$this_dept->department_name}}" id="{{$this_dept->id}}">
					<span class="glyphicon glyphicon-trash"></span> Delete
					</button></center></td>
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
			
	$('#add_modal').click(function(){
		$('#myModal').modal();
	});	
	
	$('#submit').click(function(){
		value =  $('#name_dept').val();
		 $.ajax({
							  type:'get',
							  url : '{{URL::to('add_department')}}',
							  data: {
										term : value
									},
							  success:function(data){
								  if(data==1)
								  {
									  	$('#myModal').modal('toggle');
										$('#successModal').modal();  
								  }

							  }
						  })  
	});	






	

  	$("#example").on('click', '.delete-modal',function(){
				var value =  $(this).attr('id');
				
				//setting the name in the delete modal
				var name =  $(this).attr('name');
						$("#delModal").modal();
						$("#s_del_name").text(name);
						
						$("#c_delete").click(function(){
							 $.ajax({
							  type:'get',
							  url : '{{URL::to('del_dept')}}',
							  data: {
										term : value,
										'_token': $('input[name=_token]').val()
									},
							  success:function(data){
								  if(data)
									  $('#delModal').modal('toggle');
										$('#successModaldel').modal();
										$('#row_'+value).fadeOut(2200);

							  }
						  })  
							
						});
			});




	
		
		
						
});
	</script>
   
   
   <!-- Modal Edit-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Department</h4>
        </div>
		<hr>
        <div class="modal-body">
        <div class="row">
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask">
					  <div class="col-md-12  form-group">
                        <input type="text" class="form-control has-feedback-left" id="name_dept" placeholder="Name">
                        <span class="fa fa-institution form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     
				</form>
                  </div>
        </div> 
    </div>
	<hr>
	 <div class="modal-footer">
                        <center>
                          <button type="button" data-dismiss="modal" class="btn  btn-default">Cancel</button>
                          <button type="submit" id="submit" class="btn btn-success">Add</button>
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
          <h4 class="modal-title"><center>Department Added !</center></h4>
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
          <h4 class="modal-title"><center>Delete Successfull !</center></h4>
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
          <h4 class="modal-title"><center>Delete Department <span id="s_del_name"></span>?</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" id="c_delete" class="btn btn-link">Delete</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>
  
@endsection