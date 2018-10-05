@extends('layouts.master')

@section('header')Return Tools @endsection
@section('body')
            <div class="panel panel-default">

                <div class="panel-body">
				<br>
                    <form class="form-horizontal" method="POST" action="return_tool">
                        {{ csrf_field() }}

                     
						 <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Tool Name</label>
							<div class="col-md-6">
                           <input autocomplete="off" id="search_text" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
								<input id="selected_tool" type="hidden"  name="selected_tool" value="">
								</div>
                        </div>
						
							<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Quantity</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="tl_qty" type="text" class="form-control" name="tl_qty" >
                            </div>
                        </div>

                        	<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Shift Number</label>

                            <div class="col-md-6">
                                <input autocomplete="off"  id="sh_number" type="text" class="form-control" name="sh_number" >
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Workstation</label>

                            <div class="col-md-6">
							<?php 
								
								use App\Wrkstation;
								//list of workstations assigned to that department
									$wrk_station = Wrkstation::where('dept_id','=' ,session('dept_id'))->get();

								
							?>
                               <select  id="wrk_st"  class="form-control" name="wrk_st"  required>
                                <option selected="true" disabled="true">Select Workstation</option>
							   @foreach($wrk_station as $wk_sst)
							   <option value="{{$wk_sst->id}}">{{$wk_sst->name}}</option>
							   @endforeach
								</select>
                            </div>
                        </div>

						
						<div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Remarks</label>

                            <div class="col-md-6">
                                <textarea autocomplete="off" id="remark"  class="form-control" name="remark" ></textarea>
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
     $("#search_text").autocomplete({
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
					$('#search_text').prop('disabled', false);
						 $('#selected_tool').attr('value', ''); 
			});
			
			
			 $('#search_text').change(function()
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
						  
	  
			});
			

	});

</script>

  
@endsection
