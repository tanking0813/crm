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
<div class="tab-div">
<div id="tabbody-div">
<div class="list-div">
			<table border="0" cellspacing="0" cellpadding="0">
			<form action="#" method="post" class="cf">
			
			<tr style="height:35px;">
				<td>&nbsp;&nbsp;&nbsp;产品：<select name="proid" onchange="search();">
				<option value="0">请选择</option>
					<?php if(is_array($prolist)): $i = 0; $__LIST__ = $prolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pr): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pr["tid"]); ?>" <?php if(($param["proid"]) == $pr["tid"]): ?>selected<?php endif; ?>><?php echo ($pr["fg"]); echo ($pr["labelname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</td>

				<td align="right">
				<select name="namesearch">
					<option value="0"
						<?php if(($$param["namesearch"]) == "0"): ?>selected<?php endif; ?>
					>客户名称</option>
					<option value="1"
						<?php if(($$param["namesearch"]) == "1"): ?>selected<?php endif; ?>
					>联系人</option>
				</select>&nbsp;&nbsp;
				</td>

					<td>
					<input type="text" id="kehusel" style="display:show;" class="input_text"  name="username" value="<?php echo ($param["username"]); ?>" onkeyup="search();"/>
					<input type="text" id="lianxisel" style="display:none;" class="input_text"  name="contact"   value="<?php echo ($param["contact"]); ?>" onkeyup="search();"/>
					</td>
					

				<td style="text-align:center;">
					<a href="__APP__/Kehu/addCus" style="text-decoration:none;" class="addbutton" title="添加新客户" >添加新客户</a>
				</td>
				<br/>
			</tr>
			
			
				<!--
			   <tr>
				<td  align="center">：</td>
				<td>
				<input type="text" class="input_text"  name="contact"   value="<?php echo ($param["contact"]); ?>" onkeyup="search();"/>
				</td>
				
				<?php
 if(check_permission(MODULE_NAME.':'.ACTION_NAME)==1){ ?>
			<td>销&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;售：</td><td>
				<select  name="saleman" onchange="search();"><option value="0">请选择</option>
				<?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["uid"]); ?>" <?php if(empty($param['salemanId'])){if($s['uid']==$Think['session']['uid']){echo 'selected';}}else{if($s['uid']==$param['salemanId']){echo 'selected';}} ?>><?php echo ($s["uname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</td>
				<?php
 }else{ ?>
				<td colspan="2"></td>
				<?php
 } ?>
				
				<td><input class="srchbutton" type="button" value="&nbsp;" onclick="search();" title="搜索" /></td></tr>
				
				-->

                
				<tr>
				
				
				<th width="40%">客户名称</th><th width="20%">联系人</th>
				
				
				
				<?php
 if(check_permission(MODULE_NAME.':'.ACTION_NAME)==1){ if($_SESSION['rank']=='部门经理'){ ?>
					<th width="20%">
					<select  name="saleman" onchange="search();">
					<?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i; if($s['department'] == $_SESSION['department']){ ?>
					<option value="<?php echo ($s["uid"]); ?>" <?php if(empty($param['salemanId'])){if($s['uid']==$_SESSION['uid']){echo 'selected';}}else{if($s['uid']==$param['salemanId']){echo 'selected';}} ?>><?php echo ($s["uname"]); ?></option>
					<?php
 } endforeach; endif; else: echo "" ;endif; ?>
					</select>
					</th>
				<?php
 }else{ ?>
					<th width="20%">
					<select  name="saleman" onchange="search();"><option value="0"><?php echo ($_SESSION['uid']); ?>所属销售</option>
					<?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["uid"]); ?>" <?php if(empty($param['salemanId'])){if($s['uid']==$Think['session']['uid']){echo 'selected';}}else{if($s['uid']==$param['salemanId']){echo 'selected';}} ?>><?php echo ($s["uname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
					</th>
			<?php
 } }elseif($_SESSION['rank']=='部门经理'){ ?>
				<th width="20%">
				<select  name="saleman" onchange="search();">
				<?php if(is_array($sale)): $i = 0; $__LIST__ = $sale;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i; if($s['department'] == $_SESSION['department']){ ?>
				<option value="<?php echo ($s["uid"]); ?>" <?php if(empty($param['salemanId'])){if($s['uid']==$_SESSION['uid']){echo 'selected';}}else{if($s['uid']==$param['salemanId']){echo 'selected';}} ?>><?php echo ($s["uname"]); ?></option>
				<?php
 } endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</th>
			<?php
 } else{ ?>
			<th width="20%">所属销售</th>
			<?php
 } ?>
				
				<th width="20%">操作</th></tr>
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
	var salemanId="<?php echo ($param["salemanId"]); ?>";
	var cusname="<?php echo ($param["cusname"]); ?>";
	var namesearch="<?php echo ($param["namesearch"]); ?>";
	var ip="<?php echo ($param["ip"]); ?>";
	var proid="<?php echo ($param["proid"]); ?>"?"<?php echo ($param["proid"]); ?>":'0';
	var contact="<?php echo ($param["contact"]); ?>";
	var to="<?php echo ($param["to"]); ?>";
	var rangeb="<?php echo ($param["rangeb"]); ?>";
	var p="<?php echo ($param["p"]); ?>";
	$(function(){
			//alert($('select[name="saleman"]').val());
			$('#mess').html('<caption><caption><h3 style="margin:2px auto;text-align:center;background:#ddd;color:red;width:100%;height:30px;line-height:30px;">载入中...</h3></caption></caption>');
				$.getJSON('__URL__/search',{'cusname':cusname,'namesearch':namesearch,'ip':ip,'proid':proid,'salemanId':$('select[name="saleman"]').val(),'contact':contact,'to':to,'rangeb':rangeb,'p':p},function(data){
					//alert(data);
					$('#mess').html(data.data);
				},'json');
	});
	function search(page){
			//alert($('select[name="saleman"]').val());
			$('#mess').html('<caption><caption><h3 style="margin:2px auto;text-align:center;background:#ddd;color:red;width:100%;height:30px;line-height:30px;">载入中...</h3></caption></caption>');
			$.getJSON('__URL__/search',{'cusname':$('input[name="username"]').val(),'namesearch':$('select[name="namesearch"]').val(),'ip':$('input[name="ip"]').val(),'proid':$('select[name="proid"]').val(),'salemanId':$('select[name="saleman"]').val(),'contact':$('input[name="contact"]').val(),'to':$('input[name="endtime"]').val(),'rangeb':$('select[name="rangeb"]').val(),'per_page':page},function(data){
					$('#mess').html(data.data);
					
			},'json');
			//alert($('input[name="username"]').val());
			//alert($('input[name="contact"]').val());
			
	}
	
//	function inpshow(){
	//	var namesel = getElementById('namesel').val();

	
	//}

	$(function(){
	  $("select[name='namesearch']").change(function(){
		 if(this.value=="0"){
			$("input[name='username']").show();
			$("input[name='contact']").hide();
		 }else{
			$("input[name='username']").hide();
			$("input[name='contact']").show();
		 }
	  });
	});



	var list={payment:'成交金额',totime:'合同结束时间'};
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
	function imglist(url){

				$.getJSON(url,function(data){
					$('#mess').html(data.data);
						
				})
					
	}
				

</script>
    </body>
</html>