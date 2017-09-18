<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */
namespace App\Http\Controllers\LA;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Input;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Helpers\LAHelper;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Auth;
use DB;
use File;
use Validator;
use Datatables;
use App\Models\Upload;
use App\Models\Group;
use App\Models\Project;

class UploadsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'path', 'extension', 'caption', 'user_id'];
    public $em_id;
    public $now_emp;
	public function __construct() {
		$this->middleware('auth', ['except' => 'get_file']);
		
		$module = Module::get('Uploads');
		$listing_cols_temp = array();
		foreach ($this->listing_cols as $col) {
			if($col == 'id') {
				$listing_cols_temp[] = $col;
			} else if(Module::hasFieldAccess($module->id, $module->fields[$col]['id'])) {
				$listing_cols_temp[] = $col;
			}
		}
		$this->listing_cols = $listing_cols_temp;
	}
	
	/**
	 * Display a listing of the Uploads.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		$g_id = $request->group_id;
		$p_id = $request->project_id;
		//一个群组里所有人
		$emp_ids = DB::table('emp_groups')->where('group_id',$g_id)->pluck('emp_id');
		$users = DB::table('employees')->whereIn('id',$emp_ids)->get();
		$path = Group::find($g_id)->path.'/'.Project::find($p_id)->name;
		$this->em_id = Auth::user()->id;
		$module = Module::get('Uploads');
        $imgs = Upload::where('group',$g_id)->where('project',$p_id)->get();


		if(Module::hasAccess($module->id)) {
			return View('la.uploads.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
                'em_id' => $this->em_id
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}
	 
	/**
     * Get file
     *
     * @return \Illuminate\Http\Response
     */
    public function get_file($hash, $name)
    {	
    	
        $upload = Upload::where("hash", $hash)->first(); 
        // Validate Upload Hash & Filename
        if(!isset($upload->id) || $upload->name != $name) {
            return response()->json([
                'status' => "failure",
                'message' => "Unauthorized Access 1"
            ]);
        }
        if($upload->public == 1) {
            $upload->public = true;
        } else {
            $upload->public = false;
        }
    
        $path = $upload->path;
       
		$path = iconv("UTF-8","GB2312",$path);
		
        
        // Check if thumbnail
        $size = Input::get('s');
        $height = 132;
        if(isset($size)) {
            if(!is_numeric($size)) {
                $size = 192.36;
            }
            $thumbpath = storage_path("thumbnails/".basename($path)."-".$size."x".$height);
            
            if(File::exists($thumbpath)) {
                $path = $thumbpath;
            } else {
                // Create Thumbnail
                LAHelper::createThumbnail($path, $thumbpath, $size, $height, "transparent");
                $path = $thumbpath;
            }
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $download = Input::get('download');
        if(isset($download)) {
            return response()->download($path, $upload->name);
        } else {
            $response = FacadeResponse::make($file, 200);
            $response->header("Content-Type", $type);
        }
        
        return $response;
        
    }
    /**
     * 由DropZone.js上传而来的文件处理
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_files(Request $request) {
		
			$input = Input::all();
			if(Input::hasFile('file')) {
				
				$file = Input::file('file');
				$g_id = $_POST['group_id'];
				$p_id = $_POST['project_id'];
				$size = $_FILES['file']['size'];
				$path = Group::find($g_id)->path.'\\'.Project::find($p_id)->name;
                $path="uploads\\".$path.""; 
				$folder = storage_path($path);
				$filename = $file->getClientOriginalName();
				if (function_exists("iconv")){
					$c_filename = iconv("UTF-8","GB2312",$filename);
				}
				$upload_success = Input::file('file')->move($folder, $c_filename);
				
				if( $upload_success ) {
	
					// Get public preferences
					// config("laraadmin.uploads.default_public")
					$public = Input::get('public');
					if(isset($public)) {
						$public = true;
					} else {
						$public = false;
					}
	
					$upload = Upload::create([
						"name" => $filename,
						"path" => $folder.DIRECTORY_SEPARATOR.$filename,
						"extension" => pathinfo($filename, PATHINFO_EXTENSION),
						"caption" => "",
						"hash" => "",
						'size' => $size,
						'group' => $g_id,
						'project' => $p_id,
						"public" => $public,
						"user_id" => Auth::user()->id
					]);
					// apply unique random hash to file
					while(true) {
						$hash = strtolower(str_random(20));
						if(!Upload::where("hash", $hash)->count()) {
							$upload->hash = $hash;
							break;
						}
					}
					$upload->save();
	
					return response()->json([
						"status" => "success",
						"upload" => $upload
					], 200);
				} else {
					return response()->json([
						"status" => "error"
					], 400);
				}
			}
		
    }
    /**
     * Get all files from uploads folder
     *
     * @return \Illuminate\Http\Response
     */
    public function uploaded_files(Request $request)
    {
		
			$uploads = array();
			$g_id = $request->group_id;
			$p_id = $request->project_id;
			$uploads =  Upload::where('group',$g_id)->where('project',$p_id)->get();
			
			$uploads2 = array();
			foreach ($uploads as $upload) {
				$u = (object) array();
				$u->id = $upload->id;
				$u->name = $upload->name;
				$u->extension = $upload->extension;
				$u->hash = $upload->hash;
				$u->public = $upload->public;
				$u->caption = $upload->caption;
				$u->user = $upload->user->name;
				$u->created_at = $upload->created_at;
				$u->size = round($upload->size/1024,2);
				$uploads2[] = $u;
			}
			
			return response()->json(['uploads' => $uploads2]);
		
    }
    /**
     * Update Uploads Caption
     *
     * @return \Illuminate\Http\Response
     */
    public function update_caption()
    {
        if(Module::hasAccess("Uploads", "edit")) {
			$file_id = Input::get('file_id');
			$caption = Input::get('caption');
			
			$upload = Upload::find($file_id);
			if(isset($upload->id)) {
				if($upload->user_id == Auth::user()->id || Entrust::hasRole('SUPER_ADMIN')) {
	
					// Update Caption
					$upload->caption = $caption;
					$upload->save();
	
					return response()->json([
						'status' => "success"
					]);
	
				} else {
					return response()->json([
						'status' => "failure",
						'message' => "Upload not found"
					]);
				}
			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Upload not found"
				]);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Unauthorized Access"
			]);
		}
    }
    /**
     * Update Uploads Filename
     *
     * @return \Illuminate\Http\Response
     */
    public function update_filename()
    {
        if(Module::hasAccess("Uploads", "edit")) {
			$file_id = Input::get('file_id');
			$filename = Input::get('filename');
			
			$upload = Upload::find($file_id);
			if(isset($upload->id)) {
				if($upload->user_id == Auth::user()->id || Entrust::hasRole('SUPER_ADMIN')) {
	
					// Update Caption
					$upload->name = $filename;
					$upload->save();
	
					return response()->json([
						'status' => "success"
					]);
	
				} else {
					return response()->json([
						'status' => "failure",
						'message' => "Unauthorized Access 1"
					]);
				}
			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Upload not found"
				]);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Unauthorized Access"
			]);
		}
    }
    /**
     * Update Uploads Public Visibility
     *
     * @return \Illuminate\Http\Response
     */
    public function update_public()
    {
		if(Module::hasAccess("Uploads", "edit")) {
			$file_id = Input::get('file_id');
			$public = Input::get('public');
			if(isset($public)) {
				$public = true;
			} else {
				$public = false;
			}
			
			$upload = Upload::find($file_id);
			if(isset($upload->id)) {
				if($upload->user_id == Auth::user()->id || Entrust::hasRole('SUPER_ADMIN')) {
	
					// Update Caption
					$upload->public = $public;
					$upload->save();
	
					return response()->json([
						'status' => "success"
					]);
	
				} else {
					return response()->json([
						'status' => "failure",
						'message' => "Unauthorized Access 1"
					]);
				}
			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Upload not found"
				]);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Unauthorized Access"
			]);
		}
    }
    /**
     * Remove the specified upload from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_file()
    {
        
			$file_id = Input::get('file_id');
			
			$upload = Upload::find($file_id);
			if(isset($upload->id)) {
				
                $path=$upload->path;
                $path = iconv("UTF-8","GB2312",$path);
                unlink($path);
				// Update Caption
				$upload->delete();
				
				return response()->json([
					'status' => "success"
				]);
               
			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Upload not found"
				]);
			}
		
    }
}