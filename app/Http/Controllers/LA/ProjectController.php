<?php

namespace App\Http\Controllers\LA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Employee;
use DB;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;
use App\Models\GroupProject;
use App\Models\Project;
use Dwij\Laraadmin\Models\Module;
use Storage;
use App\Models\EmpGroup;
use App\Models\Group;

class ProjectController extends Controller
{
    public function index(Request $request){
    	
    	$em_id = Auth::user()->id;
    	$group_id = $request->group_id;
    	$emp_ids = DB::table('emp_groups')->where('group_id',$group_id)->pluck('emp_id');
    	$created_by_id = Group::find($group_id)->created_by;
    	$created_by_name = Employee::find($created_by_id)->name;
    	$members = DB::table('employees')->whereIn('id',$emp_ids)->pluck('pic','name');

    	$project_ids = DB::table('group_projects')->where('group_id',$group_id)->pluck('project_id');
    	$projects = DB::table('projects')->whereIn('id',$project_ids)->pluck('id','name');
    	$count = count($members);
        $message = DB::table('chat_messages')->where('group_id',$group_id)->get();
        $module = Module::get('Organizations');
        $path = Group::find($group_id)->path;

        $emp_group = EmpGroup::where('group_id',$group_id)->where('emp_id',$em_id)->first();
        $assign_p = $emp_group->assign_p;
        
    	return view('la.project.index',
    		['members'=>$members,
    		'created_by' => $created_by_name,
    		'count'=>$count,
    		'user'=>$em_id,
    		'group'=>$group_id,
    		'messages'=>$message,
    		'projects' => $projects,
    		'module' => $module,
    		'path' => $path,
    		'assign_p' => $assign_p]);
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

    public function add(Request $request){
    	$group_id = $request->group;

    	$project = Project::create([
    		'name' => $request->name,
    		'des' => $request->des,
    		'end_time' => $request->end_time]);
    	
    	//同时创建项目文件夹
    	//新建路径
		$path = storage_path('uploads')."\\".Group::find($group_id)->path;
		$path .= '\\'.$project->name;

		if(!is_dir($path)){
			mkdir($path);
		}
    	if(GroupProject::create([
    		'group_id' => $group_id,
    		'project_id' => $project->id])){
    		return 'success';
    	}else{
    		return 'false';
    	}

    }

    public function del(Request $request){
    	//同时删除项目目录
    	$group_id = $request->group;
    	$id = $request->project;
    	$p_name = Project::find($id)->name;
    	$path = Group::find($group_id)->path.'\\'.$p_name;

    	Storage::deleteDirectory($path);
    	//同时删除群组-项目记录
    	DB::table('group_projects')->where('project_id',$id)->delete();
    	//删除项目任务分配的任务
    	DB::table('organizations')->where('project',$id)->delete();
    	return DB::table('projects')->where('id',$id)->delete();
    }

    public function find($id){
    	return DB::table('projects')->where('id',$id)->get();
    }


    public function complete(Request $request){
    	$status = $request->status;
    	$id = $request->project_id;
    	$project = Project::find($id);
    	$project->status = $status;
    	$project->save();
    }
}
