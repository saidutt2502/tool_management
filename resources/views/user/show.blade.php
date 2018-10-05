@extends('layouts.master')

@section('header')Supervisor's name @endsection
@section('body')
            <div class="panel panel-default">

                <div class="panel-body">
				<br>
                    <form class="form-horizontal" method="POST" action="/tool">
                        {{ csrf_field() }}
						
						 	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Code</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control" name="code" >
                            </div>
                        </div>

                       	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" >
                            </div>
                        </div>

                       
						<div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
							   @foreach ($dept as $dept) 
											
											<div class="radio">
                                                <label>
                                                    <input name="department" type="radio" value="{{ $dept->id }}">{{ $dept->department_name }}
                                                </label>
                                            </div>
											
									
								@endforeach
                            </div>
                        </div>
						
							<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Quantity</label>

                            <div class="col-md-6">
                                <input id="tl_qty" type="text" class="form-control" name="quantity" >
                            </div>
                        </div>
						
						 <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Threshold</label>

                            <div class="col-md-6">
                                <input id="tl_qty" type="text" class="form-control" name="tool_limit" >
                            </div>
                        </div>

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
                   
                </div>
            </div>

  
@endsection
