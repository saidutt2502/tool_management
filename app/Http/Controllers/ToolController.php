<?php

namespace App\Http\Controllers;

//Models to be used
use App\Tool;
use App\User;
use App\Return_tool;
use App\Issue_tool;
use App\Wrkstation;
use App\Intimation;
use App\Mail\BelowLimitTool;
use App\Mail\Breakdown;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



//Session variables
use Session;

//Using carbon date
use Carbon\Carbon;




class ToolController extends Controller
{
	
	
		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Select only those Tools who belong to the department logged into
         $tool_dept = DB::select('select * from tools where dept_id=:id',['id' => session('dept_id')]);

		return view('admin.view_tool')->withTool($tool_dept);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	
				return view('tool.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

            $tool = new Tool;

			$tool->name=$request->name;
			$tool->tool_code=$request->code;
            $tool->dept_id=session('dept_id');
            $tool->tool_limit=$request->tool_limit;
            $tool->tool_location=$request->tool_location;
            $tool->added_by=session('user_id');
			$tool->available=$request->available;
			
			$tool->save();
			$tool_id=$tool->id;
			
			DB::table('stocks')->insert(
				[	'user_id' => session('user_id'), 
					'tool_id' => $tool_id,
					'dept_id' => session('dept_id'),
					'quantity' => $request->available,
					'added_on' => Carbon::now() ]
			);
			
			return redirect()->action('ToolController@index');
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tool $tool)
    {
        //
    }
	
