@extends('layouts.master')


@section('header')Administrator's Home @endsection

@section('body')

<?php 

	use App\Wrkstation;
	
	$user_id = session('user_id');

	$dept = DB::select('SELECT department.department_name FROM department join users2dept where users2dept.user_id=:id AND department.id = users2dept.dept_id', ['id' => $user_id]);
	
		$i=1;

		$supervisors = DB::table('users')
			->join('users2dept', 'users.id', '=', 'users2dept.user_id')
			->where('user_type','3')
			->where('users2dept.dept_id',session('dept_id'))->count();
			
		$tools = DB::table('tools')->where('dept_id',session('dept_id'))->count();
		
		$wrk_stations = Wrkstation::where('dept_id',session('dept_id'))->count();
	  
	
	  
?>
		 
<div class="row top_tiles">  

        @foreach($dept as $dept)
              <div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="count">{{ $i}}</div>
                  <h3>{{ $dept->department_name }}</h3>
                </div>
              </div>
			<?php  $i++; ?>
          @endforeach
							
		
		
</div>
</div>
</div>

	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="bs-example" data-example-id="simple-jumbotron">
			<div class="jumbotron">
				<h1>{{ $supervisors }}</h1>
				<p>Supervisors</p>
			</div>
		</div>
	</div>
	
		<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="bs-example" data-example-id="simple-jumbotron">
			<div class="jumbotron">
				<h1>{{ $tools }}</h1>
				<p>Tools</p>
			</div>
		</div>
	</div>
	
		<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="bs-example" data-example-id="simple-jumbotron">
			<div class="jumbotron">
				<h1>{{ $wrk_stations }}</h1>
				<p>Workstations</p>
			</div>
		</div>
	</div>
  
         
		 
      
@endsection