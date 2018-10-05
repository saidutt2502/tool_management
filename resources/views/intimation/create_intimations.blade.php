
@extends('layouts.master')

@section('header')Create Intimations @endsection
@section('body')
            <div class="panel panel-default">

                <div class="panel-body">
				<br>
                    <form class="form-horizontal" method="POST" action="/store_intimations">
                        {{ csrf_field() }}
						
						 	

                              <div class="form-group">
                    <?php 
                    $wrk_station=DB::table('machines')->where('dept_id',session('dept_id'))->get();
                    ?>

                     <label for="start_date" class="col-md-4 control-label">Machine Number</label>
                      <div class="col-md-6">
                               <select class="form-control chosen" name="machine_name">
                                <option selected="true" disabled="true" value=""  >Select Machine Number</option>
                            @foreach($wrk_station as $wk_sst)
                           <option value="{{$wk_sst->number}}">{{$wk_sst->number}}</option>
                           @endforeach
                    </select>
                    </div>
                          
                        </div>

                       	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Breakdown Date and Time</label>

                            <div class="col-md-6">
                                <input autocomplete="off"  type="datetime-local" class="form-control" name="breakdown_time" >
                            </div>
                        </div>

                       
						
						
							<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Nature of Breakdown</label>

                            <div class="col-md-6">
                                <textarea autocomplete="off"   class="form-control" name="nature" ></textarea>
                            </div>
                        </div>
						
						 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
							<br>
                                <button type="submit" class="btn btn-primary ">
                                    Submit
                                </button>
								
								<button type="reset" class="btn btn-danger ">
                                    Reset
                                </button>
                            </div>
                        </div>
                   
                </div>
            </div>

   <script type="text/javascript">
      $(".chosen").chosen();
</script>

  
@endsection
