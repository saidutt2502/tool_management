@extends('layouts.master')

@section('header')Supervisors Details @endsection
@section('body')
        <div class="col-md-13 ">
            <div class="panel panel-default">
               

                <div class="panel-body">
				<br>
                       <form class="form-horizontal" >
							{{ method_field('PUT') }}
								{{ csrf_field() }}
				<!--	hidden field to know user type -->
						<input id="register_type" type="hidden" class="form-control" name="register_type" value="3">

                       	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" value="{{$user->name}}" name="name" >
                                <input id="user_id" type="hidden"  value="{{$user->id}}" name="user_id" >
                            </div>
                        </div>

                       <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
							   @foreach ($dept as $each_dept) 
											
											<div class="checkbox">
                                                <label>
												@if(array_has($supdept, $each_dept->id))
													<?php $value="checked"; ?>
												@else
													<?php $value=""; ?>
												@endif
                                                    <input name="department[]" id="selected_dept" type="checkbox" {{$value}} value="{{ $each_dept->id }}">{{ $each_dept->department_name }}
                                                </label>
                                            </div>
												
											
									
								@endforeach
                            </div>
                        </div>
						
						
						 	<div class="form-group">
                            <label for="email_id" class="col-md-4 control-label">Email Id</label>

                            <div class="col-md-6">
                                <input id="email_id" type="text" value="{{$user->email}}" class="form-control" name="email_id" >
                            </div>
                        </div>
						
							<div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password"  class="form-control" name="password" >
                            </div>
                        </div>
                   </form><div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
							<br>
                                <button id="edit" class="btn btn-primary ">
                                    Edit
                                </button>
								
								<button id="update" class="btn btn-danger ">
                                    Update
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

<script>
  $(document).ready(function() {
	  
	//Disable all the input type except the edit and cancel button  
	  $(':input').attr("disabled",true);
	  $('#edit').attr("disabled",false);
	  $('#cancel').attr("disabled",false);
	  
	  
	//On click of edit button enable all input types 
	 $('#edit').click(function(){
		  $(":input").attr("disabled",false);
	});
			
	 $('#update').click(function(){
		 
		 var name =  $('#name').val();
		 var user_id =  $('#user_id').val();
		 var email =  $('#email_id').val();
		 var password =  $('#password').val();
		 
		 var department = new Array();
				$("input:checked").each(function() {
				   department.push($(this).val());
				});
		 

		
			 $.ajax({
			  type:'post',
			  
			  url : '{{URL::to('update_user')}}',
			  
			  data : {  'name':name,
						'user_id':user_id,
						'email':email,
						department:department,
						'_token': $('input[name=_token]').val(),
						'password':password  },
						
			  success:function(data){
				if(data)
				{console.log(data);}
			  }
		  }) 
	});		 
			
			

});

</script>
  
@endsection
