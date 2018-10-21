@extends('layouts.master')

@section('header')Tool Wise reports @endsection
@section('body')

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/toolwise_report">
                        {{ csrf_field() }}

                        <div class="form-group">
                        	<div class="col-md-8 col-md-offset-2">
							<h2><b>Tool Name:</b></h2>
                               <input  id="search_text" type="text" class="form-control" name="tool_name"  required>
                               <input id="selected_tool" type="hidden"  name="selected_tool" value="">
                            </div>
                            <div class="col-md-8 col-md-offset-2">
							<h2><b>Line Name:</b></h2>
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
                            <div class="col-md-4 col-md-offset-2">
							<h2><b>From Date:</b></h2>
                                <input id="from_date" placeholder="From Date" type="date" class="form-control" name="f_date"  required autofocus>
								</div>
							<div class="col-md-4">
							<h2><b>To Date:</b></h2>
                               <input  id="to_date" type="date" class="form-control" placeholder="To Date" name="t_date"  required>

                            </div>
							</div>
							
						<div class="form-group">
			<br><br><br><br><br><br>

							<div class="col-md-2 col-md-offset-4">
							<button id="generate" class="btn btn-primary btn-block" >Generate</button>
							</div>
							
							<div class="col-md-2">
							<button type="reset" id="reset" class="btn btn-danger btn-block" >Reset</button>
							</div>
								<br><br>
                        </div>
						<hr>
						
				<div class="w3-container">
					<div class="w3-responsive w3-card-4">
					<table class="w3-table w3-striped w3-bordered">
					</table>
					</div>
				</div>
											
						
                 </form>  
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

