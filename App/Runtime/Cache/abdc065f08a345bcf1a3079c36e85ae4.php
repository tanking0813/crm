<?php if (!defined('THINK_PATH')) exit();?>	<tr><th>合同号</th><th>客户名</th><th>产品名</th><th>销售人</th><th>开始时间</th><th>到期时间</th><th>应付款</th><th>已付款</th><th>状态</th><!-- <th>操作</th> --></tr>
		
	<?php if(is_array($order)): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$od): $mod = ($i % 2 );++$i;?><tr align="center">
			<td><?php echo ($od["contract_No"]); ?></td>
			<td><a href="__APP__/Kehu/view/id/<?php echo ($od["cus_id"]); ?>?<?php echo ($param); ?>" style="text-decoration:none" title = "客户详情"><?php echo (mb_substr($od["cusname"],'0','20','utf-8')); ?></a></td>
			<td><?php echo ($od["labelname"]); ?></td>
			<td><?php echo ($od["salename"]); ?></td>
			<td><?php echo (date('Y-m-d',$od["fromtime"])); ?></td>
			<td><?php echo (order_end_check($od["totime"])); ?></td>
			<td><?php echo ($od["payment"]); ?></td>
			<td><?php echo ($od["paid"]); ?></td>
			<td>
			<?php $istime=$od['totime']-time(); $conutmany = $od['paid']+$od['tax']+$od['rebate']; if(empty($od['paid'])){ echo "<font color='blue'> <a href='__URL__/finance_save/num/".$od[order_id]."?".$param."' > 待入账 </a></font>"; }elseif($istime<=0){ echo '<font color="red">过期</font>'; }elseif($istime>0 && $istime<=604800){ echo '<font color="gray">'.ceil($istime/86400).'天后过期</font>'; }elseif ($conutmany < $od['payment'] && $conutmany > 0) { echo "<font color='blue'> <a href='__URL__/finance_save/num/".$od[order_id]."?".$param."' > 入账未完 </a></font>"; }else{ echo '<font color="green">正常</font>'; } ?></td>
			<!-- <td>
			<?php if($istime > 0): if(($od["paid"] == '0') OR ($conutmany < $od["payment"] )): ?><a href="__URL__/finance_save/num/<?php echo ($od["order_id"]); ?>?<?php echo ($param); ?>">入账</a>
				<?php else: endif; endif; ?>
			</td> -->
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>