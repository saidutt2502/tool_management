<?php
$dept=DB::table('department')->where('id',$inputs['dept'])->value('department_name');
$user=DB::table('users')->where('id',$inputs['added_by'])->value('name');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Email</title>
</head>
<body>
	@if($inputs['type']=='1')
	<h1><center><b>MACHINE BREAKDOWN</b></center></h1>
	
	<h2>

 Machine Number: {{$inputs['number']}}<br>
 Department: {{ $dept }}<br>
 Reported By: {{ $user }}<br>

    @elseif($inputs['type']=='2')
    <h1><center><b>MACHINE MAINTENANCE</b></center></h1>
	
	<h2>

 Machine Number: {{$inputs['number']}}<br>
 Department: {{ $dept }}<br>
 Attended By: {{ $user }}<br>

 @elseif($inputs['type']=='3')
 <h1><center><b>MAINTENANCE CONFIRMATION</b></center></h1>
	
	<h2>

 Machine Number: {{$inputs['number']}}<br>
 Department: {{ $dept }}<br>
 Confirmed By: {{ $user }}<br>

   @else

   <h1><center><b>SPARES DETAILS</b></center></h1>
	
	<h2>

 Machine Number: {{$inputs['number']}}<br>
 Department: {{ $dept }}<br>
 Filled By: {{ $user }}<br>

 @endif
 

  
 
	

	
</body>
</html>