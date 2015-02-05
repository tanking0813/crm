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
		<form action="__SELF__" method="post" class="cf">
		<div class="list-div">
	 	<table>
		<tr><td>报表周期</td><td>
			<select name="ctime">
			<option value="0">-选择-</option>
			<option value="1" <?php if(($_POST['ctime']) == "1"): ?>selected<?php endif; ?>>本月</option>
			<option value="2" <?php if(($_POST['ctime']) == "2"): ?>selected<?php endif; ?>>上月</option>
			<option value="3" <?php if(($_POST['ctime']) == "3"): ?>selected<?php endif; ?>>本季度</option>
			<option value="4" <?php if(($_POST['ctime']) == "4"): ?>selected<?php endif; ?>>本年</option>
			<?php $thisYear=date('Y'); for($i=$thisYear;$i>2010;){ $i--; echo '<option value="'.$i.'"'; echo $_POST['ctime']==$i?'selected':''; echo '>'.$i.'年</option>'; } ?>
			</select></td>
			<td>销&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;售：</td><td>
				<select  name="saleman"><option value="0">请选择</option><?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["uid"]); ?>" <?php if(($s["uid"]) == $_POST['saleman']): ?>selected<?php endif; ?>><?php echo ($s["uname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select>
				</td>
		
			<td><input class="srchbutton" type="submit" value="&nbsp;"  title="搜索" /></td>
	
			</tr>
				
			</table>
			</div>
				</form>

<div class="list-div">

<table>
<tr><th>产品</th><th>用户</th><th>应收</th><th>实收</th><th>销售人员</th><th>备注</th></tr>
<?php if(is_array($repo)): $i = 0; $__LIST__ = $repo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rp): $mod = ($i % 2 );++$i;?><tr align="center">
<td><?php echo ($rp["labelname"]); ?></td>
<td><?php echo ($rp["cusname"]); ?></td>
<td><?php echo ($rp["payment"]); ?></td>
<td><?php echo ($rp["paid"]); ?></td>
<td><?php echo ($rp["uname"]); ?></td>
<td><?php echo ($rp["finnote"]); ?></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
</div>
<div><h1><span>共<?php echo ($total); ?>条记录&nbsp;&nbsp;&nbsp;应收金额累计：<?php echo ($total_payment); ?>元&nbsp;&nbsp;&nbsp;实收金额累计：<?php echo ($total_money); ?>元</span><span class="action-span"><a href="__SELF__/ctime/<?php echo ($_POST['ctime']); ?>/saleman/<?php echo ($_POST['saleman']); ?>/down/true">下载</a></span></h1></div>
</body>
</html>