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
<form method="get" class="cf">
<table align="center" border="0" cellspacing="3" cellpadding="1">
<caption><h3>CDN资源申请历史</h3></caption>
	<tr><th>申请内容</th><th>申请时间</th><th>审核状态</th><th>最后操作</th><th>操作内容</th></tr>
	<?php if(is_array($resource)): $i = 0; $__LIST__ = $resource;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($rs["reason"]); ?></td><td><?php echo (date('Y-m-d H:i',$rs["ctime"])); ?></td><td><?php if(($rs["status"] == 1) or ($rs["status"] == 2)): ?>审核中<?php elseif($rs["status"] == 3): ?>审核通过<?php elseif($rs["status"] == 0): ?>已处理完<?php endif; ?></td><td><?php if(!empty($rs['lastman'])){echo $rs['lastman'];}elseif(!empty($rs['firstman'])){echo $rs['firstman'];} ?></td><td><?php if(!empty($rs['lastman'])){echo $rs['last_content'];}elseif(!empty($rs['firstman'])){echo $rs['resource'];} ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
</form>
</div>
<div class="list-div">
<a href="javascript:;" style="margin:0 auto;width:116px;height:30px;display:block;background:url(__PUBLIC__/Images/wl/user_top_btn.jpg);line-height:30px;text-align:center;size:12px;color:white;font-weight:bold;text-decoration:none;" onclick="EV_modeAlert('show_apply');">资 源 申 请</a>
</div>
<div id="show_apply" class="show_pop"  style="width:800px;">
  <form method="post" action="__URL__/apply" id="app">
  <div class="list-div">
		<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
		<caption><h3>CDN资源申请</h3></caption>
		<tr rowspan="3"><td class="label">申请内容</td><td colspan="3"><textarea cols="70" rows="6" name="reason"></textarea></td></tr>
		</tr>
		</table>
		</div>
		
		<div class="button-div">
			<input type="button" name="sbt" value=" 申请 " class="button" onclick="checkval()"/><input type="button"  value=" 取消 " class="button" onclick="EV_closeAlert();"/>
		</div>	
		</form> 

</div>
<script language="javascript">
	function checkval(){
		var reg1=/\S+/gm;
		var s=$('textarea[name="reason"]').val();
		//alert(reg1.test(s));
		if(reg1.test(s)){
			$('#app').submit();
		}else{
			alert('请填写申请内容');
			return false;
		}
	}
</script>

</body>
</html>