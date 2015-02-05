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
		
	 		<table>
			<form action="#" method="post" class="cf">
			<tr><td>客户名称：</td><td colspan="2"><input type="text" class="input_text" name="username"  value="<?php echo ($param["cusname"]); ?>" onkeyup="search();"/></td>
			<td>IP：</td><td><input type="text" class="input_text" name="ip"  value="<?php echo ($param["ip"]); ?>" onkeyup="search();"/></td>
			<td>机柜：</td><td colspan="3"><select onchange="search();" name="jgui"><option value="0">请选择</option><?php if(is_array($store)): $i = 0; $__LIST__ = $store;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jg): $mod = ($i % 2 );++$i;?><option value="<?php echo ($jg["id"]); ?>" <?php if(($jg["id"]) == $param["store"]): ?>selected<?php endif; ?>><?php echo ($jg["fullname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></td>
			</tr>
			<tr>
			<td>使用产品：</td><td  colspan="2">
			<select  name="proid" onchange="search();">
			<option value="0">请选择</option>
			<?php if(is_array($prolist)): $i = 0; $__LIST__ = $prolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option value="<?php echo ($p["bpath"]); ?>" <?php if(($param["proid"]) == $p["bpath"]): ?>selected<?php endif; ?>><?php echo ($p["fg"]); echo ($p["labelname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			</td>
			<?php if(($_SESSION['group']) == "6"): else: ?>
			<td>成交时间</td>
			<td>
			<select name="order_ctime" onchange="search();">
			<option value="0">-选择-</option>
			<option value="1" <?php if(($param["order_ctime"]) == "1"): ?>selected<?php endif; ?>>本月</option>
			<option value="2" <?php if(($param["order_ctime"]) == "2"): ?>selected<?php endif; ?>>上月</option>
			<option value="3" <?php if(($param["order_ctime"]) == "3"): ?>selected<?php endif; ?>>本季度</option>
			<option value="4" <?php if(($param["order_ctime"]) == "4"): ?>selected<?php endif; ?>>本年</option>
			<?php $thisYear=date('Y'); for($i=$thisYear;$i>2010;){ $i--; echo '<option value="'.$i.'"'; echo $param['order_ctime']==$i?'selected':''; echo '>'.$i.'年</option>'; } ?>
			</select>
			</td><?php endif; ?>
			<td>到期时间：</td>
			<td>
			<select name="endtime" onchange="search();">
			<?php if(($_SESSION['group']) == "6"): ?><option value="30"<?php if(($param["to"]) == "30"): ?>selected<?php endif; ?>>一月</option>
			<option value="7" <?php if(($param["to"]) == "7"): ?>selected<?php endif; ?>>一周</option>
			<option value="3" <?php if(($param["to"]) == "3"): ?>selected<?php endif; ?>>三天</option>
			<?php else: ?>
			<option value="0">-选择-</option>
			<option value="e" <?php if(($param["to"]) == "e"): ?>selected<?php endif; ?>>已过期</option>
			<option value="30"<?php if(($param["to"]) == "30"): ?>selected<?php endif; ?>>一月</option>
			<option value="7" <?php if(($param["to"]) == "7"): ?>selected<?php endif; ?>>一周</option>
			<option value="3" <?php if(($param["to"]) == "3"): ?>selected<?php endif; ?>>三天</option><?php endif; ?>
			</select>
			</td>
			
			<?php if(check_permission('Order:search') == 1): ?><td>销&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;售：</td>
			<td><select name="saleman" onchange="search();">
			<option value="0">请选择</option>
			<?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["uid"]); ?>" 
			<?php if(empty($param['salemanId'])) {if($s['uid']==$Think['session']['uid']){echo 'selected';}}else{if($s['uid']==$param['salemanId']){echo 'selected';}} ?>><?php echo ($s["uname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			</td>
			<?php else: ?>
				
					<td>&nbsp;</td><?php endif; ?>
			<!--
			<td><input class="srchbutton" type="button" value="&nbsp;" onclick="search();" title="搜索" /></td>
			-->
			</tr>
	 		</form>
			
			</table>
	 		</div>
	 		 <div class="list-div">
	 		<table id="mess">
			
			</table>
	 	</div>
		<div id="modiOrder" class="show_pop" style="height:300px;width:900px;">  	

</div>  
	 <script language="javascript">
			var cusname="<?php echo ($param["cusname"]); ?>";
			var proid="<?php echo ($param["proid"]); ?>";
			var salemanId="<?php echo ($param["salemanId"]); ?>";
			var order_ctime="<?php echo ($param["order_ctime"]); ?>"
			var to="<?php echo ($param["to"]); ?>";
			var ip="<?php echo ($param["ip"]); ?>";
			var store="<?php echo ($param["store"]); ?>";
			var p="<?php echo ($param["p"]); ?>";
			$(function(){
					
					$.getJSON('__URL__/search',{'cusname':cusname,'proid':proid,'salemanId':salemanId,'order_ctime':order_ctime,'to':$('select[name="endtime"]').val(),'ip':ip,'store':store,'p':p},function(data){ 
					//alert(data.data);
							$('#mess').html(data.data);
					},'json');
		
			})
				function search(){
					//alert($('select[name="saleman"]').val());
					$.getJSON('__URL__/search',{'cusname':$('input[name="username"]').val(),'proid':$('select[name="proid"]').val(),'salemanId':$('select[name="saleman"]').val(),'order_ctime':$('select[name="order_ctime"]').val(),'to':$('select[name="endtime"]').val(),'ip':$('input[name="ip"]').val(),'store':$('select[name="jgui"]').val()},function(data){
							$('#mess').html(data.data);
					},'json');
				}
			
			
	
	function modify_order(id){
		EV_modeAlert('modiOrder');
		$.getJSON('__URL__/modify_order',{'onumber':id},function(data){
			$('#modiOrder').html(data.data);
		},'JSON')
	
	}

	function imglist(url){
			$.getJSON(url,function(data){
				$('#mess').html(data.data);
						
			})
					
	}
	function remove_order(id){
		r=confirm("确认删除?");
		if (r==true){

				$.post('__URL__/remove_order',{'onum':id},function(data){
					if(data==1){
						$('#b_bkb'+id).remove();
					
					}else{
						alert('系统错误,未删除');
					}
			
				})
			}

	}
	var list={fromtime:'开始时间',totime:'到期时间'};
	var listTable=new Object();
	listTable.sort=function(info,order,param){
	var order=!order?1:0;
	var p_src=['sort_desc.gif','sort_asc.gif'];
	var s=($('#sortImg').attr('src')).split('/');
	s.pop();
	if(order){
			p_src=s.join('/')+'/'+p_src[order];
	
	}else{
			p_src=s.join('/')+'/'+p_src[order];
				
	}
	$.getJSON('__URL__/search?'+param+'&field='+info+'&order='+order,function(data){
		
		$('#mess').html(data.data)
		var hah=list[info];
		$('#sortImg').insertAfter($('th>a:contains('+hah+')'));
		$('#sortImg').attr({src:p_src});
							

	},'json');
}
	
	
	 </script>


    </body>
</html>