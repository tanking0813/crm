<?php
    // 定义ThinkPHP路径
	define('APP_DEBUG',true);
    define('THINK_PATH','./ThinkPHP/');
    // 定义项目名称
    define('APP_NAME','App');
    // 定义项目路径
    define('APP_PATH','./App/');
	//define('HTML_PATH','./html');
    // 加载入口文件
	 define('APP_PUBLIC_PATH','../public');
    require(THINK_PATH.'ThinkPHP.php');
    // 实例化这个项目
    $App = new App();
    // 执行初始化
  // $App->run();
?>