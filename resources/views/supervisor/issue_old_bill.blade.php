<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Issue Reciept</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
@foreach($issue as $this_bill)
<div style="margin:5% 40% 0% 33%;float:left; width:500px; box-shadow:0 0 3px #aaa; height:auto;color:#666;">
   <div style="width:100%; padding:10px; float:left; background:#1ca8dd; color:#fff; font-size:30px; text-align:center;">
	Issue Reciept
   </div>
    <div style="width:100%; padding:0px 0px;border-bottom:1px solid rgba(0,0,0,0.2);float:left;">
        <div style="width:30%; float:left;padding:10px;">
           
            <span style="font-size:14px;float:left; width:100%;">
			Employee Code :<b style = "font-size:15px;">{{$this_bill->code}}</b>
			
            </span>
			<span style="font-size:14px;float:left;width:150%;">
			Name :<b>{{$this_bill->user_name}}</b>
			</span>
			<span style="font-size:14px;float:left;width:150%;">
			Contact :<b>{{ $this_bill->number}}</b>
			</span>
        </div>
		
        <div style="width:40%; float:right;padding:">
            <span style="font-size:14px;float:right;  padding:10px; text-align:right;">
			<?php  $dt = Carbon::now(); ?>
                Date : <b>{{ $dt->toFormattedDateString() }}</b>
            </span>
			<span style="font-size:14px;float:right;  padding:10px; text-align:right;">
               Reciept : <b>{{ $this_bill->id }}</b>
            </span>
        </div>
    </div>
    


    
    
    <div style="width:100%; padding:0px; float:left;">
     
          <div style="width:100%;float:left;background:#efefef;">
            <span style="float:left; text-align:left;padding:10px;width:50%;color:#888;font-weight:600;">
            Decription
           </span>
      </div>
	  
      <div style="width:100%;float:left;">
            <span style="float:left; text-align:left;padding:10px;width:50%;color:#888;">
          Tool:   <b>{{$this_bill->tool_name}}</b>
        </span>
		
         <span style="font-weight:normal;float:left;padding:10px ;width:40%;color:#888;text-align:right;">
		
        </span>
      </div>
	   <div style="width:100%;float:left;">
            <span style="float:left; text-align:left;padding:10px;width:50%;color:#888;">
         Quantity:  <b>{{ $this_bill->qty }}</b> 
        </span>
         <span style="font-weight:normal;float:left;padding:10px ;width:40%;color:#888;text-align:right;">
		
        </span>
      </div>
	   <div style="width:100%;float:left;">
            <span style="float:left; text-align:left;padding:10px;width:50%;color:#888;">
          Workstation Name :  <b> {{$this_bill->wrk_station_name}}  </b>     
        </span>
         <span style="font-weight:normal;float:left;padding:10px ;width:40%;color:#888;text-align:right;">
		
        </span>
      </div>
	   <div style="width:100%;float:left;">
            <span style="float:left; text-align:left;padding:10px;width:50%;color:#888;">
           Shift Number : <b>{{$this_bill->shift_id}} </b>       
        </span>
         <span style="font-weight:normal;float:left;padding:10px ;width:40%;color:#888;text-align:right;">
		
        </span>
      </div>
	@endforeach  
	  	   <div style="width:100%;float:left; background:#fff;">
           
         <span style="font-weight:600;float:right;padding:10px 0px;width:40%;color:#666;text-align:center;">
           Issued
        </span>
      </div>

	  <div style="width:100%;float:left;background:#efefef;">
            <span style="float:left; text-align:left;padding:10px;width:50%;color:#888;font-weight:600;">
           <button class="btn-primary btn-lg" value="print">
           <button class="btn-primary btn-lg" value="Close">
           </span>
      </div>

    </div>
  </div>  

</body>
</html>
