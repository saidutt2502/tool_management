@extends('layouts.master')
<?php
	use Carbon\Carbon;
	$dt = Carbon::now();
?>
@section('header')Issued Bill @endsection
@section('body')
                  
@for($i=0;$i< 1;$i++)
<div id ="section-to-print" class = "col-md-6 col-md-offset-3">
	<div class="panel panel-default">
	<!-- Default panel contents -->
		<div class="panel-heading">
			<div class="row">
			<h2>
				<div class="col-md-8 col-md-offset-2">
					<center>Issue Reciept - {{ $dt->toFormattedDateString() }}</center>
				</div>   
			</div>
			</h2>
		</div>


	<div class="panel-body">
	<h4>
		<div class="row">
			<div class="col-md-8 col-md-offset-1">Name:&nbsp;&nbsp;<b>
			{{$issue[$i]->user_name}} </b>
			</div>    
		</div>
	<br>
		<div class="row">
			<div class="col-md-5 col-md-offset-1">
				Employee ID:&nbsp&nbsp<strong>{{$issue[$i]->code}}</strong>
			</div>            
			
			<div class="col-md-6">
				<span class="pull-right">&nbsp;&nbsp; <strong> {{ session('dept_name') }}</b>
				</strong> </span>
			</div> 
		</div>
	<hr></br>
	@foreach($issue as $this_issue)
	<div class="row">
		<div class="col-md-5 col-md-offset-1">
			Tool Name:&nbsp&nbsp<strong>{{$this_issue->tool_name}}</strong>
		</div>
		
		<div class="col-md-5">
			<span class="pull-right">Quantity:&nbsp&nbsp<strong>{{ $this_issue->qty }}</strong></span>
		</div> 
	</div></br>
	@endforeach
 
    <br>
 
	<div class="row">
		<div class="col-md-8 col-md-offset-1">
			Shift ID : {{ $issue[$i]->shift_id }}
		</div>
	</div>
	
	<br>

	<div class="row">
		<div class="col-md-8 col-md-offset-1">Workstation: {{ $issue[$i]->wrk_station_name }}</div>
	</div>

	<br>
    @if($issue[$i]->line_id==0)
    <div class="row">
		<div class="col-md-8 col-md-offset-1">Line: No Line</div>
	</div>
    @else
	<div class="row">
		<div class="col-md-8 col-md-offset-1">Line: {{ $issue[$i]->line_name }}</div>
	</div>
	@endif

	<br>
    @if($issue[$i]->product_id==0)
    <div class="row">
		<div class="col-md-8 col-md-offset-1">Product: No Product</div>
	</div>
    @else
	<div class="row">
		<div class="col-md-8 col-md-offset-1">Product: {{ $issue[$i]->product_name }}</div>
	</div>
	@endif
	

	
	

	<hr>
	<center>
		<button onClick="window.print()" class="btn btn-primary btn-md hidden-print">Print this page</button> 
	</center>
	
	</div>
	</h4>
		 @endfor
	</div>
</div>



<style>
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;

  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
		 
@endsection