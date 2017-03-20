<?php

namespace App\Http\Controllers\LA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller{

    public function add() {
    	return view('la.group.add');
    }

    public function search() {
    	return view('la.group.search');
    }
    
}
