@extends('layouts.master')

@section('header')Add Supervisors @endsection
@section('body')
        <div class="col-md-13 ">
            <div class="panel panel-default">
               

                <div class="panel-body">
                <br>
                    <form class="form-horizontal" method="POST" action="/add_supervisor">
                        {{ csrf_field() }}
                        
                            <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Supervisor ID</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="s_code" type="text" class="form-control" name="s_code" id="s_code">
                                <input id="emp_code" type="hidden" name="emp_code" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="name" type="text" class="form-control" name="name" >
                            </div>
                        </div>

                       
                         <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
                                <input  type="text" disabled class="form-control"value="{{session('dept_name')}}" >
                            </div>
                        </div>
                              
                   
                        
                            <div class="form-group">
                            <label for="email_id" class="col-md-4 control-label">Email Id</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="email_id" type="text" class="form-control" name="email_id" >
                            </div>
                        </div>
                        
                            <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="password_supervisor" type="text" class="form-control" name="password_supervisor" >
                            </div>
                        </div>
                        
                            <!-- <div class="form-group">
                            <label for="number" class="col-md-4 control-label">Contact Number</label>

                            <div class="col-md-6">
                                <input id="number" type="text" class="form-control" name="number" >
                            </div>
                        </div>
                        
                            <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" >
                            </div>
                        </div> -->


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
                            <br>
                                <button type="submit" class="btn btn-primary ">
                                    Register
                                </button>
                                
                                <button type="reset" id="reset" class="btn btn-danger ">
                                    Reset
                                </button>
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>
        
        
<script>
 $(document).ready(function() {
     
     $("#s_code").change(function(){
            $.ajax({
                type:'get',
                url : '{{URL::to('user_find')}}',
                data: {
                    term : $("#s_code").val(),
                },
                success: function(data) {
                    if(data){
                        $('#name').val(data['name']);  
                        $('#email_id').val(data['email']);
                        $('#password_supervisor').val('************');
                        
                        //setting hidden variable value
                        $('#emp_code').val($("#s_code").val());
                        
                        $('#s_code').prop('disabled', true);
                        $('#name').prop('disabled', true);
                        $('#email_id').prop('disabled', true);
                        $('#password_supervisor').prop('disabled', true);
                        
                    }               
                }
            });
        
    
    });
    
    
             $('#reset').click(function()
            {
                    $('#s_code').prop('disabled', false);
                        $('#name').prop('disabled', false);
                        $('#email_id').prop('disabled', false);
                        $('#password_supervisor').prop('disabled', false);
            });

            
});
</script>
  
@endsection
