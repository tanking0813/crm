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

	<div class="list-div">
			<table border="0" align="center" width="500" cellpadding="0" cellspacing="0">
			<form action="" method="get" class="cf">
	 		
			<tr align="center"><td>客户名称：</td><td><input type="text" class="input_text" name="username" onkeyup="search();"/></td><td>处理情况：</td><td><select  name="status" onchange="search();"><option value="0">请选择</option><option value="1">未处理</option><option value="2">正在处理</option><option value="3">已处理</option></select></td><td>&nbsp;</td></tr>
			<tr align="center"><td>内&nbsp;&nbsp;&nbsp;&nbsp;容：</td><td><input onkeyup="search();" type="text" class="input_text" name="content" /></td><td>提交时间：</td><td>从 <input class="Wdate" type="text" onClick="WdatePicker()" name="cname" /> 至今</td><td><input class="srchbutton" type="button" value="&nbsp;" onclick="search();" title="搜索" /></td></tr>
		
			
	 		</form>
			<script language="javascript">
				$(function(){
					search();
				
				})
				
				function search(){
				
					
					$.getJSON('__URL__/search',{'cusname':$('input[name="username"]').val(),'cname':$('input[name="cname"]').val(),'status':$('select[name="status"]').val(),'content':$('input[name="content"]').val()},function(data){
							//alert(data.data);
							$('#mess').html(data.data);
					},'json');
				}
			
			</script>
			</table>
			</div>
				<div class="list-div">
	 			<table id="mess">
				
				</table>
				</div>
    </body>
</html>