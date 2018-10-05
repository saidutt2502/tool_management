
@extends('layouts.master')

@section('header')Add Tools @endsection
@section('body')
            <div class="panel panel-default">

                <div class="panel-body">
				<br>
                    <form class="form-horizontal" method="POST" action="/tool">
                        {{ csrf_field() }}
						
						 	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Code</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="code" type="text" class="form-control" name="code" >
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
                            <label for="start_date" class="col-md-4 control-label">Tool Quantity</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="tl_qty" type="text" class="form-control" name="available" >
                            </div>
                        </div>
						
						 <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Threshold</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="tl_qty" type="text" class="form-control" name="tool_limit" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Location</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="tl_location" type="text" class="form-control" name="tool_location" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
							<br>
                                <button type="submit" class="btn btn-primary ">
                                    Add
                                </button>
								
								<button type="reset" class="btn btn-danger ">
                                    Reset
                                </button>
                            </div>
                        </div>
                   
                </div>
            </div>

  
@endsection
