<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-cn" lang="zh-cn">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <meta name="Copyright" content="Copyright (c) 2009 thinkPHP.cn" />
        <meta name="generator" content="ThinkPHP <?php echo (THINK_VERSION); ?>" />
        <meta name="Keywords" content="中光电信" />
        <meta name="description" content="中光电信" />
        <title><?php echo ($title); ?> - 中光电信</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/General.css" />
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/func.js"></script>
<script>
	function   show_div(){   
      var   obj_div=document.getElementById("starlist");   obj_div.style.display=(obj_div.style.display=='none')?'block':'none'; 
      }    
    function   hide_div(){
      var   obj_div=document.getElementById("starlist");   obj_div.style.display=(obj_div.style.display=='none')?'block':'none';    
   	}
</script>
<style type="text/css"> 
body {
  background: #80BDCB;
}
#tabbar-div {
  background: #278296;
  padding-left: 10px;
  height: 21px;
  padding-top: 0px;
}
#tabbar-div p {
  margin: 1px 0 0 0;
}
.tab-front {
  background: #80BDCB;
  line-height: 20px;
  font-weight: bold;
  padding: 4px 15px 4px 18px;
  border-right: 2px solid #335b64;
  cursor: hand;
  cursor: pointer;
}
.tab-back {
  color: #F4FAFB;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  cursor: hand;
  cursor: pointer;
}
.tab-hover {
  color: #F4FAFB;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  cursor: hand;
  cursor: pointer;
  background: #2F9DB5;
}
#top-div
{
  padding: 3px 0 2px;
  background: #BBDDE5;
  margin: 5px;
  text-align: center;
}
#main-div {
  border: 1px solid #345C65;
  padding: 5px;
  margin: 5px;
  background: #FFF;
}
#menu-list {
  padding: 0;
  margin: 0;
}
#menu-list ul {
  padding: 0;
  margin: 0;
  list-style-type: none;
  color: #335B64;
}
#menu-list li {
  padding-left: 16px;
  line-height: 16px;
  cursor: hand;
  cursor: pointer;
}
#main-div a:visited, #menu-list a:link, #menu-list a:hover {
  color: #335B64
  text-decoration: none;
}
#menu-list a:active {
  color: #EB8A3D;
}
.explode {
  background: url(__PUBLIC__/Images/wl/menu_minus.gif) no-repeat 0px 3px;
  font-weight: bold;
}
.collapse {
  background: url(__PUBLIC__/Images/wl/menu_plus.gif) no-repeat 0px 3px;
  font-weight: bold;
}
.menu-item {

  font-weight: normal;
}
#help-title {
  font-size: 14px;
  color: #000080;
  margin: 5px 0;
  padding: 0px;
}
#help-content {
  margin: 0;
  padding: 0;
}
.tips {
  color: #CC0000;
}
.link {
  color: #000099;
}
#menu-list .collapse ul{display:none;} 
</style>
</head>
	<body>
		<div id="tabbar-div">
			<p>		<span class="tab-front" id="menu-tab">菜单</span></p>
		</div>
		
		
		<div id="main-div">
			<div id="menu-list">
				<ul>
				
					
					
					<?php
 if(check_permission('Kehu')){ ?>
				
					<li onclick="javascript:show_div()" <?php if((MODULE_NAME) == "Kehu"): ?>class="exlplode"<?php else: ?>class="collapse"<?php endif; ?> key="02_cat_and_goods" name="menu">
					<a href="#" class="_show">客户信息</a>
					
					
					
						<ul <?php if((MODULE_NAME) == "Kehu"): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
							<?php if(check_permission('Kehu:index')) echo '<li class="menu-item">
								<a href="__APP__/Kehu/index" target="main-frame">客户列表</a>
							</li>'; if(check_permission('Kehu:index')) echo '<li class="menu-item">
								<a href="__APP__/Kehu/follow" target="main-frame">客户跟单信息</a>
							</li>'; if(check_permission('Order:finance')) echo '<li class="menu-item">
								<a href="__APP__/Order/finance" target="main-frame">入账查看</a>
							</li>'; if(check_permission('Order:report')) echo '<li class="menu-item">
								<a href="__APP__/Order/report" target="main-frame">财务报表</a>
							</li>'; if(check_permission('Kehu:delete_costomer')) echo '<li class="menu-item">
								<a href="__APP__/Kehu/delete_costomer" target="main-frame">清理无用客户</a>
							</li>'; if(check_permission('Order:delete_order')) echo '<li class="menu-item">
								<a href="__APP__/Order/delete_order" target="main-frame">清理无用订单</a>
							</li>'; ?>
						</ul>
						
					

					</li>
					<?php
 } if(check_permission('Products')){ ?>
				
					<li <?php if((MODULE_NAME) == "Products"): ?>class="exlplode"<?php else: ?>class="collapse"<?php endif; ?> key="08_members" name="menu">
					<a href="#" class="_show">产品管理</a>
						<ul <?php if((MODULE_NAME) == "Products"): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
							<?php if(check_permission('Order:index')) echo '<li class="menu-item">
								<a href="__APP__/Order/index" target="main-frame">产品列表</a>
							</li>'; if(check_permission('Products:prodtype_list')) echo '<li class="menu-item">
								<a href="__APP__/Products/prodtype_list" target="main-frame">产品类型</a>
							</li>'; if(check_permission('Products:add_prodtype')) echo '<li class="menu-item">
								<a href="__APP__/Products/add_prodtype" target="main-frame">添加类型</a>
							</li>'; if(check_permission('Products:jg_list')) echo '<li class="menu-item">
								<a href="__APP__/Products/jg_list" target="main-frame">机柜列表</a>
							</li>'; if(check_permission('Products:add_jhjg')) echo '<li class="menu-item">
								<a href="__APP__/Products/add_jhjg" target="main-frame">添加机柜</a>
							</li>'; ?>
						</ul>
					</li>
					<?php
 } if(check_permission('Serve')){ ?>
				
					<li <?php if((MODULE_NAME) == "Serve"): ?>class="exlplode"<?php else: ?>class="collapse"<?php endif; ?> key="08_members" name="menu">
					<a href="#" class="_show">售后服务</a>
						<ul <?php if((MODULE_NAME) == "Serve"): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
							<?php if(check_permission('Serve:index')) echo '<li class="menu-item">
								<a href="__APP__/Serve/index" target="main-frame">查看服务记录</a>
							</li>'; if(check_permission('Serve:add_srecord')) echo '<li class="menu-item">
								<a href="__APP__/Serve/add_srecord" target="main-frame">添加服务记录</a>
							</li>'; if(check_permission('Serve:serveTop')) echo '<li class="menu-item">
								<a href="__APP__/Serve/serverTop" target="main-frame">服务最多客户</a>
							</li>'; if(check_permission('Serve:zhidao')) echo '<li class="menu-item">
									<a href="__APP__/Serve/zhidao" target="main-frame">问题检索</a>
								</li>'; if(check_permission('Serve:jiansuo')) echo '<li class="menu-item">
									<a href="__APP__/Serve/jiansuo" target="main-frame">操作记录查询</a>
								</li>'; ?>
						</ul>
					</li>
					<?php
 } if(check_permission('User')){ ?>
				
					<li  <?php if((MODULE_NAME) == "User"): ?>class="exlplode"<?php else: ?>class="collapse"<?php endif; ?> key="08_members" name="menu">
					<a href="#" class="_show">员工信息</a>
						<ul <?php if((MODULE_NAME) == "User"): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
							<?php if(check_permission('User:index')) echo '<li class="menu-item">
								<a href="__APP__/User/index" target="main-frame">员工列表</a>
							</li>'; if(check_permission('User:add_member')) echo '<li class="menu-item">
								<a href="__APP__/User/add_member" target="main-frame">添加员工</a>
							</li>'; if(check_permission('User:add_depart')) echo '<li class="menu-item">
								<a href="__APP__/User/add_depart" target="main-frame">添加部门</a>
							</li>'; if(check_permission('User:authset')) echo '<li class="menu-item">
								<a href="__APP__/User/authset" target="main-frame">权限设置</a>
							</li>'; if(check_permission('User:change_owner')) echo '<li class="menu-item">
								<a href="__APP__/User/change_owner" target="main-frame">工作移交</a>
							</li>'; if(check_permission('User:user_login_log')) echo '<li class="menu-item">
								<a href="__APP__/User/user_login_log" target="main-frame">员工登录日志</a>
							</li>'; ?>
						</ul>
					</li>
					<?php
 } if(check_permission('Expense')){ ?>
					<li <?php if((MODULE_NAME) == "Expense"): ?>class="exlplode"<?php else: ?>class="collapse"<?php endif; ?> key="08_members" name="menu">
					<a href="#" class="_show">工作审核</a>
						<ul <?php if((MODULE_NAME) == "Expense"): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
							<?php if(check_permission('Daily:seek')) echo '<li class="menu-item">
								<a href="__APP__/Daily/seek" target="main-frame">查看工作日志</a>
							</li>'; if(check_permission('Expense:examine')) echo '<li class="menu-item">
								<a href="__APP__/Expense/examine" target="main-frame">报销审核</a>
							</li>'; if(check_permission('Leave:index')) echo '<li class="menu-item">
								<a href="__APP__/Leave/index" target="main-frame">请假审核</a>
							</li>'; if(check_permission('Leave:wc_list')) echo '<li class="menu-item">
								<a href="__APP__/Leave/wc_list" target="main-frame">外出审核</a>
							</li>'; if(check_permission('CDN:auth')) echo '<li class="menu-item">
								<a href="__APP__/CDN/auth" target="main-frame">CDN资源审核</a>
							</li>'; if(check_permission('Sys:index')) echo '<li class="menu-item">
								<a href="__APP__/Sys/index" target="main-frame">查看考勤记录</a>
							</li>'; ?>
						</ul>
					</li>
					<?php
 } if(check_permission('Sys')){ ?>
				
					<li <?php if((MODULE_NAME) == "Sys"): ?>class="exlplode"<?php else: ?>class="collapse"<?php endif; ?> key="08_members" name="menu">
					<a href="#" class="_show">系统设定</a>
						<ul <?php if((MODULE_NAME) == "Sys"): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
							<?php if(check_permission('Sys:edit_time')) echo '<li class="menu-item">
								<a href="__APP__/Sys/edit_time" target="main-frame">编辑考勤时段</a>
							</li>'; if(check_permission('Ipool:index')) echo '<li class="menu-item">
								<a href="__APP__/Ipool/index" target="main-frame">IP资源池</a>
							</li>'; ?>
						</ul>
					</li>
					<?php
 } ?>

				</ul>

				
			</div>
		</div>
	</body>
<script language="javascript">
	$("._show").toggle(function(){
		$(this).parent().find("ul").stop(true,true).slideDown('slow');
	},function(){
	    $(this).parent().find("ul").stop(true,true).slideUp('slow');	
	});
</script>
</html>