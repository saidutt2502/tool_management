
@extends('layouts.master')


@section('header')View Machines @endsection

@section('body')
 <a href="/create_machine" class="btn btn-primary">&nbsp<span class="fa fa-plus"></span>&nbspNew&nbspMachine&nbsp&nbsp</a><br><br>

	<table id="example" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Machine Name</th>
				<th>Machine Number</th>
				<th>Department</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($intimation as $intimations)
				<tr>
					<?php
					$dept= DB::table('department')->where('id', $intimations->dept_id)->value('department_name');
					?>
					<td>{{$intimations->name}}</td>
					<td>{{$intimations->number}}</td>
					<td>{{$dept}}</td>
					<td><center>
				    <button class="delete-modal btn btn-danger md" id="{{$intimations->id}}"><span class="glyphicon glyphicon-trash"></span> Delete</button>
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
        "order": [[ 0, "asc" ]]
    });

			$("#example").on('click', '.delete-modal',function(){
        var value =  $(this).attr('id');
        
        

            $("#delModal").modal();
            
            $("#c_delete").click(function(){
               $.ajax({
                type:'post',
                url : '{{URL::to('machine_delete')}}',
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

	<div class="modal fade" data-modal-color="red" id="delModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Delete Machine?</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" id="c_delete" class="btn btn-link">Delete</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>
   
   
  
  
@endsection