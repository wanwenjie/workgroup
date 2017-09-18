<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use App\Models\EmpGroup;
use App\Models\Group;
use App\Mail\InviteMember;
use App\Mail\RequestGroup;
use Mail;
use App\User;
use App\Models\Employee;
use Storage;
use App\Events\JoinGroup;
class GroupsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name','path','pic','created_by'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Groups', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Groups', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Groups.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Groups');
		if(Module::hasAccess($module->id)) {
			return View('la.groups.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new group.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created group in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		
		
		$rules = Module::validateRules("Groups", $request);
		$validator = Validator::make($request->all(), $rules);	

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		//新建路径
		$path = storage_path('uploads')."\\".$request->path;
		if(!is_dir($path)){
			mkdir($path);
		}

		$insert_id = Module::insert("Groups", $request);
		//创建成功的时候，在群组和成员关系表中添加一条记录
		EmpGroup::create([
			'group_id'=>$insert_id,
			'emp_id'=>$request->created_by,
			'invite_p' => 1,
			'assign_p' => 1]);
		return redirect(config('laraadmin.adminRoute') . '/group');
			
	}

	/**
	 * Display the specified group.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Groups", "view")) {
			
			$group = Group::find($id);
			if(isset($group->id)) {
				$module = Module::get('Groups');
				$module->row = $group;
				
				return view('la.groups.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('group', $group);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("group"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified group.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Groups", "edit")) {			
			$group = Group::find($id);
			if(isset($group->id)) {	
				$module = Module::get('Groups');
				
				$module->row = $group;
				
				return view('la.groups.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('group', $group);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("group"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified group in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Groups", "edit")) {
			
			$rules = Module::validateRules("Groups", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Groups", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.groups.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified group from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Groups", "delete")) {
			Group::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.groups.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('groups')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Groups');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/groups/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Groups", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/groups/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Groups", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.groups.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}


	public function group(){
		$module = Module::get('Groups');
		$user_id = Auth::user()->id;
		$my_groups = DB::table('groups')->where('created_by',$user_id)->whereNull('deleted_at')->pluck('id','name');
		$group_ids = DB::table('emp_groups')->where('emp_id',$user_id)->pluck('group_id');
		$groups = DB::table('groups')->whereIn('id',$group_ids)->pluck('id','name');
		$info = [];
		foreach ($my_groups as $key => $value) {
			array_push($info,$key);
		}
		$emp_groups = EmpGroup::where('emp_id',Auth::user()->id)->get();
		$join_groups = array_except($groups,$info);
		return View('la.groups.add', [
			'show_actions' => $this->show_action,
			'listing_cols' => $this->listing_cols,
			'module' => $module,
			'my_groups' => $my_groups,
			'join_groups' => $join_groups,
			'emp_groups' => $emp_groups
		]);
	}

	public function search(Request $request){
		$name = $request->name;
		$var = '%'.$name.'%';
		$emp_id = Auth::user()->id;
		$group_ids = DB::table('emp_groups')->where('emp_id',$emp_id)->pluck('group_id');
		return DB::table('groups')->where('name','like',$var)->whereNotIn('id',$group_ids)->get();
	}

	public function find($id){
		return DB::table('groups')->where('id',$id)->get();
	}

	public function del($id){
		//连同路径一并删除
		$group = Group::find($id);
		$path = $group->path;

		Storage::deleteDirectory($path);
		return DB::table('groups')->where('id',$id)->delete();
	}

	public function invite(Request $request){
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/admin/group/join';
		$to = $request->to;
		$user = User::where('name',$to)->first();
		$from = $request->from;
		$group = $request->group;
		$group_obj= Group::where('id',$group)->first();
		$name = $group_obj->name;
		$url .= '/'.$group."/".$user->id;
		$info = [
			'to' => $to,
			'from' => $from,
			'group' => $name,
			'url' => $url
		];
		Mail::to($user)->send(new InviteMember($info));
		return 'send email success! please wait replay!';
		
	}


	public function join($id,$to){
		$emp_name = Employee::find($to)->name;
		$group_name = Group::find($id)->name;
		$info = [
			'group_id' => $id,
			'info' => $emp_name.' joined '.$group_name.' group'];
		if(!EmpGroup::where('emp_id',$to)->where('group_id',$id)->first()){
			EmpGroup::create([
			'emp_id' => $to,
			'group_id' => $id ]);
			event(new JoinGroup($info));
		}
		return redirect('/admin/group');
	}

	public function req(Request $request){

		$url = 'http://'.$_SERVER['HTTP_HOST'].'/admin/group/join';
		$group_name = $request->name;
		$user_name = Auth::user()->name;//请求者名称
		$groups = Group::where('name',$group_name)->first();
		$emp_id = $groups->created_by;
		$group_id = $groups->id;
		$user = User::find($emp_id);
		$url .= '/'.$group_id.'/'.Auth::user()->id;
		$info = [
			'to' => $user->name,
			'from' => $user_name,
			'group' => $group_name,
			'url' => $url
		];
		Mail::to($user)->send(new RequestGroup($info));
		return "send emial success! please wait replay!";
	}

	public function member($id){
		$info = [];
		$emp_ids = DB::table('emp_groups')->where('group_id',$id)->pluck('emp_id');
		return DB::table('employees')->whereIn('id',$emp_ids)->get();
	}

	public function permission(Request $request){
		$eg = EmpGroup::where('emp_id',$request->emp_id)->where('group_id',$request->group_id)->first();
		$invite_p = $request->invite_p;
		$assign_p = $request->assign_p;
		if($invite_p == ''){
			$invite_p = 0;
		}
		if($assign_p == ''){
			$assign_p = 0;
		}
		$eg->invite_p = $invite_p;
		$eg->assign_p = $assign_p;
		if($eg->save()){
			return 'save success!';
		}else{
			return 'save failure!';
		}
	}

}

