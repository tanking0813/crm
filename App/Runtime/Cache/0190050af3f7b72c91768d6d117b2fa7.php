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
		
	 		<table border="0" align="center" width="90%" cellpadding="0" cellspacing="0">
			<form action="__URL__" method="post" class="cf">
	 		
			<tr align="center"><td>客户名称：</td><td><input type="text" class="input_text" name="username" value="<?php echo ($_GET['username']); ?>" onkeyup="search();" /></td>
			<td>合同号：</td><td><input type="text" class="input_text" name="contract_No" value="<?php echo ($_GET['contract_No']); ?>"  onkeyup="search();"/></td>
			<td>状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态：</td>
			<td>
				<select name="status" onchange="search();">
<!-- 					<option value="3" <?php if(($_GET['status']) == "3"): ?>selected<?php endif; ?>>入账一半</option>
					<option value="2" <?php if(($_GET['status']) == "2"): ?>selected<?php endif; ?>>全部</option>
					<option value="1" <?php if(($_GET['status']) == "1"): ?>selected<?php endif; ?>>未入账</option>
 -->	
				<option value="2" <?php if(($_GET['status']) == "2"): ?>selected<?php endif; ?>>全部</option>
				<option value="1" <?php if(($_GET['status']) == "1"): ?>selected<?php endif; ?>>入账未完</option>
				<option value="all" <?php if(($_GET['status']) == "all"): ?>selected<?php endif; ?>>未入账</option>
				</select>
			</td>
			<td>到期时间：</td>
			<td><select name="endtime" onchange="search();"><option value="0">-选择-</option><option value="e" <?php if(($_GET['endtime']) == "e"): ?>selected<?php endif; ?>>已过期</option><option value="30" <?php if(($_GET['endtime']) == "30"): ?>selected<?php endif; ?>>一月</option><option value="7" <?php if(($_GET['endtime']) == "7"): ?>selected<?php endif; ?>>一周</option><option value="3" <?php if(($_GET['endtime']) == "3"): ?>selected<?php endif; ?>>三天</option></select></td>
				<?php
 if(check_permission(MODULE_NAME.':'.ACTION_NAME)==1){ ?>
			<td>销&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;售：</td><td>
				<select  name="saleman" onchange="search();"><option value="0">请选择</option><?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["uid"]); ?>" <?php if(($s["uid"]) == $_SESSION['uid']): ?>selected<?php endif; ?>><?php echo ($s["uname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select>
				</td>
				<?php
 }else{ ?>
				<td colspan="2"></td>
				<?php
 } ?>
			<td><input class="srchbutton" type="button" value="&nbsp;" onclick="search();" title="搜索" /></td>
			</tr>
	 		</form>
			
			</table>
	 			
	 		
	 		</div>
	
	 		 <div class="list-div">
	 		<table id="mess">
			
			</table>
	 	</div>
	 <script language="javascript">
				function search(){
					$('#mess').html('<caption><h3 style="margin:2px auto;text-align:center;background:#ddd;color:red;width:100%;height:30px;line-height:30px;">载入中...</h3></caption>');
					$.getJSON('__URL__/finaSearch',{'cusname':$('input[name="username"]').val(),'contract_No':$('input[name="contract_No"]').val(),'status':$('select[name="status"]').val(),'to':$('select[name="endtime"]').val(),'salemanId':$('select[name="saleman"]').val()
					},
					function(data){
							//alert(data);
							$('#mess').html(data.data);
					},'json');
					//alert($('select[name="status"]').val());
				}
			$(function(){
				search();
		
			})
		
	 </script>

    </body>
</html>