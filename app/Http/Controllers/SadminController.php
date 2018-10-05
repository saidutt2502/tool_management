<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Tool;
use App\Return_tool;
use App\Issue_tool;

//Session variables
use Session;

use Carbon\Carbon;


class SadminController extends Controller
{
	
	 public function list_admin()
    {
		//Select only those supervisors who belong to the department logged into
              $user = User::select('users.id as id','users.emp_code as code', 'users.name as user_name', 'users.email as email' , 'user_details.contact_number as number' ) 
				->join('user_details', 'user_details.user_id', '=', 'users.id')
				->where('users.user_type','=',2)
				->get();
			  

		return view('super_admin.view_admins')->withAdmin($user);
	
    } 
	
	
    public function create_admin()
    {
		//Send the list of Departments which the admin has access to
		 $dept = DB::select('select * from department');

       return view('super_admin.add_admins')->with('dept', $dept);
    }
	

	
	 public function store_admin(Request $request)
    {

        $user = new User;

	//register Admins
		
			$user->name=$request->name;
			$user->emp_code=$request->a_code;
            $user->email=$request->email_id;
            $user->password=bcrypt($request->password);
            $user->user_type=2;
			
            $user->save(); 
			
		//Get last user inserted ID
			$id=$user->id;
		
				$department = $request->dept;
				foreach($department as $each_dept)
				{
					 $dataSet[] = [
								'user_id'  => $id,
								'added_by'    => session('user_id'),
								'dept_id'    => $each_dept,
								'added_on'	=> Carbon::now()
							];
				}
				
				DB::table('users2dept')->insert($dataSet);

				
				
			DB::table('user_details')->insert(
					[	'user_id' => $id, 
						'contact_number' => $request->number,
						'address' => $request->address,
						'created_by' => session('user_id'),
						'last_login' => Carbon::now() ]
				); 

			return redirect()->action('SadminController@list_admin');
    }
	
	
	 public function search_admin(Request $request)
    {
        if($request->ajax())
        {
           $query = $request->get('term','');
            $admin=User::find($query);
			
			$phone = DB::table('user_details')->where('user_id', $query)->value('contact_number');
			$admin['contact'] = $phone;
			
                return $admin;
                
            }
    }
	
	public function get_all_dept(Request $request)
    {
        if($request->ajax())
        {
			$query = $request->get('term','');
           // $admin=User::find($query);
           
          $dept_all = DB::select('select * from department');
		  
		  $dept_admin = DB::select('SELECT dept_id  FROM users2dept where user_id=:id ', ['id' => $query]);
		  
		  $data['all'] = $dept_all;
		  $data['admin'] = $dept_admin;
		
			return $data;
                
            }
    }
	
	public function issue_sadmin(Request $request)
    {
	$query = Issue_tool::query();
			
			$query = $query->select('issues.id', 'users.name as user_name', 'tools.name as tool_name','issues.tool_qty','issues.shift_id', 'workstations.name as wk_name','issues.issue_date as date','department.department_name as dept_name') 
				->join('users', 'users.id', '=', 'issues.user_id')
				->join('tools', 'tools.id', '=', 'issues.tool_id')
				->join('department', 'department.id', '=', 'issues.dept_id')
				->join('workstations', 'workstations.id', '=', 'issues.wrk_station_id');
				
			if(!($request->dept=='null'))
			{
				  $query = $query->where('issues.dept_id','=',$request->dept);
			}
			
			 if(isset($request->f_date))
			{
				$query = $query->where('issue_date', '>',$request->f_date);
			}
			
			 if(isset($request->t_date))
			{
				$query = $query->where('issue_date', '<',$request->t_date);
			}
			
			if(!isset($request->t_date) && !isset($request->f_date) && !isset($request->dept))
			{
				$query = $query->where('issues.id', '>','0');
			}
			
				$query = $query->orderBy('date', 'desc');
				$build_query = $query->get();
			   
		return view('super_admin.generated_issue_sadmin')->withIssue($build_query); 
		
    }
	
