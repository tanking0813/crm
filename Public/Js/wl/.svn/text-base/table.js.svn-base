/*表格内容js
 * 效果：快速编辑
 *
 */
var list={goods_id:'编号',goods_name:'商品名称',goods_sn:'货号',shop_price:'价格',is_onsale:'上架',is_best:'精品',is_new:'新品',is_hot:'热销',order_number:'订单号',pay_time:'下单时间',goods_total:'总金额',must_pay:'应付金额',};
var listTable=new Object();
//快速编辑---排序
listTable.controllor=controllor;
listTable.action=action;
listTable.sort=function(info,order){
	if(typeof(arguments[2])!='undefined'){
		var act=listTable.controllor+'/'+arguments[2];
	}else{
		var act=listTable.controllor+'/'+listTable.action[0];
	}
	var order=!order?1:0;
	var p_src=['sort_desc.gif','sort_asc.gif'];
	var s=($('#sortImg').attr('src')).split('/');
	s.pop();
	if(order){
			p_src=s.join('/')+'/'+p_src[order];
	
	}else{
			p_src=s.join('/')+'/'+p_src[order];
				
	}
			
	$.post(url+act,'field='+info+'&order='+order,function(back){
		$('body').html(back)
		var hah=list[info];
		$('#sortImg').insertAfter($('th>a:contains('+hah+')'));
		$('#sortImg').attr({src:p_src});
							

	})
}
//快速编辑---商品编辑
listTable.edit=function(obj,info,num){

	var tag,reg,sendable=true;
	var $p=$(obj).html();
	if($p.match(/\d+\.?(\d{0,2})?/g)){
		reg=/^\d+\.?(\d{0,2})?/g;
		tag='number';	
	}else if($p.match(/[a-zA-z_]+\w*/g)){
		reg=/^[a-zA-z_]+\w*/g;
		tag='string';
	}
	var $l=$(obj).text().length;
	
	//编辑框的鼠标事件
	if($('#charu').html()==null){

		$(obj).empty();
		
		$(obj).wrapInner('<input id="charu" type="text" name="'+info+'"/>');

		$('#charu').attr({size:$l}).val($p).focus().blur(function(){
			var $up_value=$(this).val();
			
			switch(tag){
				case 'number':
					if(!reg.test($up_value)){
						alert('请输入数值型');
						sendable=false;
					}else{
						sendable=true;
					}
					break;
				case 'string':
				      if(!reg.test($up_value)){
				      		alert('请输入正确的格式');
						sendable=false;
				      }else{
				      		sendalbe=true;
				      }
					break;
			}
		
			
			if(sendable){
			       $(this).replaceWith($up_value);
				$.post(url+listTable.controllor+'/'+listTable.action[1],'vid='+num+'&'+info+'='+$up_value);
			}
					
		})
	}else{
		//return false;
	}
}
//快速编辑---商品状态切换
listTable.toggle=function(obj,info,num){
	var p_src=['yes.gif','no.gif'];

	var s=($(obj).attr('src')).split('/');
		//alert(url+listTable.controllor+'/'+listTable.action[1]);
	if(s.pop()=='yes.gif'){
		p_src=s.join('/')+'/'+p_src[1];
	
		$(obj).attr({src:p_src});

		$.post(url+listTable.controllor+'/'+listTable.action[1],'vid='+num+'&'+info+'=0',function(data){
			//alert(data);
		});
	}else{
		p_src=s.join('/')+'/'+p_src[0];
		$(obj).attr({src:p_src});

		$.post(url+listTable.controllor+'/'+listTable.action[1],'vid='+num+'&'+info+'=1',function(data){
			//alert(data);
		});
	
	}

}

//回收站
listTable.remove=function(num, info){
//alert(url+listTable.controllor+'/'+listTable.action[1]);
	var $msg=confirm(info);
	if($msg){

		$('tr[name=remove_tr]').has('input[value="'+num+'"]').remove();
		
		$.post(url+listTable.controllor+'/'+listTable.action[2],'vid='+num,function(data){
			//alert(data);
		});
	}else{
		return false;
	}
}
//还原
listTable.restore=function(num){

		$('tr[name=recycle_tr]').has('input[value="'+num+'"]').remove()
		$.post(url+listTable.controllor+'/'+listTable.action[2],'vid='+num+'&type=restore');

}
//删除
listTable.drop=function(num,info){
	var $msg=confirm(info);
	if($msg){
		$('tr[name=recycle_tr]').has('input[value="'+num+'"]').remove()
		$.post(url+listTable.controllor+'/'+listTable.action[2],'vid='+num+'&type=drop');
	}else{
		return false;
	}	
}