	public function return_tool(Request $request)
    {

		
		$user = Auth::user();
		$user_type = $user->user_type;
		$selected_tool = array();


		//Running for loop to get IDs of all the Tools
		foreach($request->name as $each_tool){
			$tools=Tool::where('name',$each_tool)->first();
			$tools->id;
			array_push($selected_tool,$tools->id);
		}

		//Inserting the tool's in returns tables
		foreach($selected_tool as $key => $value){

			$entry_id = DB::table('returns')->insertGetId(
				[ 'user_id' => session('user_id'), 'tool_id' => $value, 'dept_id' => session('dept_id'), 'tool_qty' => $request->tl_qty[$key], 'shift_id' => $request->sh_number, 'wrk_station_id' => $request->wrk_st, 'line_id' => $request->line, 'product_id' => $request->product, 'remarks' => $request->remark, 'return_date' => Carbon::today() ]);
					
				
				$first_time=Issue_tool::where('tool_id',$value)->count();
				
				if($first_time=='0'){
						 DB::table('returns')->where('id',$entry_id)->delete();
					}

		}
 
		$workstations=Wrkstation::where('id','=',$request->wrk_st)->first();
		$lines=DB::table('lines')->where('id','=',$request->line)->first();
		$products=DB::table('products')->where('id','=',$request->product)->first();

		if($request->product=='0')
		{
			if($request->line=='0')
		{
			return view('supervisor.issue_tool')->withToolname($request->name)->withQuantity($request->tl_qty)->withShift($request->sh_number)->withWorkstation($workstations->name)->withToolid($selected_tool)->withWorkstationid($request->wrk_st)->withLine('No Line')->withLineid('0')->withProduct('No Product')->withProductid('0');
		}
	    else
	    {
	    	return view('supervisor.issue_tool')->withToolname($request->name)->withQuantity($request->tl_qty)->withShift($request->sh_number)->withWorkstation($workstations->name)->withToolid($selected_tool)->withWorkstationid($request->wrk_st)->withLine($lines->name)->withLineid($request->line)->withProduct('No Product')->withProductid('0');
	    }
		}
		else
		{
			if($request->line=='0')
		{
			return view('supervisor.issue_tool')->withToolname($request->name)->withQuantity($request->tl_qty)->withShift($request->sh_number)->withWorkstation($workstations->name)->withToolid($selected_tool)->withWorkstationid($request->wrk_st)->withLine('No Line')->withLineid('0')->withProduct($products->name)->withProductid($request->product);
		}
	    else
	    {
	    	return view('supervisor.issue_tool')->withToolname($request->name)->withQuantity($request->tl_qty)->withShift($request->sh_number)->withWorkstation($workstations->name)->withToolid($selected_tool)->withWorkstationid($request->wrk_st)->withLine($lines->name)->withLineid($request->line)->withProduct($products->name)->withProductid($request->product);
	    }
		} 

		 
		
			
		
    }
	
	
	public function issue_tool(Request $request)
    {
		
		$user = Auth::user();
		$user_type = $user->user_type;
		
	  $issue_entry = new Issue_tool;
	  
	  $bill_ids = array();


		//Running loop for each selected Tools
		foreach($request->selected_tool  as $key => $value) {
			$id = DB::table('issues')->insertGetId(
			  [		'user_id' => session('user_id'),
					 'tool_id' => $value,
					 'dept_id' => session('dept_id'),
					 'tool_qty' => $request->tl_qty[$key],
					 'shift_id' => $request->selected_shnumber,
					 'wrk_station_id' => $request->selected_wrkst,
					 'line_id' => $request->selected_line,
					 'product_id' => $request->selected_product,
					 'issue_date' => Carbon::today(),
					  
			  ]
		  );

		  array_push($bill_ids,$id);

				$tool_issued = Tool::find($value);
				$tool_issued->available -=  $request->tl_qty[$key];
				$tool_issued->save();


				$tool_mail = Tool::find($value);
		
				if($tool_mail->available < $tool_mail->tool_limit ){

					$email_details = Issue_tool::find($id);
					
					$email_user = User::select('users.email as email')
						->where('user_type','=','2') 
						->join('users2dept', 'users2dept.user_id', '=', 'users.id')
						->where('users2dept.dept_id','=',session('dept_id'))
						->get();	
							foreach($email_user as $current_user)
							{
									$email =$current_user->email;
									\Mail::to($email)->queue(new BelowLimitTool($email_details));
							}
					
				}	


		}
	  
		
		if($request->selected_product=='0')
		{
			if($request->selected_line=='0')
		{
			$issue_bill = Issue_tool::select('users.name as user_name','users.emp_code as code',  'user_details.contact_number as number','tools.name as tool_name','tools.tool_code as tool_code','workstations.name as wrk_station_name','issues.id as id','issues.tool_qty as qty','issues.shift_id as shift_id','issues.issue_date as date','issues.line_id as line_id','issues.product_id as product_id') 
			->join('users', 'users.id', '=', 'issues.user_id')
			->join('user_details', 'user_details.user_id', '=', 'issues.user_id')
			->join('tools', 'tools.id', '=', 'issues.tool_id')
			->join('workstations', 'workstations.id', '=','issues.wrk_station_id')
			->whereIn('issues.id', $bill_ids)
			->get();
		}
	    else
	    {
	    	$issue_bill = Issue_tool::select('users.name as user_name','users.emp_code as code',  'user_details.contact_number as number','tools.name as tool_name','tools.tool_code as tool_code','workstations.name as wrk_station_name','issues.id as id','issues.tool_qty as qty','issues.shift_id as shift_id','issues.issue_date as date','lines.name as line_name','issues.line_id as line_id','issues.product_id as product_id') 
			->join('users', 'users.id', '=', 'issues.user_id')
			->join('user_details', 'user_details.user_id', '=', 'issues.user_id')
			->join('tools', 'tools.id', '=', 'issues.tool_id')
			->join('workstations', 'workstations.id', '=','issues.wrk_station_id')
			->join('lines', 'lines.id', '=','issues.line_id')
			->whereIn('issues.id',$bill_ids)
			->get();
	    }
		}
		else
		{
				if($request->selected_line=='0')
		{
			$issue_bill = Issue_tool::select('users.name as user_name','users.emp_code as code',  'user_details.contact_number as number','tools.name as tool_name','tools.tool_code as tool_code','workstations.name as wrk_station_name','issues.id as id','issues.tool_qty as qty','issues.shift_id as shift_id','issues.issue_date as date','issues.line_id as line_id','issues.product_id as product_id','products.name as product_name') 
			->join('users', 'users.id', '=', 'issues.user_id')
			->join('user_details', 'user_details.user_id', '=', 'issues.user_id')
			->join('tools', 'tools.id', '=', 'issues.tool_id')
			->join('workstations', 'workstations.id', '=','issues.wrk_station_id')
			->join('products', 'products.id', '=','issues.product_id')
			->whereIn('issues.id',$bill_ids)
			->get();
		}
	    else
	    {
	    	$issue_bill = Issue_tool::select('users.name as user_name','users.emp_code as code',  'user_details.contact_number as number','tools.name as tool_name','tools.tool_code as tool_code','workstations.name as wrk_station_name','issues.id as id','issues.tool_qty as qty','issues.shift_id as shift_id','issues.issue_date as date','lines.name as line_name','issues.line_id as line_id','issues.product_id as product_id','products.name as product_name') 
			->join('users', 'users.id', '=', 'issues.user_id')
			->join('user_details', 'user_details.user_id', '=', 'issues.user_id')
			->join('tools', 'tools.id', '=', 'issues.tool_id')
			->join('workstations', 'workstations.id', '=','issues.wrk_station_id')
			->join('lines', 'lines.id', '=','issues.line_id')
			->join('products', 'products.id', '=','issues.product_id')
			->whereIn('issues.id', $bill_ids)
			->get();
	    }
		}
		
		
			return view('supervisor.issue_bill')->with('issue',$issue_bill);
			
		
		// $user = Auth::user();
		// $user_type = $user->user_type;
		
  //     $issue_entry = new Issue_tool;
	  
	 //  $issue_entry->user_id=session('user_id');
	 //  $issue_entry->tool_id=$request->selected_tool;
	 //  $issue_entry->dept_id=session('dept_id');
	 //  $issue_entry->tool_qty=$request->tl_qty;
	 //  $issue_entry->shift_id=$request->sh_number;
	 //  $issue_entry->wrk_station_id=$request->wrk_st;
	 //  $issue_entry->issue_date=Carbon::today();
	 //  $issue_entry->save();
	  
	 //  $id=$issue_entry->id;
	  
	 //  $email_details = Issue_tool::find($id);
		
		// $tool_issued = Tool::find($request->selected_tool);
		
		// $tool_issued->available -= $request->tl_qty;
		// $tool_issued->save();
		
		// $issue_bill = Issue_tool::select('users.name as user_name','users.emp_code as code',  'user_details.contact_number as number','tools.name as tool_name','tools.tool_code as tool_code','workstations.name as wrk_station_name','issues.id as id','issues.tool_qty as qty','issues.shift_id as shift_id,issues.issue_date as date') 
		// 	->join('users', 'users.id', '=', 'issues.user_id')
		// 	->join('user_details', 'user_details.user_id', '=', 'issues.user_id')
		// 	->join('tools', 'tools.id', '=', 'issues.tool_id')
		// 	->join('workstations', 'workstations.id', '=','issues.wrk_station_id')
		// 	->where('issues.id','=',$id)
		// 	->get();
			
		// $tool_mail = Tool::find($request->selected_tool);
		
		// if($tool_mail->available < $tool_mail->tool_limit ){
			
		// 	$email_user = User::select('users.email as email') 
		// 		->join('users2dept', 'users2dept.user_id', '=', 'users.id')
		// 		->where('users2dept.dept_id','=',session('dept_id'))
		// 		->get();	
		// 			foreach($email_user as $current_user)
		// 			{
		// 					$email =$current_user->email;
		// 					\Mail::to($email)->send(new BelowLimitTool($email_details));
		// 			}
			
		// }	

		
		// 	return view('supervisor.issue_bill')->with('issue',$issue_bill);
			
		
		
    }
	
