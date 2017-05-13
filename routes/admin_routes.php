<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/



$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}



Route::group(['as' => $as, 'middleware' => ['auth','permission:ADMIN_PANEL']], function () {
	

	/* ================== Dashboard ================== */
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index'); 


	/* ================== chat ================== */
	Route::get(config('laraadmin.adminRoute') . '/chat', 'LA\ChatController@index');
	Route::post(config('laraadmin.adminRoute') . '/chat', 'LA\ChatController@send');
	Route::get(config('laraadmin.adminRoute') . '/test', 'LA\ChatController@test');
	Route::get(config('laraadmin.adminRoute') . '/s', 'LA\ChatController@s');


	/* ================== assign ================== */
	Route::get(config('laraadmin.adminRoute') . '/assign', 'LA\GroupsController@assign');


	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	

	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');
	

	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	

	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	/* ================== Groups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/groups', 'LA\GroupsController');
	Route::get(config('laraadmin.adminRoute') . '/group_dt_ajax', 'LA\GroupsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/group', 'LA\GroupsController@group');


	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');
	Route::post(config('laraadmin.adminRoute') . '/employee/search', 'LA\EmployeesController@search');

	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');


	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	
	
});




// Route::group(['as' => $as, 'middleware' => ['auth','permission:SENIOR_ADMIN_PANEL']], function () {

// 	/* ================== Dashboard ================== */
	
// 	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
// 	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	

// 	/* ================== chat ================== */
// 	Route::get(config('laraadmin.adminRoute') . '/chat', 'LA\ChatController@index');




// 	/* ================== assign ================== */
// 	Route::get(config('laraadmin.adminRoute') . '/assign', 'LA\GroupsController@assign');

// 	/* ================== Uploads ================== */
// 	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
// 	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
// 	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
// 	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
// 	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
// 	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
// 	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');



// });