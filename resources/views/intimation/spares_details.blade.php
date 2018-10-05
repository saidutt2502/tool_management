@extends('layouts.master')

@section('header')Spares Details @endsection

@section('body')
 
<?php

use Illuminate\Support\Facades\Auth;
use App\Intimation;
$user = Auth::user();
$name=$user->name;
$user_id=$user->id;
$user_type=$user->type;

$id= $_GET['idd'];
$intimation=Intimation::find($id);

?>

                   
<style>

.modal { position: absolute; top: 100px; right: 0px; bottom: 0; left: 200px; z-index: 10040; overflow: auto; overflow-y: auto;}

#add {

position: absolute;
right: 40px;
top:60px;

}

#add1 {

position: absolute;
right: 30px;
top:60px;

}


</style>

  
      
                        

            <div class="panel panel-default">
             <br><br>  
            &nbsp&nbsp&nbsp&nbsp <a href="received_intimationshod"><img src="/images/back.png" height="50px" width="50px"></a>
            <button type="button" class="btn btn-primary btn-lg" id="add">&nbsp&nbsp+&nbsp&nbsp</button>
            <br><br>

            <div class="panel-body">

            <form class="form-horizontal" method="POST" action="sparesdetails_store">
            {{ csrf_field() }} 

            <div class="form-group">
            <div class="col-md-6">
            <input autocomplete="off" id="s"  type="hidden"  name="idd" value="<?php echo $_GET['idd']?>">
            </div>
            </div>
      
                      
            <div class="row">
            <div class="form-group" id="add_parts" >
            <div class="col-md-12" style="margin-bottom: -18px;">
            <div class="col-md-5">
            <label for="name" > Tool Name</label>
            <input autocomplete="off"  placeholder="Tool Name" type="text" class="form-control" id="iname" name="name[]" required autofocus>
            </div>

            <div class="col-md-5">
            <label for="quantity" >Quantity Used</label>
            <input autocomplete="off" placeholder="Quantity Used"  type="text" class="form-control" name="quantity[]"  required><br> 
            </div>
            </div>
            </div>
            </div>

            <br> 

            <div class="row">
            <div class="form-group">
            <div class="col-md-12" style="margin-bottom: -18px;">
            <div class="form-group">
            <div class="col-md-10">
            <label for="start_date">Shift Number</label>
            <input autocomplete="off" id="sh_number" type="text" class="form-control" name="sh_number" >
            </div>
            </div>
            <div class="form-group">
            <div class="col-md-10">
            <label for="sch_type">Workstation</label>
            <?php 
            use App\Wrkstation;
            $wrk_station = Wrkstation::where('dept_id','=' ,session('dept_id'))->get();
            ?>
            <select  id="wrk_st"  class="form-control" name="wrk_st"  required>
            <option selected="true" disabled="true" value=""  >Select Workstation</option>
            @foreach($wrk_station as $wk_sst)
            <option value="{{$wk_sst->id}}">{{$wk_sst->name}}</option>
            @endforeach
            </select>
            </div>
            </div>
            <br>
            <div class="col-md-10">
            <label for="code" >Cause of Breakdown</label>
            <select  id="breakdown"  class="form-control"   required>
            <option selected="true" disabled="true" value=""  >Select Cause of Breakdown</option>
            <option value="Wearout">Wearout</option>
            <option value="Other">Other</option>
            </select>
            <input type="hidden" id="breakdown_hidden" name="breakdown_hidden">
            </div>
            <div class="form-group" id="add_other" ></div>
            </div>

            <div class="form-group">
            <div class="col-md-6 col-md-offset-5">
            <br><br><br>
            <button type="submit" class="btn btn-primary ">Submit</button>
            <button type="reset" id="reset" class="btn btn-danger ">Reset</button>
            </div>
            </div>
            </div>
            </div>
            </form>
            </div>
            </div>
         








<script>
  $(document).ready(function() {
  var value={{$id}};
  src1 = "{{ route('searchajax_tool') }}";
  $("#iname").autocomplete({
       source: function(request, response) {
           $.ajax({
               url: src1,
               dataType: "json",
               data: {
                   term : request.term,
                   id:value
               },
               success: function(data) {
                console.log(data);
                   response(data);
                            
               }
           });
       },
       minLength: 1,

  change: function (event, ui) {
           if (ui.item == null || ui.item == undefined) {
               $("#iname").val("");
               $("#iname").attr("disabled", false);
           } else {
               $("#iname").attr("disabled", false);

           }
       }
      
   })





$('#add').click(function(){



$('#add_parts').append('<div class="col-md-12 remove"><div class="col-md-5"><br><input autocomplete="off"  placeholder="Tool Name" type="text" class="form-control iname" name="name[]" required ></div><div class="col-md-5"><br><input autocomplete="off"  type="text" class="form-control iquantity" name="quantity[]" placeholder="Quantity Used"  required></div><div class="col-md-2"><br><button type="button" class="btn btn-sm btn-danger del_btn">-</button></div></div>');

$('.del_btn').click(function(){
$(this).parent().parent().remove();
});



    $(".iname").autocomplete({
       source: function(request, response) {
           $.ajax({
               url: src1,
               dataType: "json",
               data: {
                   term : request.term,
                   id:value
               },
               success: function(data) {
                console.log(data);
                   response(data);
                            
               }
           });
       },
       minLength: 1,

 
change: function (event, ui) {
           if (ui.item == null || ui.item == undefined) {
               $(".iname").val("");
               $(".iname").attr("disabled", false);
           } else {
               $(".iname").attr("disabled", false);

           }
       }
      
   })

    $('#reset').click(function()
{
   $(".remove").remove();

     

});

});

$('#breakdown').change(function()
{
  $('#breakdown_hidden').val($('#breakdown').val());
  if($('#breakdown').val()=='Other')
  {
     $('#add_other').append('<div class="remove"><button type="button" class="btn btn-primary btn-lg" id="add1">&nbsp&nbsp+&nbsp&nbsp</button><div class="col-md-5"><br><br><label for="code" >Breakdown Reason</label><input autocomplete="off" type="text" class="form-control" name="reason[]" required ></div><div class="col-md-5"><br><br><label for="code" >Target Date</label><input autocomplete="off"  type="date" class="form-control" name="target[]" required></div><div class="form-group" id="add_other1" ></div></div>');

       $("#breakdown").attr("disabled", true);

            $('#reset').click(function()
      {
            $(".remove").remove();
            $("#breakdown").attr("disabled", false);
   
       });

            $('#add1').click(function(){



     $('#add_other1').append('<div class="remove"><div class="col-md-5"><br><input autocomplete="off" type="text" class="form-control" name="reason[]" required ></div><div class="col-md-5"><br><input autocomplete="off"  type="date" class="form-control" name="target[]" required></div><div class="col-md-2"><br><button type="button" class="btn btn-sm btn-danger del_btn">-</button></div></div>');

           $('.del_btn').click(function(){
           $(this).parent().parent().remove();
           });

       $('#reset').click(function()
   {
       $(".remove").remove();

    });

});

  }

});




});

 


</script>

  
@endsection
