<?php

namespace App\Http\Controllers\LA;
use Pusher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Employee;
use DB;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;

class ChatController extends Controller
{
    public function index() {
    	$em_id = json_decode(Auth::user())->id;
    	$em = Employee::find($em_id);
    	$group_id = $em->group;
    	$members = DB::table('employees')->where('group',$group_id)->get();
    	$count = count($members);
    	return view('la.chat.index',['members'=>$members,'count'=>$count,'user'=>$em_id,'group'=>$group_id]);
    }

    public function send(Request $request){
    	$msg = $request->message;
    	$g_id = $request->group;
    	$u_id = $request->user;
        $name = json_decode(Auth::user())->name;
    	$message = ChatMessage::create([
    		'user_id' => $u_id,
            'name' => $name,
    		'group_id' => $g_id,
    		'message' => $msg
    		]);

    	event(new ChatMessageWasReceived($message));
    }

    public function s(){
       $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
            );
        $pusher = new Pusher(
        '17ed5c6268b322851fbc',
        'e47d6a3086c0ecbe2d46',
        '336132',
        $options
        );

        $data['message'] = 'hello world';
       dd($pusher->trigger('my-channel', 'my-event', $data)); 
    }

    public function test(){
        
        return view('la.chat.test');
    }
}
