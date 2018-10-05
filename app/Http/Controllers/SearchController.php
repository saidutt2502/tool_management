<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Tool;
use App\User;
use App\Wrkstation;

use Session;

use Carbon\Carbon;


class SearchController extends Controller
{


    
     public function id(Request $request)
    {
        if($request->ajax())
        {
           $query = $request->get('term','');
            $tools=Tool::where('name',$query)->first();
                 
           
            $data['id']=$tools->id;
            $data['available'] = $tools->available;
            
       

                return $data;
                
        }
    }
    
    
     public function search_supervisor(Request $request)
    {
        if($request->ajax())
        {
           $query = $request->get('term','');
            $supervisor=User::find($query);
            
            $phone = DB::table('user_details')->where('user_id', $supervisor->id)->value('contact_number');
            $supervisor['contact'] = $phone;
            
                return $supervisor;
                
            }
    }
    
     public function get_dept(Request $request)
    {
        if($request->ajax())
        {
           $query = $request->get('term','');
           
           //Send the list of Departments which the admin has access to
         $dept = DB::select('select department_name,department.id from department join users2dept on users2dept.dept_id=department.id where user_id=:id',['id' => session('user_id')]);
         
         //Send the list of Departments which the Supervisor is assisgned to     
         $dept_supervisor = DB::table('department')
            ->join('users2dept', 'department.id', '=', 'users2dept.dept_id')
            ->where('user_id','=',$query)
            ->select('department.department_name','department.id')
            ->get();
            
         
         $data=array();
         
         
         $data['admin_dept'] = $dept;
         $data['supervisor_dept'] = $dept_supervisor;
         
         
         return $data;
                
         }
    }
    
     public function update_user(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('user_id','');
           $name = $request->get('name','');
           $email = $request->get('email','');
           $code = $request->get('s_code','');
           $number = $request->get('number','');
           
            $user=User::find($user_id);
            $user->name=$name;
            $user->email=$email;
            $user->emp_code=$code;
            $user->save();
            
            
            DB::table('user_details')->where('user_id', $user_id)->update(['contact_number' => $number]);

                
            $data=1;
            
        }
 
                return $data;
                
            
    }
    
     public function delete_user(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('term','');
           
        //find the user and delete entry from user2data table
            $user=User::find($user_id);
            DB::table('users2dept')->where('user_id', '=', $user_id)
            ->where('dept_id', '=', session('dept_id'))->delete();
            
            $data=1;
            
        }
 
             return $data;
                
            
    }
    
    //Tools AJAX functions starts here
    
     public function search_tool(Request $request)
    {
        if($request->ajax())
        {
           $query = $request->get('term','');
            $tool=Tool::find($query);
            
                return $tool;
                
            }
    }
    
     public function update_tool(Request $request)
    {
         if($request->ajax())
        {
           $tool_id = $request->get('tool_id','');
           $name = $request->get('name','');
           $code = $request->get('t_code','');
           $limit = $request->get('limit','');
           $location = $request->get('location','');
           
            $tool=Tool::find($tool_id);
            $tool->name=$name;
            $tool->tool_code=$code;
            $tool->tool_limit=$limit;
            $tool->tool_location=$location;
            $tool->save();
                
            $data=1;
            
        }
 
                return $data;
                
            
    }
    
         public function update_stock(Request $request)
    {
         if($request->ajax())
        {
           $tool_id = $request->get('tool_id','');
           $quantity = $request->get('quantity','');

           
            $tool=Tool::find($tool_id);
            $tool->available+=$quantity;
            //make an entry that tool was stocked by who and when a
            $tool->save();
            
                DB::table('stocks')->insert(
                    [   'user_id' => session('user_id'), 
                        'tool_id' => $tool_id,
                        'dept_id' => session('dept_id'),
                        'quantity' =>  $quantity,
                        'added_on' => Carbon::now() ]
                );

                
                
            $data=$tool->available;
            
        }
 
                return $data;
                
            
    }
    
    
     public function delete_tool(Request $request)
    {
         if($request->ajax())
        {
           $user_id = $request->get('term','');

            $user=User::find($user_id);
            $user->delete();
            DB::table('user_details')->where('user_id', $user_id)->delete();
            DB::table('users2dept')->where('user_id', '=', $user_id)->delete();
            $data=1;
            
        }
 
             return $data;
                
            
    }
    



      public function autoComplete(Request $request) {
        $query = $request->get('term','');
        $dept = $request->get('dept_id','');
        
        $tools=Tool::where('name','LIKE','%'.$query.'%')
                        ->where('dept_id','=',$dept)->get();
        
        $data=array();
        foreach ($tools as $tool) {
            $data[$tool->id]=array('value'=>$tool->name, 'id'=>$tool->id );
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'No Result Found','id'=>''];
    }  
    
    public function search_tool_main(Request $request) 
    
    {
        $query = $request->get('term','');
        $dept = $request->get('dept_id','');
        
        $output="";
        
        $tools=Tool::where('name','LIKE','%'.$query.'%')
                        ->where('dept_id','=',$dept)->get();
        
        
            if($tools)
            {

                $output.='
                <thead>
                <tr>
               
                    <td><b>Tool Name</b></td>
                            
                            
                            <td><b>Tool Code</b></td>
                            
                            <td><b>Available</b></td>
                            <td>Tool Limit</td>
                            </tr>
                            </thead>
                            ';

                foreach ($tools as $key => $curr_client)
                 {

                    
                    $output.='<tbody>
                            <tr>'.
                            
                            '<td>'.$curr_client->name.'</td>'.
                            
                            
                            '<td>'.$curr_client->tool_code.'</td>'.
                            '<td>'.$curr_client->available.'</td>'.
                            
                            '<td>'.$curr_client->tool_limit.'</td>
                        </tr>
                        <tbody>';
                }
            

                return Response($output);
                
            }
    }
    
    
    
      public function add_wrkstation(Request $request) {
        $query = $request->get('term','');
        
        
       $wrkstation= new Wrkstation;
       
       $wrkstation->name = $query;
       $wrkstation->dept_id = session('dept_id');
       $wrkstation->added_by = session('user_id');
       
       $wrkstation->save();
       
       return $data = 1;
    }
    
      public function del_wrkstation(Request $request) {
        $query = $request->get('term','');

       $wrkstation= Wrkstation::find($query);
       $wrkstation->delete();
       
       return $data = 1;
    }

     public function user_find(Request $request)
    {
        if($request->ajax())
        {
           $query = $request->get('term','');
            $user=User::where('emp_code','=',$query)->first();
            
        }
        
        return $user; 
    }
    
        


}


