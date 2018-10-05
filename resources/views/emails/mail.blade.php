<?php

 $tool_name = DB::table('tools')
			->where('id','=',$issue_tool->tool_id)
            ->value('name');
			

?>

<!DOCTYPE html>
<html>
<head>
	<title>Send Email</title>
</head>
<body>
	<h1><center><b>Rosenberger | Tool Management </b></center></h1>
	<hr>
	<h2>Please Re-order
	<ul>
  <li><b>{{ $tool_name }}&nbsp;</b>in {{ session('dept_name') }}</h2></li>
</ul>  
	

	</br>
	<h3>Reached Below Threshold on 
	{{ Carbon\Carbon::parse($issue_tool->issue_date)->toFormattedDateString() }} .
	</h3>
	</p>
</body>
</html>