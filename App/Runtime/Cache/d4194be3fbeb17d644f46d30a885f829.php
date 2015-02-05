<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-cn" lang="zh-cn">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <meta name="Copyright" content="Copyright (c) 2009 thinkPHP.cn" />
        <meta name="generator" content="" />
        <meta name="Keywords" content="中光电信" />
        <meta name="description" content="中光电信" />
        <title><?php echo ($title); ?> - 中光电信</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/General.css" /><link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/main.css" />
<script type="text/javascript" src="__PUBLIC__/Js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/my/pop.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/My97DatePicker/WdatePicker.js"></script>
 </head>
 <body>
 <h1>
<span class="action-span1"><a href="__APP__/Index">中光电信CRM控制台</a>&nbsp;---&nbsp;</span><span id="search_id" class="action-span1">
<?php if((MODULE_NAME) == "Index"): ?>综合信息<?php endif; ?>
<?php if((MODULE_NAME) == "Kehu"): ?>用户信息<?php endif; ?>
<?php if((MODULE_NAME) == "Order"): ?>购买信息<?php endif; ?>
<?php if((MODULE_NAME) == "User"): ?>管理信息<?php endif; ?>
<?php if((MODULE_NAME) == "Products"): ?>产品信息<?php endif; ?>
<?php if((MODULE_NAME) == "Serve"): ?>客服信息<?php endif; ?>
<?php if((MODULE_NAME) == "Sys"): ?>系统设定<?php endif; ?>
<?php if((MODULE_NAME) == "Oa"): ?>个人考勤<?php endif; ?>
</span>
<div style="clear:both"></div>
</h1>
<style>
.bg{background:}
.table1{margin:10px; }
.tr1{
	height:30px;line-height:30px; font-size:14px; font-weight:bold;
}
.tr4{
	height:25px;line-height:25px;color:red; font-size:12px;}
.tr2{
	height:25px;line-height:25px; font-size:12px;
}
.tr3{
	 text-align:center;height:40px;line-height:40px; 
}
</style>
<div id="tabbody-div">
<table width=800 class='table1'>
	<caption><h2>用户登录记录</h2></caption>
	<tr class='tr1'>
		<td>登录记录</td>
		<td>
		<form action='__URL__/sech' method='post'>
		<input type='text' name='username' value="请输入要检索的用户名" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />&nbsp;&nbsp;
		<input type='submit' value='搜索' />
		</form>
		</td>
	</tr>
	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo[uid]) != "0"): ?><tr class='tr2'>
			<td>用户&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["user"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;以ip为&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["login_ip"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;在&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (date("y-m-d H:i:s",$vo["optime"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;时成功登录网站</td>
			<td><a href='__URL__/dele/id/<?php echo ($vo[id]); ?>' ></a></td>
		</tr>
		<?php else: ?>
		<tr class='tr4'>
			<td>有可疑用户&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["user"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;以ip为&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["login_ip"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;在&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (date("y-m-d H:i:s",$vo["optime"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;时试图登录网站</td>
			<td><a href='__URL__/dele/id/<?php echo ($vo[id]); ?>' ></a></td>
		</tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	<tr class='tr3' >
		<td colspan=2> <?php echo ($page); ?> </td>
	</tr>
</table>
 </div>
	   

    </body>
</html>