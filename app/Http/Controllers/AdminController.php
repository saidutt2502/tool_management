<?php

namespace App\Http\Controllers;

//Models to be used
use App\Tool;
use App\User;
use App\Return_tool;
use App\Issue_tool;
use App\Wrkstation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Session variables
use Session;


//Using carbon date
use Carbon\Carbon;

class AdminController extends Controller
{
	
	 public function add_supervisor(Request $request)
    {
		//checking if the entered User details already exits (email and EMP code)
		if ($request->emp_code){

					
		$id = User::where('emp_code', '=',$request->emp_code)->value('id');			
					
		//if User exists just add him to users2dept table
				DB::table('users2dept')->insert(
					[	'user_id'  => $id,
						'added_by'    => session('user_id'),
						'dept_id'    => session('dept_id'), 
						'added_on'    => Carbon::now() ]
				);
				
				return redirect()->action('UserController@index');
				
			}
			
			
		else{
		
			$user = new User;

		//register Admins
			
				$user->name=$request->name;
				$user->emp_code=$request->s_code;
				$user->email=$request->email_id;
				$user->password=bcrypt($request->password_supervisor);
				$user->user_type=3;
				
				$user->save(); 
				
			//Get last user inserted ID
				$id=$user->id;
			

					
					DB::table('users2dept')->insert(
						[	'user_id'  => $id,
							'added_by'    => session('user_id'),
							'dept_id'    => session('dept_id'), 
							'added_on'    => Carbon::now() ]
					);

					
					
				DB::table('user_details')->insert(
						[	'user_id' => $id, 
							'contact_number' => $request->number,
							'address' => $request->address,
							'created_by' => session('user_id'),
							'last_login' => Carbon::now() ]
					);
					
					return redirect()->action('UserController@index');

		}
    }
    
	
	public function issue_report(Request $request)
    {
	/* 	$issues = Issue_tool::where('issue_date','>', $request->f_date)
			   ->where('issue_date','<', $request->t_date)
			   ->where('dept_id','=',session('dept_id'))
               ->orderBy('issue_date', 'desc')
               ->get(); */
			   
	 	$issues = Issue_tool::select('issues.id', 'users.name as user_name', 'tools.name as tool_name','issues.tool_qty','issues.shift_id', 							'workstations.name as wk_name','issues.issue_date as date') 
				->join('users', 'users.id', '=', 'issues.user_id')
				->join('tools', 'tools.id', '=', 'issues.tool_id')
				->join('department', 'department.id', '=', 'issues.dept_id')
				->join('workstations', 'workstations.id', '=', 'issues.wrk_station_id')
				->where('issues.dept_id','=',session('dept_id'))
				->whereBetween('issue_date', [$request->f_date,$request->t_date])
				->orderBy('date', 'desc')
				->get();
			   
		return view('admin.generated_issue')->withIssue($issues); 
		
    }
	
	public function return_report(Request $request)
    {
		$returns = Return_tool::select('returns.id', 'users.name as user_name', 'tools.name as tool_name','returns.tool_qty','returns.shift_id', 							'workstations.name as wk_name','returns.return_date as date','returns.remarks as remarks') 
				->join('users', 'users.id', '=', 'returns.user_id')
				->join('tools', 'tools.id', '=', 'returns.tool_id')
				->join('department', 'department.id', '=', 'returns.dept_id')
				->join('workstations', 'workstations.id', '=', 'returns.wrk_station_id')
				->where('returns.dept_id','=',session('dept_id'))
				->whereBetween('return_date', [$request->f_date,$request->t_date])
				->orderBy('date', 'desc')
				->get();
			   
		return view('admin.generated_return')->withReturn($returns); 
		
    }
	
	public function wrk_station()
    {
		$wrkstation = Wrkstation::select('workstations.id as id','workstations.name as name','users.name as user_name')
				->join('users', 'users.id', '=', 'workstations.added_by')
				->where('workstations.dept_id','=',session('dept_id'))
				->get();
			   
		return view('admin.wrk_station')->withStation($wrkstation); 
		
    }
	
	public function list_admins()
    {
		$admins = User::select('users.emp_code as emp_code','users.name as name','users.email as email','user_details.contact_number as number','user_details.last_login as login')
				->join('user_details', 'user_details.user_id', '=', 'users.id')
				->join('users2dept', 'users2dept.user_id', '=', 'users.id')
				->where('users.user_type','2')
				->where('users2dept.dept_id',session('dept_id'))
				->get(); 
		return view('admin.view_admins')->withAdmin($admins); 
		
    }
	
	public function stock_history()
    {
		$dept_stocks = DB::table('stocks')->select('tools.tool_code as code','tools.name as name','department.department_name as dept_name','users.name as user_name','stocks.quantity as quantity','stocks.added_on as added_on')
				->join('users', 'users.id', '=', 'stocks.user_id')
				->join('department', 'department.id', '=', 'stocks.dept_id')
				->join('tools', 'tools.id', '=', 'stocks.tool_id')
				->where('department.id',session('dept_id'))
				->get(); 
		return view('admin.stock_history')->withStock($dept_stocks); 
		
    }

	
}
