<?php
/**
 * Config genrated using LaraAdmin
 * Help: http://laraadmin.com
 */
/*laradmin权限管理文件*/
return [
    
	/*
    |--------------------------------------------------------------------------
    | General Configuration
    |--------------------------------------------------------------------------
    */
    
	'adminRoute' => 'admin',
    
    /*
    |--------------------------------------------------------------------------
    | Uploads Configuration
    |--------------------------------------------------------------------------
    |
    | private_uploads: Show that uploaded file remains private and can be seen by respective owners only
    | default_uploads_security: public / private
    | 
    */
    'uploads' => [
//        此设置为true 所有的文件只能由上传者看到
        'private_uploads' => false,
        'default_public' => false,
        'allow_filename_change' => true
    ],
];