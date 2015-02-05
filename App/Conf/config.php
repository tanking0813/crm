<?php
 if (!defined('THINK_PATH')) exit();
return array(
	//'配置项'=>'配置值'
	 'APP_AUTOLOAD_PATH' =>'@ORG.Util',
	  'URL_MODEL'         =>1,	  
	 'DB_FIELDTYPE_CHECK'=>true,
    'TMPL_STRIP_SPACE'  => true,
	'DEFAULT_THEME'     =>'new',
  	  'PUBLIC_DIR'  => '/public/',
	  'IMAGES_DIR' => '/public_dir/images/',
	  'UPLOAD_DIR'  =>'/public_dir/upload/',
	  'TPL_PUBLIC'  =>'/App/Tpl/public/',
	   'SESSION_AUTO_START'=>true,  
	  'USER_AUTH_ON'       =>true,
	  'URL_DISPATCH_ON'    =>1,
	'USER_AUTH_TYPE'	 =>1, 	
	'RBAC_ROLE_TABLE'    =>'crm_role',
    'RBAC_USER_TABLE'    =>'crm_role_user',
    'RBAC_ACCESS_TABLE'  =>'crm_access',
    'RBAC_NODE_TABLE'    =>'crm_node',
	 'USER_AUTH_KEY'		 =>'uid',                // 用户认证SESSION标记
    'ADMIN_AUTH_KEY'	 =>'administrator',
	'USER_AUTH_MODEL'	 =>'User',                  // 默认验证数据表模型
	'AUTH_PWD_ENCODER'	 =>'md5',                   // 用户认证密码加密方式
	'USER_AUTH_GATEWAY'	 =>'/Public/login',	// 默认认证网关
	'NOT_AUTH_MODULE'	 =>'Public',                // 默认无需认证模块
	'REQUIRE_AUTH_MODULE'=>'',                      // 默认需要认证模块
	'NOT_AUTH_ACTION'	 =>'',                      // 默认无需认证操作
	'REQUIRE_AUTH_ACTION'=>'',                      // 默认需要认证操作
    'GUEST_AUTH_ON'      =>false,                  // 是否开启游客授权访问
    'GUEST_AUTH_ID'      =>0,                       // 游客的用户ID
	'DB_TYPE'		=>	'mysql',		
	'DB_HOST'		=>	'localhost',
	'DB_NAME'		=>	'crm',
	'DB_USER'		=>	'root',
	'DB_PWD'		=>	'',
	'DB_PORT'           =>'3306',
	'DB_PREFIX'         =>'crm_',
    'TOKEN_ON'      =>true,
    'TOKEN_NAME'        =>'__hash__',
    'TOKEN_TYPE'        =>'md5',
);

?>