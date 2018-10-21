<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('sup_return', function()
        {
            return View('supervisor.return_tool');
        });
        
Route::get('sup_issue', function()
        {
            return View('supervisor.issue_tool');
        });
        
Route::get('sup_home', function()
        {
            return View('supervisor.home_supervisor');
        });
        
Route::get('admin_home', function()
        {
            return View('admin.home_admin');
        });
Route::get('superadmin', function()
        {
            return View('super_admin.home_sadmin');
        });
        
Route::get('aboutus', function()
        {
            return View('errors.aboutus');
        });
        
//Custom Functions in Super Admin Controller
Route::get('create_admin', 'SadminController@create_admin');
Route::get('list_admin', 'SadminController@list_admin');
Route::post('store_admin', 'SadminController@store_admin');
Route::get('search_admin', 'SadminController@search_admin');
Route::get('get_all_dept', 'SadminController@get_all_dept');
Route::post('return_sadmin', 'SadminController@return_sadmin');
Route::post('issue_sadmin', 'SadminController@issue_sadmin');
Route::post('delete_admin', 'SadminController@delete_admin');
Route::get('department', 'SadminController@department');
Route::get('add_department', 'SadminController@add_department');
Route::get('del_dept', 'SadminController@del_dept');
Route::post('update_admin', 'SadminController@update_admin');
Route::get('tools_display/{id}','SadminController@list_tool');

Route::get('complete_return', function(){
    return View('super_admin.complete_return');
});

Route::get('complete_issue', function(){
    return View('super_admin.complete_issue');
});

        
//Custom functions in Tools Controller      
Route::post('return_tool', 'ToolController@return_tool');
Route::post('issue_tool', 'ToolController@issue_tool');
Route::post('delete_tools', 'ToolController@delete_tools');
Route::get('stock_tool', 'ToolController@stock_tool');

//Custom Functions in Admin Controller
Route::post('issue_report', 'AdminController@issue_report');
Route::post('return_report', 'AdminController@return_report');
Route::post('toolwise_report', 'AdminController@toolwise_report');
Route::get('wrk_station', 'AdminController@wrk_station');
Route::get('lines', 'AdminController@lines');
Route::get('products', 'AdminController@products');
Route::get('list_admins', 'AdminController@list_admins');
Route::get('stock_history', 'AdminController@stock_history');
Route::post('add_supervisor', 'AdminController@add_supervisor');

Route::get('issue_tool_report', function(){
    return View('admin.issue_report');
});

Route::get('return_tool_report', function(){
    return View('admin.return_report');
});

Route::get('tool_wise_report', function(){
    return View('admin.toolwise_report');
});
    
            
        
//controller Route list
Route::resource('tool', 'ToolController');
Route::resource('user', 'UserController');

//Ajax Route list
Route::get('searchajax',array('as'=>'searchajax','uses'=>'SearchController@autoComplete'));
Route::get('search_supervisor','SearchController@search_supervisor');
Route::get('user_find','SearchController@user_find');
Route::get('get_dept','SearchController@get_dept');

Route::get('searchdetails','SearchController@search_details');
Route::get('searchid','SearchController@id');

Route::post('update_user','SearchController@update_user');
Route::post('delete_user','SearchController@delete_user');

//Change Password
Route::post('update_password','UserController@update_password');

//AJAX calls 
Route::get('search_tool','SearchController@search_tool');
Route::get('search_tool_main','SearchController@search_tool_main');
Route::post('update_tool','SearchController@update_tool');
Route::post('delete_tool','SearchController@delete_tool');
Route::post('update_stock','SearchController@update_stock');
Route::get('add_wrkstation','SearchController@add_wrkstation');
Route::get('add_line','SearchController@add_line');
Route::get('add_product','SearchController@add_product');
Route::post('del_wrkstation','SearchController@del_wrkstation');
Route::post('del_line','SearchController@del_line');
Route::post('del_product','SearchController@del_product');

//Machine Breakdown Intimation

Route::get('view_intimations','ToolController@view_intimations');
Route::get('create_intimations', function(){
    return View('intimation.create_intimations');
});
Route::post('store_intimations','ToolController@store_intimations');
Route::get('received_intimations','ToolController@received_intimations');
Route::post('delete_intimations','ToolController@delete_intimations');
Route::get('search_intimations','ToolController@search_intimations');
Route::post('update_intimations','ToolController@update_intimations');
Route::post('confirm_intimations','ToolController@confirm_intimations');
Route::get('received_intimationshod','ToolController@received_intimationshod');
Route::get('spares_details', function(){
    return View('intimation.spares_details');
});
Route::get('searchajax_tool',array('as'=>'searchajax_tool','uses'=>'ToolController@autoComplete1'));
Route::post('sparesdetails_store','ToolController@sparesdetails_store');
Route::get('hod_verification', function(){
    return View('intimation.hod_verification');
});
Route::get('verification','ToolController@verification');
Route::get('machine_details','ToolController@machine_details');
Route::get('create_machine', function(){
    return View('machine.create');
});
Route::post('machine_store','ToolController@machine_store');
Route::post('machine_delete','ToolController@machine_delete');
