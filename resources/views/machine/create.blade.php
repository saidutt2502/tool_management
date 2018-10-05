@extends('layouts.master')

@section('header')Create Machine @endsection
@section('body')
            <div class="panel panel-default">

                <div class="panel-body">
				<br>
                
                     <form class="form-horizontal" method="POST" action="machine_store">
                        {{ csrf_field() }}

                     
                         <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Machine Name</label>
                            <div class="col-md-6">
                           <input type="text" class="form-control" name="name" autofocus required>
                            </div>
                        </div>
                        
                           <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Machine Number</label>
                            <div class="col-md-6">
                           <input type="text" autocomplete="off" class="form-control" name="number" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
                            <?php 
                                
                                
                                //list of workstations assigned to that department
                                if(session('dept_id')=='9')
                                {
                                    $wrk_station = DB::table('department')->whereIn('id',['1','2','4','5','6','8','9','13','14'])->get();
                                }
                                else if (session('dept_id')=='10')
                                {
                                    $wrk_station = DB::table('department')->whereIn('id',['3','7','10','11'])->get();
                                }
                                
                            ?>
                               <select  id="wrk_st"  class="form-control" name="department"  required>
                                <option  selected="true" disabled="true">Select Department</option>
                               @foreach($wrk_station as $wk_sst)
                               <option value="{{$wk_sst->id}}">{{$wk_sst->department_name}}</option>
                               @endforeach
                                </select>
                            </div>
                        </div>

                           

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
                            <br>
                                <button type="submit" class="btn btn-primary ">
                                    Issue
                                </button>
                                
                                <button type="reset" id="reset" class="btn btn-danger ">
                                    Reset
                                </button>
                            </div>
                        </div>
                   </form>


                </div>
            </div>
			
 
  
@endsection
