
@extends('layouts.master')


@section('header')View Tools @endsection

@section('body')
              
						  <table id="example" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Tool Code</th>
                          <th>Name</th>
                          <th>Available</th>
                          <th>Tool Limit</th>
                          <th>Tool Location</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
						@foreach($tool as $this_tool)
                        <tr id="row_{{$this_tool->id}}" >
                         <td id="code_{{$this_tool->id}}">{{$this_tool->tool_code}}</td>
                          <td id="name_{{$this_tool->id}}">{{$this_tool->name}}</td>
                          <td id="available_{{$this_tool->id}}">{{$this_tool->available}}</td>
                          <td id="limit_{{$this_tool->id}}">{{$this_tool->tool_limit}}</td>
                          <td id="location_{{$this_tool->id}}">{{$this_tool->tool_location}}</td>
                           <td>
						   <center>
						   <button class="stock-modal btn btn-primary" name="{{$this_tool->name}}" id="{{$this_tool->id}}">
											<span class="glyphicon glyphicon-retweet"></span> Update Stock
										</button></td></center>
										
									<td><center>	<button class="edit-modal btn btn-default" id="{{$this_tool->id}}">
											<span class="glyphicon glyphicon-edit"></span> Edit
										</button>

											<button class="delete-modal btn btn-danger" id="{{$this_tool->id}}">
											<span class="glyphicon glyphicon-trash"></span> Delete
										</button></center>
										
										 </td>

										 <!-- <td><center>	<button class="delete-modal btn btn-danger" id="{{$this_tool->id}}">
											<span class="glyphicon glyphicon-thrash"></span> Delete
										</button></center>
										
										 </td> -->
                        </tr>
						@endforeach
                      </tbody>
                    </table>
                    </div>

                     <!-- Modal Delete -->
  <div class="modal fade" data-modal-color="red" id="delModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Delete Tool?</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" id="c_delete" class="btn btn-link">Delete</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>
      
	
	<script>
	$(document).ready(function() {
			$('#example').DataTable( {
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});
			

	//Edit functionality   - It works. Do not touch !!	
			$("#example").on('click', '.edit-modal',function(){
				
				//Getting the tool id from the value of the button clicked
					value =  $(this).attr('id');
					
					//AJAX call to fill user details
					 $.ajax({
							  type:'get',
							  url : '{{URL::to('search_tool')}}',
							  data: {
										term : value
									},
							  success:function(data){

								 $('#code_tool').val(data['tool_code']);
								$('#quantity_tool').val(data['quantity']);
								$('#available_tool').val(data['available']);
								$('#limit_tool').val(data['tool_limit']);
                $('#location_tool').val(data['tool_location']);
								$('#name_tool').val(data['name']); 
							  }
						  })  
							  
			
				$("#myModal").modal();
			});
			
			
	$('#submit').click(function(){

		 var t_code =  $('#code_tool').val();
		 var t_name =  $('#name_tool').val();
		// var t_quantity =  $('#quantity_tool').val();
		// var t_available =  $('#available_tool').val();
		 var t_limit =  $('#limit_tool').val();
     var t_location =  $('#location_tool').val();

			 $.ajax({
			  type:'post',
			  
			  url : '{{URL::to('update_tool')}}',
			  
			  data : {  'name':t_name,
						't_code':t_code,
						'tool_id':value,
						'limit':t_limit,
            'location':t_location,
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



	  $("#example").on('click', '.delete-modal',function(){
        var value =  $(this).attr('id');
        
        //setting the name in the delete modal
        var name =  $(this).attr('name');

            $("#delModal").modal();
            
            $("#c_delete").click(function(){
               $.ajax({
                type:'post',
                url : '{{URL::to('delete_tools')}}',
                data: {
                    term : value,
                    '_token': $('input[name=_token]').val()
                  },
                success:function(data){
                  if(data)
                    $('#delModal').modal('toggle');
                    //$('#successModaldel').modal();
                    location.reload();
                    //$('#row_'+value).fadeOut(1000);
                    

                }
              })  
              
            });
      });


		//Update Stock functionality   - It works. Do not touch !!	
		$("#example").on('click', '.stock-modal',function(){
			
				
				//Getting the tool id from the value of the button clicked
					value =  $(this).attr('id');
					
					//AJAX call to fill tools details
					 $.ajax({
							  type:'get',
							  url : '{{URL::to('search_tool')}}',
							  data: {
										term : value
									},
							  success:function(data){

								 $('#code_tool_stock').val(data['tool_code']);
								$('#limit_tool_stock').val(data['tool_limit']);
								$('#name_tool_stock').val(data['name']); 
							  }
						  })  
							  
			
				$("#stockModal").modal();
			});
			
	$('#stock_update').click(function(){

		
		 var t_quantity =  $('#stock_qty').val();

		
			 $.ajax({
			  type:'post',
			  
			  url : '{{URL::to('update_stock')}}',
			  
			  data : {  
						'tool_id':value,
						'quantity':t_quantity,
						'_token': $('input[name=_token]').val()
																},
						
			  success:function(data){
				if(data){
				  $('#stockModal').modal('toggle');
					location.reload();
				}
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
          <h4 class="modal-title">Edit Tool</h4>
        </div>
		<hr>
        <div class="modal-body">
        <div class="row">
               
                  <div class="x_content">
                    <br />
					  <form class="form-horizontal"  >
                        {{ csrf_field() }}
						
						 	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Code</label>

                            <div class="col-md-6">
                                <input id="code_tool" type="text" class="form-control" name="code" >
                            </div>
                        </div>

                       	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name_tool" type="text" class="form-control" name="name" >
                            </div>
                        </div>

                       
						 <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
                                <input  type="text" disabled class="form-control"value="{{session('dept_name')}}" >
                            </div>
                        </div>
						
						
						 <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Threshold</label>

                            <div class="col-md-6">
                                <input id="limit_tool" type="text" class="form-control" name="limit_tool" >
                            </div>
                        </div>

              <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Location</label>

                            <div class="col-md-6">
                                <input id="location_tool" type="text" class="form-control" name="location_tool" >
                            </div>
                        </div>          
        </div>
		</form>
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
  
   <!-- Modal UPdate Stock-->
  <div class="modal fade" id="stockModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Tool Stock</h4>
        </div>
		<hr>
        <div class="modal-body">
        <div class="row">
               
                  <div class="x_content">
                    <br />
					  <form class="form-horizontal"  >
                        {{ csrf_field() }}
						
						 	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Code</label>

                            <div class="col-md-6">
                                <input id="code_tool_stock" disabled type="text" class="form-control" name="code" >
                            </div>
                        </div>

                       	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name_tool_stock" disabled type="text" class="form-control" name="name" >
                            </div>
                        </div>

                       
						 <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
                                <input  type="text" disabled class="form-control"value="{{session('dept_name')}}" >
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Quantity</label>

                            <div class="col-md-6">
                                <input  type="text" id="stock_qty" name="stock_qty" class="form-control"  >
                            </div>
                        </div>
						
						
						
        </div>
		</form>
    </div>
	<hr>
	 <div class="modal-footer">
         
                        <center>
                          <button type="button" data-dismiss="modal" class="btn  btn-default">Cancel</button>
                          <button type="submit" id="stock_update" class="btn btn-success">Update</button>
                       </center>

        </div>

  </div>
  </div>
  </div>
  </div>
  
  
  <!-- Modal delete Successfull -->
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
  
  
  
  
@endsection