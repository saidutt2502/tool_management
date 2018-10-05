@extends('layouts.master')

@section('header')Add Administrators @endsection
@section('body')
        <div class="col-md-13 ">
            <div class="panel panel-default">
               

                <div class="panel-body">
				<br>
                    <form class="form-horizontal" method="POST" action="/store_admin">
                        {{ csrf_field() }}
				<!--	hidden field to know user type -->
				
						
							<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Administrators ID</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="s_code" type="text" class="form-control" name="a_code" >
                            </div>
                        </div>

                       	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="name" type="text" class="form-control" name="name" >
                            </div>
                        </div>

                       
						 <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Departments</label>

                            <div class="col-md-6">
							 @foreach($dept as $each_dept)
							<div class="checkbox">
                            <label class="">
                              <div class="icheckbox_flat-green checked" style="position: relative;">
							  <input type="checkbox" name="dept[]" value="{{$each_dept->id}}" class="flat" style="position: absolute; opacity: 0;">
							  <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> {{$each_dept->department_name}}
                            </label>
                          </div>
								 @endforeach
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
                                <input autocomplete="off" id="password_register" type="password" class="form-control" name="password" >
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
								
								<button type="reset" class="btn btn-danger ">
                                    Reset
                                </button>
                            </div>
                        </div>
						</form>
                   
                </div>
            </div>
        </div>

  
@endsection
