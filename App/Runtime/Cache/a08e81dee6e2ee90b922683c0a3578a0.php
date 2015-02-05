<?php if (!defined('THINK_PATH')) exit(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<div class="tab-div">
<div id="tabbody-div">
<div class="list-div">
			<table border="0" cellspacing="0" cellpadding="0">
			<form action="" method="get" class="cf">
			
			<tr style="height:35px;">
				<td align="right">
				<select name="namesearch">
					<option value="0"
						<?php if(($$namesel) == "0"): ?>selected<?php endif; ?>
					>客户名称</option>
					<option value="1"
						<?php if(($$namesel) == "1"): ?>selected<?php endif; ?>
					>联系人</option>
				</select>&nbsp;&nbsp;
				</td>
					<td>
					
					<input type="text" id="kehusel" style="display:show;" class="input_text"  name="cusname" value="" />
					<input type="text" id="lianxisel" style="display:none;" class="input_text"  name="contact"   value="" />
					</td>
					
					<?php
 if(check_permission(MODULE_NAME.':'.ACTION_NAME)==1){ ?>
			    <td style="text-align:right;">所属销售&nbsp;&nbsp;</td>
				<td>
				<select  name="salemanId"><option value="0">全部</option>
				<?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["uid"]); ?>" <?php if(empty($param['salemanId'])){if($s['uid']==$Think['session']['uid']){echo 'selected';}}else{if($s['uid']==$param['salemanId']){echo 'selected';}} ?>><?php echo ($s["uname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</th>
				<?php
 }else{ ?>
				<td colspan="2">&nbsp;</td>
				<?php
 } ?>


					<td colspan="4">
						<input  class="srchbutton" type="submit" value="&nbsp;"  title="搜索" />
					</td>
				<br/>
			    </tr>
			
				<tr>
				<th>客户名称</th>
				<th>联系人</th>
				<th>所属销售</th>
				
				<th>事件</th>
				<th>描述</th>
				<th>预约时间</th>
				<th>剩余时间</th>
				<th>备忘</th>
				
				
				</tr>
				<?php if(is_array($cust)): $i = 0; $__LIST__ = $cust;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cm): $mod = ($i % 2 );++$i;?><tr align="center">
					<td  width="20%">
					<?php if($cm["custype"] == 1): ?><a href="__URL__/view/id/<?php echo ($cm["num"]); ?>/salename/<?php echo ($cm["uname"]); ?>/backname/1" style="text-decoration:none;color:green" title = "客户详情"><?php echo ($cm["cusname"]); ?></a>
				<?php elseif($cm["custype"] == 2): ?>
					<a href="__URL__/view/id/<?php echo ($cm["num"]); ?>/salename/<?php echo ($cm["uname"]); ?>/backname/1" style="text-decoration:none;color:blue" title = "客户详情"><?php echo ($cm["cusname"]); ?></a>
				<?php elseif($cm["custype"] == 3): ?>
					<a href="__URL__/view/id/<?php echo ($cm["num"]); ?>/salename/<?php echo ($cm["uname"]); ?>/backname/1" style="text-decoration:none;color:#666" title = "客户详情"><?php echo ($cm["cusname"]); ?></a>
				<?php else: endif; ?>
					</td>
					<td width="8%"><?php echo ($cm["contact"]); ?></td>
					<td width="7%"><?php echo ($cm["uname"]); ?></td>
					<td width="10%"><?php echo ($cm["note"]); ?></td>
					<td width="20%"><?php echo ($cm["description"]); ?></td>
					<td width="10%"><?php echo ($cm["gd_time"]); ?></td>
					<td width="10%"><?php echo ($cm["cday"]); ?></td>
					<td width="15%"><?php echo ($cm["nextnote"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	 		</form>
			</table>
			

	 	</div>
	
	 
	 <div class="list-div">	
	 			<table id="mess" width="800">
				
				</table>
</div>
</div>
</div>

<script language="javascript">

			$(function(){
				  $("select[name='namesearch']").change(function(){
					 if(this.value=="0"){
						$("input[name='cusname']").show();
						$("input[name='contact']").hide();
					 }else{
						$("input[name='cusname']").hide();
						$("input[name='contact']").show();
					 }
				  });
			});
</script>

    </body>
</html>