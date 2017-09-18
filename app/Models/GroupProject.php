<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupProject extends Model
{
    protected $table = 'group_projects';
    protected $fillable = [
		'id','group_id', 'project_id'
	];
}
