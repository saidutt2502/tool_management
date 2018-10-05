@extends('layouts.master')

@section('header')Issue Tools @endsection
@section('body')
            <div class="panel panel-default">

                <div class="panel-body">
				<br>
                   

                     <form class="form-horizontal" method="POST" action="issue_tool">
                        {{ csrf_field() }}

                     
                         <div class="form-group">
                            <label for="sch_type" class="col-md-4 control-label">Tool Name</label>
                            <div class="col-md-6">
                           <input autocomplete="off" id="search_text1" type="text" class="form-control" name="name" value="{{$toolname}}" disabled>
                                <input  type="hidden"  name="selected_tool" value="{{$toolid}}">
                                </div>
                        </div>
                        
                            <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Tool Quantity</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="tl_qty" type="text" class="form-control" name="tl_qty"  value="{{$quantity}}" disabled >
                                <input  type="hidden"  name="selected_quantity" value="{{$quantity}}">
                            </div>
                        </div>

                            <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Shift Number</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="sh_number" type="text" class="form-control" name="sh_number"  value="{{$shift}}" disabled >
                                 <input  type="hidden"  name="selected_shnumber" value="{{$shift}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="start_date" class="col-md-4 control-label">Workstation</label>

                            <div class="col-md-6">
                                <input autocomplete="off" id="wrk_st" type="text" class="form-control" name="wrk_st"  value="{{$workstation}}" disabled >
                                 <input  type="hidden"  name="selected_wrkst" value="{{$workstationid}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
                            <br>
                                <button type="submit" class="btn btn-primary ">
                                    Issue
                                </button>
                                
                                <button type="reset" id="reset" class="btn btn-danger ">
                                    Reset
                                </button>
                            </div>
                        </div>
                   </form>


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
                $("#search_text").attr("disabled", true);
            }
        }
       
    })
	
	
			 $('#reset').click(function()
			{
					$('#search_text').prop('disabled', false);
						 $('#selected_tool').attr('value', ''); 
			});
			
			var available = 0;
			
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
								 available = data['available'];

							  }
						  })
						  
	  
			});
			
		
			 $('#tl_qty').change(function()
			{
				if($('#tl_qty').val() > available)
				{
					
					$('#quantity_modal').modal();
					$('#tl_qty').val('');
				}
			});

	});

</script>

<!-- Modal Tool quantity -->
  <div class="modal fade" data-modal-color="red" id="quantity_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Tool Quantity Unavailable !</center></h4>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
      </div>
      
    </div>
  </div>
  
@endsection
