<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Return_tool extends Model
{			
			  public $fillable = ['tool_qty','user_id', 'tool_id','dept_id','shift_id','wrk_station_id','remarks','return_date'];
			   protected $table = 'returns';
			    public $timestamps = false;


}
				
			  
