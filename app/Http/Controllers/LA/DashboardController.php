<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Cookie;
use App\Models\Employee;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {   
        
        if(!Cookie::get('group_id')){
            //存放全局变量group_id,以便广播使用
            $em_id = json_decode(Auth::user())->id;
            $em = Employee::find($em_id);
            $group_id = $em->group;
            Cookie::make('user_id',$em_id);
            //不加密的cookie，前后端进行交互
            Cookie::queue('group_id', $group_id, $minutes = 99999999, $path = null, $domain = null, $secure = false, $httpOnly = false);
        }

        return view('la.dashboard');
    }
}