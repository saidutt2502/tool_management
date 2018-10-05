<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue_tool extends Model
{			
			  public $fillable = ['tool_qty','user_id', 'tool_id','dept_id','shift_id','wrk_station_id','issue_date'];
			   protected $table = 'issues';
			    public $timestamps = false;
			   
		
}
				
			  
