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

<div class="main-div">
<table width="100%" id="general-table">
<form id="adpro" action="__APP__/Products/add_prodtype_save" method="post">
<tr><td class="label">添加类别</td><td><input type="text" name="labelname" /></td><td></tr>
<tr><td class="label">上级分类</td><td><select name="path"><option value="0">---商品大类---</option><?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($tp["path"]); ?>-<?php echo ($tp["tid"]); ?>"><?php echo ($tp["fg"]); echo ($tp["labelname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></td></tr>
</table>
<div class="button-div">
					<input type="button"  value="保存" onclick="submt();" />
					<input type="button" value=" 返回 " onclick="window.location.href='__APP__/Products';"/>
					</div>
</form>
</div>
<script language="javascript">
	function submt(){
		if($('input[name="labelname"]').val()==''){
			alert('请输入类名');
		}else{
		
			$('#adpro').submit();
		}
	}
</script>
 		

    </body>
</html>