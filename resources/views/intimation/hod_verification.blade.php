<?php


use Illuminate\Support\Facades\Auth;
use App\Intimation;
$id= $_GET['idd'];
$intimation=Intimation::find($id);

$dept = DB::table('department')->where('id',$intimation->dept_id)->first();
$user = DB::table('users')->where('id',$intimation->attended_by)->first();
$detail = DB::table('breakdowndetails')->where('intimation_id',$intimation->id)->get();
$tool_details= DB::table('issues')->where('intimation_id',$intimation->id)->get();



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Breakdown Intimation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.checked {
    color: orange;
}
</style>


   
</head>
<body>

<div class="container">

<h2><center>&nbspBreakdown&nbspIntimation <br>
  @if($intimation->status!='Complete')
  <button onClick="window.print()" class="btn btn-primary btn-md hidden-print">&nbsp;&nbsp;&nbsp;&nbsp;Print&nbsp;&nbsp;&nbsp;&nbsp;</button>
  <button id="verify" class="btn btn-success btn-md hidden-print">&nbsp;&nbsp;&nbsp;&nbspVerify&nbsp;&nbsp;&nbsp;&nbsp;</button> 
  <button onClick='window.location.href="/received_intimationshod"' class="btn btn-danger btn-md hidden-print">&nbsp;&nbsp;&nbsp;&nbsp;Close&nbsp;&nbsp;&nbsp;&nbsp;</button>
  @else
  <button onClick="window.print()" class="btn btn-primary btn-md hidden-print">&nbsp;&nbsp;&nbsp;&nbsp;Print&nbsp;&nbsp;&nbsp;&nbsp;</button> 
  <button onClick='window.location.href="/received_intimationshod"' class="btn btn-danger btn-md hidden-print">&nbsp;&nbsp;&nbsp;&nbsp;Close&nbsp;&nbsp;&nbsp;&nbsp;</button> 
  @endif

  </center></h2><br>
  <hr>
  <h4>
  <p>Machine Number: <b>{{$intimation->machine_name}}</b></p>
  <p>Department: <b>{{$dept->department_name}}</b></p>                   
  <p>Attended By: <b>{{$user->name}}</b></p>
  <p>Breakdown Date & Time: <b>{{ date("d M y,h:i a",strtotime($intimation->breakdown_time)) }}</b></p>
  <p>Handover Date & Time: <b>{{ date("d M y,h:i a",strtotime($intimation->machine_handover)) }}</b></p> 
  <p>Total Breakdown Time: <b>{{$intimation->totalbreakdown}} hours</b></p></h4><br> 
  
  <center><h4>Details</h4></center>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Tool Name</th>
        <th>Quantity Used</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tool_details as $tdetails)
      <?php
         $tool= DB::table('tools')->where('id',$tdetails->tool_id)->first()
      ?>
      <tr>
        <td>{{$tool->name}}</td>
        <td>{{$tdetails->tool_qty}}</td>
      </tr>
      @endforeach
    </tbody>
</table>
  <hr>
 <table class="table table-bordered">
    <thead>
      <tr>
        <th>Cause of Breakdown</th>
        <th>Target Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($detail as $details)
      <tr>
        <td>{{$details->cause}}</td>
        <td>{{$details->target}}@if($details->target==NULL)--@endif</td>
      </tr>
      @endforeach
    </tbody>
</table>
  
</div>

<script>
$(document).ready(function() {
$("#verify").click(function(){
$("#delModal").modal();


        
     $("#confirm").click(function(){
      var value={{$id}};
      
     $.ajax({
                type:'get',
                url : '{{URL::to('verification')}}',
                data: {
                    term : value,
                  },
                success:function(data){
                console.log(data);
                window.location.href = "/received_intimationshod";
                
                }
              })
      });
    });


});
</script>

 <div class="modal fade" data-modal-color="green" id="delModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Verify Breakdown Intimation Form?</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" id="confirm" class="btn btn-link">Verify</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
            </div>
      </div>
      
    </div>
  </div>


</body>
</html>

