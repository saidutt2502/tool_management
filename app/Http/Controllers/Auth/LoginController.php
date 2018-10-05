<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;

use Session;

use Carbon\Carbon;

use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
     protected function authenticated($request, $user)
    {
		$user = Auth::user();
		$user_id=$user->id;
		$dept=$request->dept;
		
	//check if user is superadmin	
		if($user->user_type === 1) {
			session(['user_id' => $user_id]);
			session(['dept_id' => '-1']);	
			return redirect()->intended('/superadmin');
		}
		
		DB::table('user_details')
				 ->where('user_id', $user_id)
				 ->update(['last_login' => Carbon::now()]);
				
		
		 $check_dept = DB::table('users2dept')
			->where('user_id','=',$user_id)
			->where('dept_id','=',$dept)
            ->first();
		
			
		if(($check_dept))
		{
				//Getting the Department name the user logged in as
					$dept_name1=DB::table('department')
						  ->where('id', '=', $dept)
						  ->first();
						  
					$dept_name=$dept_name1->department_name;


				
			//if user is admin
			   if($user->user_type === 2) {
					 session(['user_id' => $user_id]);	
					 session(['dept_id' => $dept]);	
					 session(['dept_name' => $dept_name]);	
					 
					return redirect()->intended('/admin_home');
				}

			//if user is supervisor
			   else if($user->user_type === 3) {
					session(['user_id' => $user_id]);
					session(['dept_id' => $dept]);	
					session(['dept_name' => $dept_name]);			
					return redirect()->intended('/sup_home');
				}
			
		}
		
		else
		{
				Auth::logout();	
				return view('errors.no_access');
		}
		
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
