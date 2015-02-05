<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-cn" lang="zh-cn">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <meta name="Copyright" content="Copyright (c) 2009 thinkPHP.cn" />
        <meta name="generator" content="" />
        <meta name="Keywords" content="中光电信" />
        <meta name="description" content="中光电信" />
<style type="text/css">
	#container{width:1000px;background:#fff;}
	.srchbutton {height:26px;width:60px;border:1px solid #3079ED;border-radius: 2px 2px 2px 2px;background:url(__PUBLIC__/Images/css/search_button.png) #4A8BF5 no-repeat 22px 6px;padding-right: 3px;cursor: pointer;}
	.zhidao_search_bar{width:900px;height:35px;line-height:40px;}
	.zhidao_search_result{width:1000px;margin:5px auto;}
	.zhidao_search_result_item{float:left;width:910px;margin-top:5px;margin-left:10px;}
	.result_title{width:900px;height:30px;line-height:30px;}
	.result_title a{color:blue;text-decoration:underline;}
	.result_title a:link{color:blue;text-decoration:underline;}
	.result_content{width:900px;margin-top:2px;}
	.result_page{width:900px;height:30px;line-height:30px;margin:4px auto;text-align:center;}
	.time_line{font-size:12px;width:900px;height:16px;line-height:16px;margin-top:2px;font-style:italic;}
</style>
<title><?php echo ($title); ?> - 中光电信</title>
</head><body style="background:#fff;">
<div id="container">
			<div class="zhidao_search_bar">
			<form action="__SELF__" method="get" class="cf">
			<input type="text" name="keyword" style="border:4px insert #ddd;width:300px;height:30px;line-height:30px;size:14px;" value="<?php echo ($_GET['keyword']); ?>" />&nbsp;&nbsp;<input class="srchbutton" type="submit" value="&nbsp;" onclick="search();" title="搜索" />
	 		</form>
		</div>
	<div class="zhidao_search_result">
	<?php if(is_array($search_result)): $i = 0; $__LIST__ = $search_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vp): $mod = ($i % 2 );++$i;?><div class="zhi dao_search_result_item">
		<div class="result_title"><a href="__URL__/detail/docid/<?php echo ($vp["id"]); ?>"><?php echo ($vp["content"]); ?></a></div>
		<div class="result_content"><?php echo ($vp["note"]); ?></div>
		<div class="time_line"><?php echo ($vp["lastman"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vp["endtime"]); ?></div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>
	<div style="clear:both;"></div>
	<div class="result_page"><?php echo ($showpage); ?></div>
	</div>
</div>
	
		<script language="javascript">
			
			</script>		
    </body>
</html>