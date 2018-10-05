<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Session variables
use Session;

use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//Select only those supervisors who belong to the department logged into
         $user = DB::select('select users.id,users.email,users.name,users.emp_code from users2dept join users on users2dept.user_id=users.id where users.user_type=3 and users2dept.dept_id=:id',['id' => session('dept_id')]);

		return view('admin.view_supervisor')->withSupervisor($user);
	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		

       return view('admin.add_supervisor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		//Send the list of Departments which the admin has access to
		 $dept = DB::select('select department_name,department.id from department join users2dept on users2dept.dept_id=department.id where user_id=:id',['id' => session('user_id')]);
		 
		 
		 
         $user = User::find($id);
		 
		 //Send the list of Departments which the Supervisor is assisgned to	 
		 $dept_supervisor = DB::table('department')
            ->join('users2dept', 'department.id', '=', 'users2dept.dept_id')
			->where('user_id','=',$id)
			->select('department.id')
            ->get();
		 
      //  return view('admin.each_supervisor')->withUser($user)->withDept($dept)->withSupdept($dept_supervisor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
	
	 public function update_password(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('user_id','');
           $password = $request->get('password','');
		   
            $user=User::find($user_id);
			
			$user->password = bcrypt($password) ;
			$user->save();
			
                return $data=1;
                
        }
	}
    
}
