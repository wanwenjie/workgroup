<?php

namespace App\Http\Controllers\LA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index() {
    	return view('la.chat.index');
    }
}