	public function stock_tool()
    {
     
		$tool_supervisors = Tool::where('dept_id', session('dept_id'))->get();

		
		return view('supervisor.view_stock')->withTool($tool_supervisors);
		
    }

      public function delete_tools(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('term','');

            $user=Tool::find($user_id);
            $user->delete();
            $data=1;
            
        }
 
             return $data;
                
            
    }


     //Machine Breakdown Intimation

     public function view_intimations()
    {
        //Select only those Tools who belong to the department logged into
         // $intimation = DB::select('select * from intimations where dept_id=:id',['id' => session('dept_id')]);
         $intimation = DB::table('intimations')->where('added_by', session('user_id'))->whereIn('status',['Reported','Maintenance Complete'])->get();

		return view('intimation.view_intimations')->withIntimation($intimation);
    }

       public function store_intimations(Request $request)
    {

            $intimation = new Intimation;

			$intimation->machine_name=$request->machine_name;
			$intimation->dept_id=session('dept_id');
			$intimation->breakdown_time=$request->breakdown_time;
			$intimation->reporting_time=NOW();
			$intimation->nature=$request->nature;
            $intimation->added_by=session('user_id');
            $intimation->status='Reported';
			
			
			$intimation->save();


			$mailData = array(
							   'number'     => $request->machine_name,
							   'department'  => session('dept_id'),
							   'added_by'  => session('user_id'),
							   'type' => '1',
                 		 );
			


			if(session('dept_id')=='1'||session('dept_id')=='2'||session('dept_id')=='4'||session('dept_id')=='5'||session('dept_id')=='6'||session('dept_id')=='8'||session('dept_id')=='9'||session('dept_id')=='13'||session('dept_id')=='14')
			{
			$mail = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','9')
				->where('users.user_type','=','3')
				->get();

			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','9')
				->where('users.user_type','=','2')
				->get();	

				$count=0;
				$countt=0;
    	                foreach ($mail as $mails) {
    	    	        if($count=='0')
    	    	        {
    	    	          $string=$mails->email;
    	                  $count++;
    	                }
    	                else
    	                {
    	        	    $string=$string.','.$mails->email;
    	                }
    	                }

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	     else if(session('dept_id')=='3'||session('dept_id')=='7'||session('dept_id')=='10'||session('dept_id')=='11')
			{
			$mail = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','10')
				->where('users.user_type','=','3')
				->get();
			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','10')
				->where('users.user_type','=','2')
				->get();	

				$count=0;
				$countt=0;

    	                foreach ($mail as $mails) {
    	    	        if($count=='0')
    	    	        {
    	    	          $string=$mails->email;
    	                  $count++;
    	                }
    	                else
    	                {
    	        	    $string=$string.','.$mails->email;
    	                }
    	                }

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	               



							$recipients = explode(',', $string);
							$ccrecipients = explode(',', $stringg);
							\Mail::to($recipients)->cc($ccrecipients)->queue(new Breakdown($mailData));
		
			
			
			
			return redirect()->action('ToolController@view_intimations');
		
    }

     public function received_intimations()
    {
        //Select only those Tools who belong to the department logged into
         if(session('dept_id')=='9')
         {
         $intimation = DB::table('intimations')->where('status','Reported')->whereIn('dept_id',['1','2','4','5','6','8','9','13','14'])->get();
          }
          else if (session('dept_id')=='10')
         {
         $intimation = DB::table('intimations')->where('status','Reported')->whereIn('dept_id',['3','7','10','11'])->get();
         }

		return view('intimation.received_intimations')->withIntimation($intimation);
    }

     public function delete_intimations(Request $request)
    {
         if($request->ajax())
        {
           $intimation_id = $request->get('term','');
		   
		//find the user and delete entry from user2data table
            $intimation=Intimation::where('id',$intimation_id)->delete();
			
			
			$data=1;
			
        }
 
             return $data;
                
            
    }

     public function search_intimations(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('term','');
            $intimation=Intimation::find($query);
			
                return $intimation;
                
            }
    }

     public function update_intimations(Request $request)
    {
         if($request->ajax())
        {
           $intimation_id = $request->get('intimation_id','');
           $work_start = $request->get('work_start','');
           $machine_handover = $request->get('machine_handover','');
           $details = $request->get('details','');

           $intimation=Intimation::find($intimation_id);
           $breakdown_time=$intimation->breakdown_time;

           $time1 = date('Y-m-d H:i:s', strtotime("$machine_handover"));
           $time2 = date('Y-m-d H:i:s', strtotime("$breakdown_time"));

           $to_time = strtotime($time1);
           $from_time = strtotime($time2);
           $totalbreakdown=abs($to_time - $from_time) / 3600;
           
		   
            
			$intimation->work_start=$work_start;
			$intimation->machine_handover=$machine_handover;
			$intimation->details=$details;
			$intimation->totalbreakdown=$totalbreakdown;
			$intimation->attended_by=session('user_id');
			$intimation->status='Maintenance Complete';
			$intimation->save();


			$mailData = array(
							   'number'     => $intimation->machine_name,
							   'department'  => $intimation->dept_id,
							   'added_by'  => session('user_id'),
							   'type' => '2',
                 		 );


            
            if(session('dept_id')=='1'||session('dept_id')=='2'||session('dept_id')=='4'||session('dept_id')=='5'||session('dept_id')=='6'||session('dept_id')=='8'||session('dept_id')=='9'||session('dept_id')=='13'||session('dept_id')=='14')
			{
			

			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','9')
				->where('users.user_type','=','2')
				->get();	

				
				$countt=0;
    	                

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	     else if(session('dept_id')=='3'||session('dept_id')=='7'||session('dept_id')=='10'||session('dept_id')=='11')
			{
			
			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','10')
				->where('users.user_type','=','2')
				->get();	

				
				$countt=0;

    	                

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	               



							
			$ccrecipients = explode(',', $stringg);


			

             $email=User::where('id',$intimation->added_by)->value('email');
			 \Mail::to($email)->cc($ccrecipients)->queue(new Breakdown($mailData));
		
			
			
				
			$data=1;
			
        }
 
                return $data;
                
            
    }

     public function confirm_intimations(Request $request)
    {
         if($request->ajax())
        {
            $intimation_id = $request->get('intimation_id','');

            $intimation=Intimation::find($intimation_id);
            
			$intimation->status='Maintenance Confirmed';
			$intimation->save();


			$mailData = array(
							   'number'     => $intimation->machine_name,
							   'department'  => $intimation->dept_id,
							   'added_by'  => session('user_id'),
							   'type' => '3',
                 		 );


			if(session('dept_id')=='1'||session('dept_id')=='2'||session('dept_id')=='4'||session('dept_id')=='5'||session('dept_id')=='6'||session('dept_id')=='8'||session('dept_id')=='9'||session('dept_id')=='13'||session('dept_id')=='14')
			{
			

			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','9')
				->where('users.user_type','=','2')
				->get();	

				
				$countt=0;
    	                

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	     else if(session('dept_id')=='3'||session('dept_id')=='7'||session('dept_id')=='10'||session('dept_id')=='11')
			{
			
			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','10')
				->where('users.user_type','=','2')
				->get();	

				
				$countt=0;

    	                

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	               



							
			$ccrecipients = explode(',', $stringg);


			

             $email=User::where('id',$intimation->attended_by)->value('email');
			 \Mail::to($email)->cc($ccrecipients)->queue(new Breakdown($mailData));
			


			
		



			
			
				
			$data=1;
			
        }
 
                return $data;
                
            
    }

    public function received_intimationshod()
    {
    	$user=Auth::user();
    	

    	if($user->user_type=='2' && session('dept_id')=='9')
    	{
        $intimation = DB::table('intimations')->whereIn('status',['Maintenance Confirmed','HOD Verification','Complete'])->whereIn('dept_id',['1','2','4','5','6','8','9','13','14'])->get();
        }
        else if($user->user_type=='2' && session('dept_id')=='10')
    	{
        $intimation = DB::table('intimations')->whereIn('status',['Maintenance Confirmed','HOD Verification','Complete'])->whereIn('dept_id',['3','7','10','11'])->get();
        }
        else if($user->user_type=='3')
        {
          $intimation = DB::table('intimations')->whereIn('status',['Maintenance Confirmed','HOD Verification','Complete'])->where('attended_by',$user->id)->get();
        }
		return view('intimation.received_intimationshod')->withIntimation($intimation);
    }

       public function autoComplete1(Request $request) {
        $query = $request->get('term','');
		$id = $request->get('id','');
        $dept_id=Intimation::find($id);

        $tools=Tool::where('name','LIKE','%'.$query.'%')->where('dept_id','=',session('dept_id'))->get();

        $data=array();
        foreach ($tools as $tool) {
            $data[$tool->id]=array('value'=>$tool->name, 'id'=>$tool->id );
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'No Result Found','id'=>''];
    }


      public function sparesdetails_store(Request $request)
    {
      
      $idd=$request->idd;
      $intimation = Intimation::find($idd);


	  for($i=0;$i< count($request->name);$i++)
        {
            $tool=Tool::where('name',$request->name[$i])->where('dept_id',session('dept_id'))->first();
            $tool->available-=$request->quantity[$i];
            $tool->save();

            $issue_entry = new Issue_tool;
	        $issue_entry->user_id=session('user_id');
	        $issue_entry->tool_id=$tool->id;
	        $issue_entry->dept_id=session('dept_id');
	        $issue_entry->tool_qty=$request->quantity[$i];
	        $issue_entry->shift_id=$request->sh_number;
	        $issue_entry->wrk_station_id=$request->wrk_st;
	        $issue_entry->issue_date=Carbon::today();
	        $issue_entry->intimation_id=$idd;
	        $issue_entry->save();

	       
        }

         if($request->breakdown_hidden=='Wearout')
	        {
	        	DB::table('breakdowndetails')->insert([
                ['intimation_id' => $idd, 'cause' => 'Wearout']
                ]);
	        }
	        else
	        {
	        	 for($i=0;$i< count($request->reason);$i++)
               {
	        	DB::table('breakdowndetails')->insert([
                ['intimation_id' => $idd, 'cause' => $request->reason[$i], 'target' => $request->target[$i]]
                ]);
	           }
	        }

        $intimation->spare_filledby=session('user_id');
        $intimation->status='HOD Verification';
        $intimation->save();
			
			
			
			$mailData = array(
							   'number'     => $intimation->machine_name,
							   'department'  => $intimation->dept_id,
							   'added_by'  => session('user_id'),
							   'type' => '4',
                 		 );
			


		if(session('dept_id')=='1'||session('dept_id')=='2'||session('dept_id')=='4'||session('dept_id')=='5'||session('dept_id')=='6'||session('dept_id')=='8'||session('dept_id')=='9'||session('dept_id')=='13'||session('dept_id')=='14')
			{
			

			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','9')
				->where('users.user_type','=','2')
				->get();	

				
				$countt=0;
    	                

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	     else if(session('dept_id')=='3'||session('dept_id')=='7'||session('dept_id')=='10'||session('dept_id')=='11')
			{
			
			$tocc = User::join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users2dept.dept_id','=','10')
				->where('users.user_type','=','2')
				->get();	

				
				$countt=0;

    	                

    	                foreach ($tocc as $cc) {
    	    	        if($countt=='0')
    	    	        {
    	    	          $stringg=$cc->email;
    	                  $countt++;
    	                }
    	                else
    	                {
    	        	    $stringg=$stringg.','.$cc->email;
    	                }
    	                }

    	     }

    	               



							
			$ccrecipients = explode(',', $stringg);


			

            
			 \Mail::to($ccrecipients)->queue(new Breakdown($mailData));
			
			return redirect()->action('ToolController@received_intimationshod');
		
    }

    public function verification(Request $request)
    {
         if($request->ajax())
        {
            $intimation_id = $request->get('term','');

            $intimation=Intimation::find($intimation_id);
            
			$intimation->status='Complete';
			$intimation->save();
			
			
				
			$data=1;
			
        }
 
                return $data;
                
            
    }
    public function machine_details()
    {
       
    	

    	if(session('dept_id')=='9')
    	{
        $intimation = DB::table('machines')->whereIn('dept_id',['1','2','4','5','6','8','9','13','14'])->get();
        }
        else if (session('dept_id')=='10')
    	{
        $intimation = DB::table('intimations')->whereIn('dept_id',['3','7','10','11'])->get();
        }
       
		return view('machine.view_machines')->withIntimation($intimation);
    }
     public function machine_store(Request $request)
    {
      

           
			
			DB::table('machines')->insert(
				[	'name' => $request->name, 
					'number' => $request->number,
					'dept_id' => $request->department]
			);
			
			return redirect()->action('ToolController@machine_details');
		
    }

     public function machine_delete(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('term','');

            $user=DB::table('machines')->where('id',$user_id)->delete();
            $data=1;
            
        }
 
             return $data;
                
            
    }

   
	
	
	
	
}
