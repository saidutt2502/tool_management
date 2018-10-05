<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wrkstation extends Model
{
   protected $table = 'workstations';
   
   public $fillable = ['name','dept_id','added_by'];
   
    public $timestamps = false;
}
