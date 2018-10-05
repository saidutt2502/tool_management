@extends('layouts.master')


@section('header')Supervisor's Home @endsection

@section('body')

<?php 

	$user_id = session('user_id');

	$dept = DB::select('SELECT department.department_name FROM department join users2dept where users2dept.user_id=:id AND department.id = users2dept.dept_id', ['id' => $user_id]);
	
		$i=1;
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
@endsection