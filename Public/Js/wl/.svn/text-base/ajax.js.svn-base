var aj=new Object();

aj.request=function(){

	//因为ie7及以上版本以及火狐，GOOGLE浏览器全部都用的是XMLHttpRequest对象
	//而ie6及以下版本和有些早期版本使用的是ActiveXOjbect对象来操作ajax
	if(window.XMLHttpRequest){
		
		var ajax=new window.XMLHttpRequest;
		return ajax;	
		
	}else{
		var ajax=false;

		var arr=['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];

		for(i=0;i<arr.length;i++){
			try{		
				ajax=new ActiveXObject(arr[i]);

				return ajax;

			}catch(e){

				ajax=false;
			}	
		}
	}
}


aj.ajax=aj.request();


//post方法需要传入三个内容，一个是url一个是data发送什么数据给服务器，第三是回调函数，处理完成服务器返回的数据交给回调函数，回调函数决定怎么使用数据
aj.post=function(data,url,callback){

	aj.ajax.open('post',url);
	aj.ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	aj.ajax.send(data);

	//判断状态的一个成员方法
	aj.handle(callback);

}

//get方法只需要传入URL，因为是通过url来传递数据的,传递完成后，把服务器返回的数据交给callback,在callback当中来使用
aj.get=function(url,callback){
	
	aj.ajax.open('get',url);
	aj.send(null);

	aj.handle(callback);


}

aj.handle=function(callback){

	aj.ajax.onreadystatechange=function(){
		if(aj.ajax.readyState==4){
			if(aj.ajax.status==200){

				callback(aj.ajax.responseText);
			}
			
		}



	}


}