	public function return_sadmin(Request $request)
    {
	
		
		 	$query = Return_tool::query();
			
			$query = $query->select('returns.id', 'users.name as user_name', 'tools.name as tool_name','returns.tool_qty','returns.shift_id', 'workstations.name as wk_name','returns.return_date as date','returns.remarks as remarks','department.department_name as dept_name'); 
				$query = $query->join('users', 'users.id', '=', 'returns.user_id');
				$query = $query->join('tools', 'tools.id', '=', 'returns.tool_id');
				$query = $query->join('workstations', 'workstations.id', '=', 'returns.wrk_station_id');
				$query = $query->join('department', 'department.id', '=', 'returns.dept_id');
				
				
			if(!($request->dept=='null'))
			{
				  $query = $query->where('returns.dept_id','=',$request->dept);
			}
			
			 if(isset($request->f_date))
			{
				$query = $query->where('return_date', '>',$request->f_date);
			}
			
			 if(isset($request->t_date))
			{
				$query = $query->where('return_date', '<',$request->t_date);
			}
			
			if(!isset($request->t_date) && !isset($request->f_date) && !isset($request->dept))
			{
				$query = $query->where('returns.id', '>','0');
			}
			
			
			
				$query = $query->orderBy('date', 'desc');
			
		
				$build_query = $query->get();
				
				
			   
		return view('super_admin.generated_return_sadmin')->withReturn($build_query);  
		
    }
	
	 public function delete_admin(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('term','');
		   
		//find the user and delete entry from user2data table
            $user=User::find($user_id);
			$user->delete();
			
			DB::table('user_details')->where('user_id', $user_id)->delete();
			DB::table('users2dept')->where('user_id', '=', $user_id)->delete();
			
			$data=1;
			
        }
 
             return $data;
                
            
    }
	
	public function department()
    {
		   $dept_all = DB::select('select * from department');
			   
		return view('super_admin.dept')->withDept($dept_all); 
		
    }
	
	
	public function add_department(Request $request)
    {
		 if($request->ajax())
        {
           $dept_name = $request->get('term','');
		   DB::table('department')->insert(
					[	'department_name' => $dept_name	 ]
				);
				
				$data = 1;
		}   
		
		return $data;
		
    }	
	
	public function del_dept(Request $request)
    {
		 if($request->ajax())
        {
           $dept_id = $request->get('term','');
		   DB::table('department')->where('id', '=', $dept_id)->delete();
				
				$data = 1;
		}   
		
		return $data;
		
    }
	
	public function update_admin(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('user_id','');
           $name = $request->get('name','');
           $email = $request->get('email','');
           $code = $request->get('s_code','');
           $number = $request->get('number','');
           $dept = $request->get('dept','');
		   
            $user=User::find($user_id);
			$user->name=$name;
			$user->email=$email;
			$user->emp_code=$code;
			$user->save();
			
			
			DB::table('user_details')->where('user_id', $user_id)->update(['contact_number' => $number]);
			
			DB::table('users2dept')->where('user_id', $user_id)->delete();
			
		 	foreach($dept as $each_dept)
				{
					 $dataSet[] = [
								'user_id'  => $user_id,
								'added_by'    => session('user_id'),
								'dept_id'    => $each_dept,
								'added_on'	=> Carbon::now()
							];
				}
				
				DB::table('users2dept')->insert($dataSet); 

			$data=1;
			
        }
 
                return $data;
                
            
    }
	
	public function list_tool($id)
    {
		
		$tool =  Tool::where('dept_id', '=', $id)->get();	
		$dept_name = DB::table('department')->where('id', $id)->value('department_name');

		return view('super_admin.list_tools')->withTool($tool)->withDept($dept_name);
	
    }
	
	
	
	
}
