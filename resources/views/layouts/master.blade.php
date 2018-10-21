<?php

use Illuminate\Support\Facades\Auth;
use App\User;
$user = Auth::user();

$name=$user->name;
$user_id=$user->id;
$user_type=$user->user_type;

$u2dc=DB::table('users2dept')->where('user_id', $user_id)->whereIn('dept_id',['9','10'])->count(); //copy this
$u2d=DB::table('users2dept')->where('user_id', $user_id)->whereIn('dept_id',['9','10'])->first();
if($u2dc!='0')
{
$m_sup=User::where('id',$u2d->user_id)->first();
}





?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rosenberger | Tool Management </title>
  
  
<!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
  
 <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
  
    <!-- jQuery custom loader -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
  
    <!-- Loader CSS -->
    <link href="/css/custom_css.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
    <!-- Custom Theme Style -->
    <link href="/build/css/custom.min.css" rel="stylesheet">
  
  <script>
//paste this code under the head tag or in a separate js file.
  // Wait for window load
  $(window).load(function() {
    // Animate loader off screen
    setTimeout(function() {
      $('.se-pre-con').fadeOut('fast');
    }, 500);
  });
</script> 

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md  footer_fixed">
    <div class="se-pre-con"></div>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
    @if($user_type==3)
      <a  href="/sup_home" class="site_title"><img src="/images/logo.jpg" height="70%" width="80%"></a>
    @elseif($user_type==2)
      <a href="/admin_home" class="site_title"><img src="/images/logo.jpg" height="70%" width="80%"></a>
    @elseif($user_type==1)
      <a  href="/superadmin" class="site_title"><img src="/images/logo.jpg" height="70%" width="80%"></a>
    @endif

        <hr>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
           <div class="profile clearfix">
              <div class="profile_pic">
           
              </div>
              <div style="padding-left:15px">
        <br><br>
                <b><font size="5" color="white">{{$name}}</b></font><br>
      <font size="4">@if(session('dept_name')){{ session('dept_name') }}@endif </font>
              </div>
            </div>
            <!-- /menu profile quick info -->


            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
        
      <!-- Display these Menu items for Super Admin -->
        
        @if($user_type==1)
        
                  <li><a><i class="fa fa-graduation-cap"></i> Manage Administrators <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/create_admin">Add Administrators</a></li>
                      <li><a href="/list_admin">View Administrators</a></li>
                    </ul>
                  </li>
           <li><a href="/department"><i class="fa fa-institution"></i> Manage Departments </a>
                  <li id="tools_li_s"><a><i class="fa fa-clone"></i>Reports <span class="fa fa-chevron-down"></span></a>
                    <ul  id="tools_ul_s" class="nav child_menu">
                      <li id="return_link_s"><a href="/complete_return">Complete Return Summary</a></li>
                      <li id="issue_link_s"><a href="/complete_issue">Complete Issue Summary</a></li>
                    </ul>
                  </li>
        @endif
      
      <!-- Display these Menu items for Admin -->
      @if($user_type==2)
         <li> 
          <div class="input-group">
            <input type="text" class="form-control" id="search_text_main" placeholder="Search Tool" name="search_tool">
            <div class="input-group-btn">
              <button class="btn btn-default" id="click_search" ><i class="glyphicon glyphicon-search"></i></button>
            </div>
          </div>
        </li>
        <li><a href="/list_admins"><i class="fa fa-home"></i> View Administrators </a>
                  </li>
                  <li><a><i class="fa fa-users"></i> Manage Supervisors <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/user/create">Add Supervisors</a></li>
                      <li><a href="/user">View Supervisors</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-wrench"></i> Manage Tools <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    <li><a href="/tool/create">Add Tools</a></li>
            <li><a href="/tool">View/Update Tools</a></li>
                      <!-- <li><a href="/sup_issue">Issue Tools</a></li> -->
                      <li><a href="/sup_return">Return Tools</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-exclamation"></i> Breakdown Intimation <span class="fa fa-chevron-down"></span></a> 
                    <!-- copy this -->
                    <ul class="nav child_menu">
                      <li><a href="/view_intimations">View/Make Intimations</a></li>
                      @if($u2dc!='0')
                      @if($m_sup->user_type=='2')
                      <li><a href="received_intimationshod">Spares Replaced</a></li>
                      <li><a href="machine_details">Machine Details</a></li>
                      @endif
                      @endif
                    </ul>
                  </li>
            <li><a href="wrk_station"><i class="fa fa-recycle"></i> Manage Workstations </a></li>
            <li><a href="lines"><i class="glyphicon glyphicon-film"></i> Manage Lines </a></li>
            <li><a href="products"><i class="glyphicon glyphicon-barcode"></i> Manage Products </a></li>
                  <li id="tools_li"><a><i class="fa fa-clone"></i>Tools Reports <span class="fa fa-chevron-down"></span></a>
                    <ul id="tools_ul" class="nav child_menu">
                      <li><a href="tool_wise_report">Tool Wise</a></li>
                      <li id="return_link"><a href="return_tool_report">Return</a></li>
                      <li id="issue_link"><a href="issue_tool_report">Issue</a></li>
            <li><a href="/stock_history">Stock History</a></li>
                    </ul>
                  </li>
        @endif
      
      <!-- Display these Menu items for Supervisor -->
      @if($user_type==3)

     <li> 
          <div class="input-group">
            <input type="text" class="form-control" id="search_text_main" placeholder="Search Tool" name="search_tool">
            <div class="input-group-btn">
              <button class="btn btn-default" id="click_search" ><i class="glyphicon glyphicon-search"></i></button>
            </div>
          </div>
        </li>
        <li><a href="/sup_return"><i class="fa fa-external-link-square"></i> Return Tool </a></li>
        <!-- <li><a href="/sup_issue"><i class="fa fa-gavel"></i> Issue Tool </a></li> -->
        <li><a href="/stock_tool"><i class="fa fa-area-chart"></i> View Stock</a></li>

        <li><a><i class="fa fa-exclamation"></i> Breakdown Intimation <span class="fa fa-chevron-down"></span></a> <!-- copy this -->
                    <ul class="nav child_menu">
                      <li><a href="/view_intimations">View/Make Intimations</a></li>
                      @if($u2dc!='0')
                      @if($m_sup->user_type=='3')
                      <li><a href="received_intimations">Received Intimations</a></li>
                       <li><a href="received_intimationshod">Spares Replaced</a></li>
                      @endif
                      @endif
                    </ul>
                  </li>

       

        @endif
        <li><a id="c_password" href="#"><i class="fa fa-lock"></i> Change Password</a></li>
        <li>   <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                           <i class="fa fa-power-off"></i>  Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form></li>
        
                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

           
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

            </nav>
          </div>
        </div>
        <!-- /top navigation -->


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
      
       <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
        
                  <div class="x_title">
                    <h2>@yield('header')</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
            @yield('body')
                    </div>
          
          </div>
        </div>
    </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right ">
            Developed for <b><font color="Black"> Rosenberger | India </font></b>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="/vendors/jquery/dist/jquery.min.js"></script>
  
  <!-- Live search -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
   
    <!-- Script for autocomplete search-->
    <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet"> 
    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
  
    <!-- iCheck -->
    <script src="/vendors/iCheck/icheck.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/vendors/nprogress/nprogress.js"></script>

   
    <!-- Datatables -->
    <script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="/vendors/jszip/dist/jszip.min.js"></script>
    <script src="/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="/vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
  

    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>
  
  <script>
  $(document).ready(function() {
    
    $('#error_msg').hide();
    $('#c_password').click(function() {
      $('#password_Modal').modal();
      
    });
    
    $('#submit_password').click(function(){

     var t_pass =  $('#password').val();
     var t_confirm =  $('#confirm_p').val();
     var t_user =  {{ session('user_id')}}

    if(t_pass == t_confirm){
      $('#error_msg').hide();
      
       $.ajax({
        type:'post',
        
        url : '{{URL::to('update_password')}}',
        
        data : {  'password':t_pass,
            'user_id':t_user,
            '_token': $('input[name=_token]').val()
                                },
            
        success:function(data){
          if(data){
            $('#password_Modal').modal('toggle');
            location.reload();
            }
          }
        })  
      }
      
      else
      {
        $('#error_msg').show();
        $('#password').val('');
        $('#confirm_p').val('');
        
      }
       
    });


  src = "{{ route('searchajax') }}";
     $("#search_text_main").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
          dept_id : {{ session('dept_id') }},
                },
                success: function(data) {
                    response(data);
                             
                }
            });
        },
        minLength: 1,
    
       
    })
      
  
  
  $("#click_search").click(function(){
    
            var value = $("#search_text_main").val();
          //AJAX call to fill tools details
           $.ajax({
                type:'get',
                url : '{{URL::to('search_tool_main')}}',
                data: {
                    term : value,
                    dept_id : {{ session('dept_id') }},
                  },
                success:function(data){
                    $('#table').html(data);
                }
              })  
                
      
        $("#tool_search_Modal").modal();
        
          
      });

  
  });
      
  </script>
  
  
  
     
   <!-- Modal Change Password-->
  <div class="modal fade" id="password_Modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
        </div>
    <hr>
        <div class="modal-body">
        <div class="row">
               
                  <div class="x_content">
                    <br />
          <div id='error_msg' class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error!</strong> Passwords do not match.
                </div>
                    
            <form class="form-horizontal"  >
                        {{ csrf_field() }}

              <div class="form-group">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_passsword" class="col-md-4 control-label">Confirm Password </label>

                            <div class="col-md-6">
                                <input id="confirm_p" type="password" class="form-control" name="c_password" >
                            </div>
                        </div>
        
    </form>
  </div>
    </div>
  </div>
  <hr>
   <div class="modal-footer">
         
                        <center>
                          <button type="button" data-dismiss="modal" class="btn  btn-default">Cancel</button>
                          <button type="submit" id="submit_password" class="btn btn-success">Update</button>
                       </center>

        </div>

  </div>
  </div>
  </div>
  
  
  
  
  
  <!-- Modal Update password Successfull -->
  <div class="modal fade" data-modal-color="green" id="success_password_Modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>Password Update Succesfull !</center></h4>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal View Tool-->
  <div class="modal fade" id="tool_search_Modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
         <table id="table" class="table table-striped table-bordered">
                    </table>
        </div>
   <div class="modal-footer">
         
                        <center>
                          <button type="button" data-dismiss="modal" class="btn  btn-default">Close</button>
                       </center>

        </div>

  </div>
  </div>
  </div>
  
  

  </body>
</html>