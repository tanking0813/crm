/*后台页面使用特效
 * 上传框及编辑框的增减特效
 *
 */
//浏览器兼容性:判断浏览器类型
var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

//获取事件源
function findEventSrc(e){
	var targ;
	
	if (!e) var e = window.Event;
	if (e.target) targ = e.target
	
	if (e.currentTarget) targ=e.currentTarget
	if (e.srcElement) targ = e.srcElement
	if (targ.nodeType == 3) // defeat Safari bug
	targ = targ.parentNode;

	return targ;

}
function addVolumePrice(){

	var tb_s=document.getElementById('tbody-volume');

		var tb_c=document.createElement('tr');

		tb_c.innerHTML='<td><a onmousedown="delVolumePrice(event)" href="javascript:void(0)"> [-]</a>优惠数量 <input type="text" name="volume_number[]" size="8" value="" />优惠价格 <input type="text" name="volume_price[]" size="8" value="" /></td>';

		tb_s.appendChild(tb_c);
	

}


function delVolumePrice(e){

	var a_node=findEventSrc(e);
	var del_node=a_node.parentNode;
	if(!Browser.isIE) del_node=a_node.parentNode.parentNode;
	document.getElementById('tbody-volume').removeChild(del_node);

}


//页底button特效
function changeAction(){

	if($('input[name="checkboxes[]"]').filter(':checked').length==0){
	
		return false;

	}
	

	switch($('#selAction').val()){

		case 'trash':

			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_delete');
			$('input[name=code]:eq(0)').val('1');

			break;


		case 'on_sale':
			$('#btnSubmit').attr({disabled:false});
	
			$('input[name=act]:eq(0)').val('is_onsale');
			$('input[name=code]:eq(0)').val('1');	

			break;

		case 'not_on_sale':
			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_onsale');
			$('input[name=code]:eq(0)').val('0');
			break;

		case 'best':
			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_best');
			$('input[name=code]:eq(0)').val('1');
			break;

		case 'not_best':
			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_best');
			$('input[name=code]:eq(0)').val('0');
			break;

		case 'new':
			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_new');
			$('input[name=code]:eq(0)').val('1');
			break;

		case 'not_new':
			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_new');
			$('input[name=code]:eq(0)').val('0');
			break;

		case 'hot':
			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_hot');
			$('input[name=code]:eq(0)').val('1');
			break;

		case 'not_hot':
			$('#btnSubmit').attr({disabled:false});
			$('input[name=act]:eq(0)').val('is_hot');
			$('input[name=code]:eq(0)').val('0');
			break;

		default:
			$('#btnSubmit').attr({disabled:true});
			$('input[name=act]:eq(0)').val('');
			$('input[name=code]:eq(0)').val('');
		

	
	
	}

}


function confirmSubmit(obj){
		if(($('#selAction').val())=='trash'){			
				var $con=confirm('确定要删除吗?');	
				if($con){
						//$obj.submit();
						return true;	
				
				}else{
					return false;
				}
		
		}else{

			//$obj.submit();
			return true;
		}

	
}		
function submit(){
	if($('input[name=goods_name]:eq(0)').val()&&$('select[name=cat_id]:eq(0)').val()&&$('input[name=goods_price]:eq(0)').val()){
		$('form[name=theForm]:eq(0)').submit();
	}else{
		return false;
	}

}	

	/*
	var $s=$('input[name="checkboxes[]"]');
	var $sel=$('#selAction');

	var arr=new Array();
	for(i=0;i<$s.length;i++){
		arr[i]=$s.eq(i).val();
	}

	var str='';
	switch($('input[type=hidden]:eq(0)').val()){
		case '1':
			str='&is_deleted=1';
			break;
		case '2':
			str='&is_onsale=1';
			break;
		case '3':
			str='&is_onale=0';
			break;
		case '4':
			str='&is_best=1';
			break;
		case '5':
			str='&is_best=0';
			break;
		case '6':
			str='&is_new=1';
			break;
		case '7':
			str='&is_new=0';
			break;
		case '8':
			str='&is_hot=1';
			break;
		case '9':
			str='&is_hot=0';
			break;
		case '':
			break;

	
	
	
	}
	*/
