<?php if (!defined('THINK_PATH')) exit();?><!--<tr><th width="30%">客户名称</th><th>联系人</th><th><a href="javascript:listTable.sort('payment',<?php echo ($order); ?>,'<?php echo ($param); ?>'); ">成交金额</a><img id="sortImg" src="__PUBLIC__/Images/wl/sort_desc.gif "/></th><th>IP</th><th width="10%">合同结束时间</th><th>客户类型</th><th>所属销售</th><th>操作</th></tr>-->
				<?php if(is_array($cust)): $i = 0; $__LIST__ = $cust;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cm): $mod = ($i % 2 );++$i;?><tr align="center" id="varitk_<?php echo ($key); ?>">
				<td  width="40%">
				<?php if($cm["custype"] == 1): ?><a href="__URL__/view/id/<?php echo ($cm["num"]); ?>/salename/<?php echo ($cm["uname"]); ?>?<?php echo ($param); ?>" style="text-decoration:none;color:green" title = "客户详情"><?php echo ($cm["cusname"]); ?></a>
				<?php elseif($cm["custype"] == 2): ?>
					<a href="__URL__/view/id/<?php echo ($cm["num"]); ?>/salename/<?php echo ($cm["uname"]); ?>?<?php echo ($param); ?>" style="text-decoration:none;color:blue" title = "客户详情"><?php echo ($cm["cusname"]); ?></a>
				<?php elseif($cm["custype"] == 3): ?>
					<a href="__URL__/view/id/<?php echo ($cm["num"]); ?>/salename/<?php echo ($cm["uname"]); ?>?<?php echo ($param); ?>" style="text-decoration:none;color:#666" title = "客户详情"><?php echo ($cm["cusname"]); ?></a>
				<?php else: endif; ?>
				</td>
				<td width="20%"><?php echo (($cm["contact"])?($cm["contact"]):'无'); ?></td>
				<!--
				<td><?php echo (($cm["vp_money"])?($cm["vp_money"]):'0.00'); ?></td>
			
				<td><div  id="pipvar<?php echo ($key); ?>" style="border:1px dashed green;width:150px;overflow-x:scroll;"><?php echo (($cm['products'][0]['ip'])?($cm['products'][0]['ip']):'无'); ?></div></td>
				<td width="10%" id="ptovar<?php echo ($key); ?>"><?php echo ((date('Y-m-d',$cm['products'][0]['totime']))?(date('Y-m-d',$cm['products'][0]['totime'])):'无'); ?></td></div>
				-->

				<script type="text/javascript">
				<?php echo 'if(typeof tpi'.$key.' === "undefined"){'; echo 'var tpi'.$key.'=null;'; echo '}else{'; echo 'clearInterval(tpi'.$key.');'; echo '}'; echo 'var pip_'.$key.'=new Array();'; echo 'var pto_'.$key.'=new Array();'; foreach($cm['products'] as $val){ echo "pip_".$key.".push('".$val['ip']."</td>');"; echo "pto_".$key.".push('".date('Y-m-d',$val['totime'])."</td>');"; } echo 'var _i'.$key.'=0;'; echo 'tpi'.$key.'=setInterval(function(){'; echo '$("#pipvar'.$key.'").html(pip_'.$key.'[_i'.$key.']);'; echo '$("#ptovar'.$key.'").html(pto_'.$key.'[_i'.$key.']);'; echo '_i'.$key.'+=1;'; echo 'if(_i'.$key.'==pip_'.$key.'.length){'; echo '_i'.$key.'=0;'; echo '}'; echo '},5000);'; ?>
				</script>
<!-- 				<td><?php echo (get_cus_type($cm["custype"])); ?></td>-->				
				<td width="20%">
				<?php echo ($cm["uname"]); ?>
				</td>
				<td width="20%">
				<!--
				<?php if(check_permission('Kehu:view') != false): ?><a href="__URL__/view/id/<?php echo ($cm["num"]); ?>?<?php echo ($param); ?>">查看</a><?php endif; ?>
				-->
				<?php if(check_permission('Kehu:edit_cusinfo') != false): ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="__URL__/edit_cusinfo/cusid/<?php echo ($cm["num"]); ?>?<?php echo ($param); ?>">编辑</a><?php endif; ?>
				
				<?php if(check_permission('Kehu:add_order') != false): ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="__URL__/add_order/id/<?php echo ($cm["num"]); ?>?<?php echo ($param); ?>">开通产品</a><?php endif; ?>

				</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<tr align="center"><td colspan="9" align="center"><?php echo ($page); ?>&nbsp;&nbsp;&nbsp每页显示<select name="per_page" onchange="search(this.value);">
				<option value="0">-选择-</option>
				<option value="20" <?php if(($_GET['per_page']) == "20"): ?>selected<?php endif; ?>>20</option>
				<option value="40" <?php if(($_GET['per_page']) == "40"): ?>selected<?php endif; ?>>40</option>
				<option value="60" <?php if(($_GET['per_page']) == "60"): ?>selected<?php endif; ?>>60</option>
				<option value="80" <?php if(($_GET['per_page']) == "80"): ?>selected<?php endif; ?>>80</option>
				<option value="100" <?php if(($_GET['per_page']) == "100"): ?>selected<?php endif; ?>>100</option>
				<option value="all" <?php if(($_GET['per_page']) == "all"): ?>selected<?php endif; ?>>全部</option>
				</select></td></tr>