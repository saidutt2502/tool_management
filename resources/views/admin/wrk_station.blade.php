
@extends('layouts.master')


@section('header')Manage Workstation @endsection

@section('body')
	
		<button class="btn btn-primary pull-right"  id="add_modal">
		<span class="glyphicon glyphicon-plus"></span> Add Workstations
		</button>


	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Workstation Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($station as $this_wrk_station)
				<tr>
					<td>{{$this_wrk_station->name}}</td>
					<td><center>
					<button class="delete-modal btn btn-danger" name="{{$this_wrk_station->name}}" id="{{$this_wrk_station->id}}">
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
		value =  $('#name_wrkstation').val();
		 $.ajax({
							  type:'get',
							  url : '{{URL::to('add_wrkstation')}}',
							  data: {
										term : value
									},
							  success:function(data){
								  if(data==1)
								  {
									  	$('#myModal').modal('toggle');
										location.reload(); 
								  }

							  }
						  })  
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
							  url : '{{URL::to('del_wrkstation')}}',
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
		
		
						
});
	</script>
   
   
   <!-- Modal Edit-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Workstation</h4>
        </div>
		<hr>
        <div class="modal-body">
        <div class="row">
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask">
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="name_wrkstation" placeholder="Name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" disabled class="form-control has-feedback-left" value="{{session('dept_name')}}" id="dept_wrkstation" placeholder="Department">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
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
          <h4 class="modal-title"><center>Workstation Added !</center></h4>
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
          <h4 class="modal-title"><center>Delete Workstation <span id="s_del_name"></span>?</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" id="c_delete" class="btn btn-link">Delete</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>
  
@endsection