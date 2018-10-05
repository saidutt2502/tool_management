@extends('layouts.master')


@section('header')Super Administrator's Home @endsection

@section('body')

     
<div class="row top_tiles">  
 
<?php 


  $dept = DB::select('SELECT * FROM department');

?>
      @foreach($dept as $this_dept)
    <?php
      $admins = DB::table('users')
      ->join('users2dept', 'users.id', '=', 'users2dept.user_id')
      ->where('users.user_type','2')
      ->where('users2dept.dept_id',$this_dept->id)->count();
      
      
      $supervisors = DB::table('users')
      ->join('users2dept', 'users.id', '=', 'users2dept.user_id')
      ->where('user_type','3')
      ->where('users2dept.dept_id',$this_dept->id)->count();
      
      $tools = DB::table('tools')->where('dept_id',$this_dept->id)->count();
    
    ?>
         <div class="col-md-3 col-xs-12 widget widget_tally_box" onclick="location.href='tools_display/{{$this_dept->id}}';" style="cursor: pointer;" id="{{ $this_dept->id }}">
                        <div class="x_panel colour_this">
                          <div class="x_content fixed_height_390">

                            <div class="flex">
                             
                                 <h3><strong>{{ $this_dept->department_name }}</strong></h3>
                               
                            </div>

                            <div class="flex">
                              <ul class="list-inline count2">
                                <li>
                                  <h3>{{ $admins }}</h3>
                                  <span>Admins</span>
                                </li>
                                <li>
                                  <h3>{{ $supervisors }}</h3>
                                  <span style="margin-left: -5px;">Supervisors</span>
                                </li>
                                <li>
                                  <h3>{{ $tools }}</h3>
                                  <span>Tools</span>
                                </li>
                              </ul>
                            </div>

                          </div>
                        </div>
                      </div>
      @endforeach
            

</div>
</div>
</div>

<script>

var safeColors = ['bb','dd','99','ee','cc','ff','00','b3','c9'];
var rand = function() {
    return Math.floor(Math.random()*6);
};
var randomColor = function() {
    var r = safeColors[rand()];
    var g = safeColors[rand()];
    var b = safeColors[rand()];
    return "#"+r+g+b;
};

$(document).ready(function() {
  
        $('.colour_this').each(function() {
            $(this).css('background',randomColor());
        });
    
    
    
});
</script>
     
      
@endsection