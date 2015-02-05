<?php if (!defined('THINK_PATH')) exit();?><tr><th>客户名</th><th>产品名</th><th>IP&nbsp;/&nbsp;域名</th><th>存放位置</th><th>销售人</th><th>成交金额</th><th><a href="javascript:listTable.sort('fromtime',<?php echo ($shunxu); ?>,'<?php echo ($param); ?>'); ">开始时间</a></th><th><a href="javascript:listTable.sort('totime',<?php echo ($shunxu); ?>,'<?php echo ($param); ?>'); ">到期时间</a><img id="sortImg" src="__PUBLIC__/Images/wl/sort_desc.gif "/></th><th>状态</th><th>操作</th></tr>
			<?php if(is_array($order)): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$od): $mod = ($i % 2 );++$i;?><tr align="center" id="b_bkb<?php echo ($od["order_id"]); ?>">
			
			<td><a href="__APP__/Kehu/view/id/<?php echo ($od["cus_id"]); ?>?<?php echo ($param); ?>" style="text-decoration:none" title = "客户详情"><?php echo ($od["cusname"]); ?></a></td>
			<td><a href="__URL__/order_detail/num/<?php echo ($od["order_id"]); ?>?<?php echo ($param); ?>" style="text-decoration:none;" title = "客户订单详情"><?php echo ($od["labelname"]); ?></a></td>
			<td><?php
 if(empty($od['ip'])){ echo $od['domain']; }elseif(strpos($od['ip'],',')===false){ echo $od['ip']; }else{ $odip=explode(',',$od['ip']); $end=array_pop($odip); $lastip_pos=array_pop(explode('.',$end)); echo $odip[0].'-'.$lastip_pos; } ?>
			</td>
			<td><?php echo ($od["position"]); ?></td>
			<td><?php echo ($od["salename"]); ?></td>
			<td><?php echo ($od["payment"]); ?></td>
			<td><?php echo (date('Y-m-d',$od["fromtime"])); ?></td>
			<td><?php echo (order_end_check($od["totime"])); ?></td>
			<td><?php if(!empty($od['paid'])){ echo '<font color="gray">正常</font>';}else{echo '<font color="red">未入账</font>';} ?></td>
			<td>
			<!--
			<a href="__URL__/order_detail/num/<?php echo ($od["order_id"]); ?>?<?php echo ($param); ?>"><img src="__PUBLIC__/Images/wl/icon_view.gif" alt="查看" title="查看" /></a>
			-->

			<?php if(check_permission('Order:edit_order')): ?>&nbsp;&nbsp;&nbsp;<a href="__URL__/edit_order/id/<?php echo ($od["order_id"]); ?>?<?php echo ($param); ?>"><img src="__PUBLIC__/Images/wl/icon_priv.gif" alt="订单修改管理" title="订单修改管理" /></a><?php endif; ?>
			<?php if(check_permission('Order:remove_order')): ?>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="remove_order('<?php echo ($od["order_id"]); ?>')"><img src="__PUBLIC__/Images/wl/icon_trash.gif" alt="删除" title="删除" /></a><?php endif; ?></td>
			</if></tr><?php endforeach; endif; else: echo "" ;endif; ?>
			<tr align="center"><td colspan="8"><?php echo ($page); ?>&nbsp;&nbsp;&nbsp;<span style="float:right;color:orange;">应付金额统计：<?php echo ($count_payment); ?>&nbsp;&nbsp;&nbsp;实付金额统计：<?php echo ($count_paid); ?></span ></td></tr>