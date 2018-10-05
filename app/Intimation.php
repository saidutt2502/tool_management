<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intimation extends Model
{
   protected $table = 'intimations';
   
   public $fillable = ['machine_name','dept_id','breakdown_time','reporting_time','nature','added_by','work_start','machine_handover','totalbreakdown','attended_by','details','status'];
   

}


