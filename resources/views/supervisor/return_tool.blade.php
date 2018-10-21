@extends('layouts.master')

@section('header')Return Tools @endsection
@section('body')
            <div class="panel panel-default">
                <br>
                <button type="button" class="btn btn-primary btn-md" style="float:right" id="add" >&nbsp&nbsp+&nbsp&nbsp</button><br>
                 
                <div class="panel-body">
				
                    <form class="form-horizontal" method="POST" action="return_tool">
                        {{ csrf_field() }}


            <div class="form-group" id="add_tool" >
              <div class="col-md-12" style="margin-bottom: -18px;">
                <div class="col-md-5">
                 <label for="sch_type" class="control-label">Tool Name*</label>
                            
                           <input autocomplete="off" type="text" class="search_text form-control" name="name[]" required autofocus>
                          <input id="selected_tool" type="hidden"  name="selected_tool" value="">
                    </div>

                     <div class="col-md-5">
                     <label for="start_date" class="control-label">Tool Quantity*</label>

                         
                                <input autocomplete="off" id="tl_qty" type="text" class="form-control" name="tl_qty[]" required><br> 
                   </div>
                 </div>
               </div>


                    <div class="form-group">
                        <div class="col-md-12" style="margin-bottom: -18px;">
                        
                        <div class="col-md-5">
                        
                            <label for="sch_type" class="control-label">Workstation*</label>

                            
                            <?php 
                                
                                use App\Wrkstation;
                                //list of workstations assigned to that department
                                    $wrk_station = Wrkstation::where('dept_id','=' ,session('dept_id'))->get();

                                
                            ?>
                               <select  id="wrk_st"  class="form-control" name="wrk_st"  required>
                               @foreach($wrk_station as $wk_sst)
                               <option value="{{$wk_sst->id}}">{{$wk_sst->name}}</option>
                               @endforeach
                                </select>
                            
                        </div>
                    

                        	 <div class="col-md-5">
                            <label for="start_date" class="control-label">Shift Number*</label>

                            
                                <input autocomplete="off"  id="sh_number" type="text" class="form-control" name="sh_number" required>
                            
                        </div>
                    </div>
                </div><br>
						
						

                        <div class="form-group">
                             <div class="col-md-12" style="margin-bottom: -18px;">
                                <div class="col-md-5">
                            <label for="sch_type" class="control-label">Line*</label>

                            
                            <?php 
                                
                                    $lines = DB::table('lines')->where('dept_id','=' ,session('dept_id'))->get();

                                
                            ?>
                               <select  id="wrk_st"  class="form-control" name="line" required>
                                <option value="0">No Line</option>
                               @foreach($lines as $line)
                               <option value="{{$line->id}}">{{$line->name}}</option>
                               @endforeach
                                </select>
                            </div>
                        
                            <div class="col-md-5">
                            <label for="sch_type" class=" control-label">Product*</label>

                           
                            <?php 
                                
                                    $products = DB::table('products')->where('dept_id','=' ,session('dept_id'))->get();

                                
                            ?>
                               <select  id="wrk_st"  class="form-control" name="product" required>
                                <option value="0">No Product</option>
                               @foreach($products as $product)
                               <option value="{{$product->id}}">{{$product->name}}</option>
                               @endforeach
                                </select>
                            </div>
                        </div>
                    </div><br>

						
						<div class="form-group">
                            <div class="col-md-12" style="margin-bottom: -18px;">
                            <div class="col-md-10">
                            <label for="start_date" class="control-label">Remarks</label>

                            
                                <textarea autocomplete="off" id="remark"  class="form-control" name="remark" ></textarea>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
							<br>
                                <button type="submit" class="btn btn-primary ">
                                    Return
                                </button>
								
								<button type="reset" id="reset" class="btn btn-danger ">
                                    Reset
                                </button>
                            </div>
                        </div>
                   
                </div>
            </div>
			
 <script>
   $(document).ready(function() {
    src = "{{ route('searchajax') }}";
     $(".search_text").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
					dept_id : {{ session('dept_id') }}
                },
                success: function(data) {
                    response(data);
					console.log(data);
                             
                }
            });
        },
        minLength: 1,

  
	change: function (event, ui) {
            if (ui.item == null || ui.item == undefined) {
                $("#search_text").val("");
                $("#search_text").attr("disabled", false);
            } else {
                $("#search_text").attr("disabled", false);
            }
        }
       
    })
	
	
			 $('#reset').click(function()
			{
					$('.search_text').prop('disabled', false);
			});
			
			
			/*  $('#search_text').change(function()
			{
					 $value =  $('#search_text').val();
					
					 $.ajax({
							  type:'get',
							  url : '{{URL::to('searchid')}}',
							  data: {
										term : $value
									},
							  success:function(data){
						//Setting the Hidden value to selected tool's ID
								$('input[name=selected_tool]').val(data['id']);
							  }
						  })
						  
	  
			}); */


$('#add').click(function(){



$('#add_tool').append('<div class="col-md-12 remove"><div class="col-md-5"><label for="sch_type" class="control-label">Tool Name*</label><input autocomplete="off"  type="text" class="search_text form-control" name="name[]" required autofocus><input id="selected_tool" type="hidden"  name="selected_tool" value=""></div><div class="col-md-5"><label for="start_date" class="control-label">Tool Quantity*</label><input autocomplete="off" id="tl_qty" type="text" class="form-control" name="tl_qty[]" required></div><div class="col-md-2"><br><button type="button" class="btn btn-sm btn-danger del_btn">-</button></div></div>');

 src = "{{ route('searchajax') }}";
     $(".search_text").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
					dept_id : {{ session('dept_id') }}
                },
                success: function(data) {
                    response(data);
					console.log(data);
                             
                }
            });
        },
        minLength: 1,

  
	change: function (event, ui) {
            if (ui.item == null || ui.item == undefined) {
                $("#search_text").val("");
                $("#search_text").attr("disabled", false);
            } else {
                $("#search_text").attr("disabled", false);
            }
        }
       
    })

$('.del_btn').click(function(){
$(this).parent().parent().remove();
});



    $('#reset').click(function()
{
   $(".remove").remove();
     

});



});
			

	});

</script>

  
@endsection
