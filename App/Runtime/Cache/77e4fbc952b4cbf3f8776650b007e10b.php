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
<div id="tabbody-div">
	<form action="__SELF__" method="post" class="cf">

		
			 <div class="list-div">	
	 			<table id="mess" width="800">
				<tr><th>全部<input type="checkbox" name="selectAll" value="all" /></th><th>客户名称</th><th>销售</th><th>创建时间</th></tr>
<?php if(is_array($rubish)): $i = 0; $__LIST__ = $rubish;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rb): $mod = ($i % 2 );++$i;?><tr align="center"><td><input type="checkbox" name="cusids[]" value="<?php echo ($rb["id"]); ?>" /></td><td><?php echo ($rb["cusname"]); ?></td><td><?php echo ($rb["saleman"]); ?></td><td><?php echo (date('Y-m-d H:i:s',$rb["ctime"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
</div>
	<div class="button-div">
			<select name="caozuo"><option value="d">删除</option><option value="r">恢复</option></select>
			<input type="submit" name="del" value=" 提交 " class="button" />
			<input type="button" value=" 取消 " class="button" onclick="window.location.href='__URL__'"/>
		</div>	
		</form>
</div>		

<script language="javascript">
	$(function(){
		$('input[name="selectAll"]').click(function(){
			var sele=$(this).attr('checked');
			$('input[name="cusids[]"]').attr('checked',sele);

		});
	
	});
</script>
</body>
</html>