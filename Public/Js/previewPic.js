var picPath;
var image;
// preview picture
function preview(container){
	// 下面代码用来获得图片尺寸，这样才能在IE下正常显示图片
	document.getElementById(container).innerHTML
	= "<img width='500' height='300' src='"+picPath+"' />";
}
function loadImage(ele,container) {
	picPath   = getPath(ele);
	image     = new Image();
	image.src = picPath;
	preview(container);
}
function getPath(obj){
	if(obj){
		//ie
		if (window.navigator.userAgent.indexOf("MSIE")>=1){
			obj.select();
			// IE下取得图片的本地路径
			return document.selection.createRange().text;
		}
		//firefox
		else if(window.navigator.userAgent.indexOf("Firefox")>=1){
			if(obj.files){
				// Firefox下取得的是图片的数据
				return obj.files.item(0).getAsDataURL();
			}
			return obj.value;
		}
		return obj.value;
	}
}