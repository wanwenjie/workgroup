<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpGroup extends Model
{
   	protected $table = 'emp_groups';

   	protected $fillable = [
		'id','group_id', 'emp_id','invite_p','assign_p'
	];

}
