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
	<table cellpadding="0" cellspacing="0">
	<tr><th>金牌销售</th><th></th></tr>
	<tr><td rowspan="3" align="center"><img src="__PUBLIC__/Images/avatar/1.jpg"><td>职员姓名：<?php echo ($gold["uname"]); ?></td></tr>
	<tr><td>职位名称：<?php echo ($gold["rank"]); ?></td></tr>
	<tr><td>成交客户：<?php echo ($gold["count"]); ?></td></tr>
	</table>
	</div>	


<div class="list-div">
<table cellspacing='1' cellpadding='3'>
  <tr>
    <th colspan="4" class="group-title">实体产品统计信息</th>
  </tr>
  <tr>
    <td>本月成交客户:</td>
    <td><strong><?php echo ($total_cus); ?></strong></td>
    <td>本月成交订单:</td>
    <td><strong><?php echo ($total_order); ?></strong></td>
  </tr>
  <tr>
    <td>本月成交金额:</td>
    <td><strong><?php echo ($total_payment); ?></strong></td>
    <td>本月实收金额:</td>
    <td><strong><?php echo ($total_paid); ?></strong></td>
  </tr>
</table>
</div>
<div class="list-div">
<table  cellspacing='1' cellpadding='3'>
<caption><h4>计划跟单</h4></caption>
	
	<tr><th>客户名称：</th><th>联系人：</th><th>电话</th><th>QQ</th><th>时间：</th><th>备注：</th></tr>
	<?php if(is_array($cron_total)): $i = 0; $__LIST__ = $cron_total;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ct): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($ct["cusname"]); ?></td><td><?php echo ($ct["contact"]); ?></td><td><?php echo ($ct["mobile"]); ?></td><td><?php echo ($ct["qq"]); ?></td><td><?php echo (date('Y-m-d',$ct["nexttime"])); ?></td><td><?php echo ($ct["note"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?> 
</table>   
</div>
<div id="show_message" class="show_pop"  style="width:600px;height:300px;overflow:scroll;">

</div>
<div id="show_notice" class="show_pop"  style="width:400px;height:300px;overflow:scroll;">

</div>
<div style="width:300px;height:50px;text-align:center;line-height:50px;background:pink;position:fixed;bottom:0;right:0">最新系统消息:<a href="javascript:;" onclick="sys_message('<?php echo (count($message)); ?>');"><?php echo (count($message)); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;最新文章:<a href="javascript:;" onclick="sys_notice('<?php echo (count($notice)); ?>');"><?php echo (count($notice)); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;待办事务:<a href="javascript:;"></a></div>
<script language="javascript">
	function sys_message(num){
		if(num!=0){
		
			EV_modeAlert('show_message');
			$.getJSON('__URL__/show_message',function(data){
				$('#show_message').html(data.data);
			},'json');
		}
	}
	function sys_notice(num){
		if(num!=0){
			EV_modeAlert('show_notice');
			$.getJSON('__URL__/show_notice',function(data){
				$('#show_notice').html(data.data);
			},'json');
		}
	}

	function set_readed_mess(mid){
		$.post('__URL__/read_message',{'mid':mid},function(data){
			if(data==1){
				$('#bkb'+mid).remove();
			}
		});
	
	}
	function set_readed_notice(nid){
	
		$.post('__URL__/read_notice',{'nid':nid},function(data){
			if(data==1){
				window.location.href="__APP__/BBS/title_detail/id/"+nid;
			}
		});
	
	}
</script>
</body>
</html>