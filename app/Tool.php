<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{			
			  public $fillable = ['name', 'tool_limit','dept_id','available','added_by'];
			  
			   public $timestamps = false;
}
