@extends('layouts.master')

@section('header')Complete Return reports @endsection
@section('body')

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/return_sadmin">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-4 ">
							<h2><b>From Date:</b></h2>
                                <input id="from_date" placeholder="From Date" type="date" class="form-control" name="f_date" >
								</div>
							<div class="col-md-4">
							<h2><b>To Date:</b></h2>
                               <input  id="to_date" type="date" class="form-control" placeholder="To Date" name="t_date" >

                            </div>
							
							<div class="col-md-4">
							<h2><b>Department:</b></h2>
							<?php   $dept_all = DB::select('select * from department'); ?>
                               <select class="form-control" name = dept id = dept>
							    <option  value = 'null'>---------------- All Departments ----------------</option>
							   @foreach($dept_all as $each_dept)
							   <option  value = "{{$each_dept->id}}">{{$each_dept->department_name}}</option>
							   @endforeach
							   </select>

                            </div>
							
							</form>
						<div class="form-group">
			<br><br><br><br><br><br>

							<div class="col-md-2 col-md-offset-4">
							<button id="generate" class="btn btn-primary btn-block" >Generate</button>
							</div>
							
							<div class="col-md-2">
							<button type="reset" id="reset" class="btn btn-danger btn-block" >Reset</button>
							</div>
								<br><br>
                        </div>
						<hr>
						
				<div class="w3-container">
					<div class="w3-responsive w3-card-4">
					<table class="w3-table w3-striped w3-bordered">
					</table>
					</div>
				</div>
											
						
                   
                </div>

@endsection

