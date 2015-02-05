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
<script language="javascript">

		function togglegif(e){
		
			var targ;
			
			if (!e) var e = window.event;
			if (e.target) targ = e.target
			
			if (e.currentTarget) targ=e.currentTarget
			if (e.srcElement) targ = e.srcElement
			if (targ.nodeType == 3) // defeat Safari bug
			targ = targ.parentNode;
			var s=targ;
			//alert(s);
			var id=$(s).attr('class');
			var p=s.parentNode.parentNode;	
			var pid=$(p).attr('class');
			var affectId=pid+'-'+id;
			if($(s).attr('src')=='__PUBLIC__/Images/wl/menu_minus.gif'){
				//如果图片为-,点击影藏					
				$('tr[class^="'+affectId+'"]').hide();
				$(s).attr({src:'__PUBLIC__/Images/wl/menu_plus.gif'});
								
			}else{
				//如果图片为+，点击展开
				$('tr[class^="'+affectId+'"]').show();
				$(s).attr({src:'__PUBLIC__/Images/wl/menu_minus.gif'});
			}	
		}
	</script>
<form method="post" action="" name="listForm">
			<div class="list-div" id="listDiv">
			
				<table width="100%" cellspacing="1" cellpadding="1" border="1" id="list-table">
					<tr>
						<th>分类名称</th>
					
						<th>操作</th>
					</tr>
					
						
					<!--顶级分类-->
					<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><tr align="center" class="<?php echo ($type["path"]); ?>">
						<td align="left">
							<span name="nbsp">&nbsp;&nbsp;&nbsp;<?php echo ($type["fg"]); ?></span><img class="<?php echo ($type["tid"]); ?>" src="__PUBLIC__/Images/wl/menu_minus.gif" onclick="togglegif(window.event);" width="9" height="9" border="0" style="margin-left:0em"/>
							<span>&nbsp;&nbsp;<a style="text-decoration:none;" href="javascript:;"><?php echo ($type["labelname"]); ?></a></span>
						</td>
						
						<td width="30%" align="center">
						
							<a href="javascript:;" onclick="modiName('<?php echo ($type["tid"]); ?>','<?php echo ($type["labelname"]); ?>');">修改</a>&nbsp;&nbsp;&nbsp;<a onclick="return ensure('确定要删除此分类及其子分类？')" href="__URL__/prodtype_remove/tid/<?php echo ($type["tid"]); ?>/path/<?php echo ($type["path"]); ?>">移除</a>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>

				</table><script>
						function ensure(str){
							var msg=window.confirm(str);
							if(msg){
								return true;
							}else{
								return false;
							}
							
						}
						function modiName(id,name){
							EV_modeAlert('modiname');
							$('#lname').val(name);
							$('#lid').val(id);
						}
					</script>
				
				
			</div>
		</form>
		 <div id="modiname" class="show_pop"  style="width:400px;">  	
       
        <form id="tform2" method="post" action="__URL__/prodtype_modify">
	<table width="100%" height="150" align="center">
	<tr><td>输入新名称：</td><td><input type="text" name="labelname" id="lname"  /><input type="hidden" name="tid" id="lid" /></td></tr>
	<tr><td align="right"><input type="submit" value=" 更 改 " /></td><td><input type="button" onclick="javascript:EV_closeAlert();" name="" value=" 取 消 " /></td></tr>
	</table>

   </form>    
</div>

    </body>
</html>