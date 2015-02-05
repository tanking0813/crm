 if(!+'\v1') {  
    (function(f){  
        window.setTimeout =f(window.setTimeout);  
        window.setInterval =f(window.setInterval);  
    })(function(f){  
        return function(c,t){  
            var a=[].slice.call(arguments,2);  
            return f(function(){  
                c.apply(this,a)},t)  
            }  
    });  
}  
 function onbookpic(){
document.getElementById("bookpic").click(); 
return false; 
 }
      function onvideo(){
	  leibiequxiao();
document.getElementById("onvideo").style.display = "block";

	  document.getElementById("whatleibie").value ="5";	
 }
     function onziliao(){
	 leibiequxiao();
document.getElementById("onziliao").style.display = "block";

	  document.getElementById("whatleibie").value ="4";	
 }
   function onafriend(){
   document.getElementById("affriend").style.display = "block";
 document.getElementById("afriend").value ="1";	
 }
     function xonafriend(){
   document.getElementById("affriend").style.display = "none";
 }
 
  function onxuanshang(){
  	 leibiequxiao();
document.getElementById("onxuanshang").style.display = "block";
	  document.getElementById("whatleibie").value ="2";	
 }
   function ondaoshi(){
   	 leibiequxiao();
document.getElementById("ondaoshi").style.display = "block";
document.getElementById("whatleibie").value ="3";		  
 }
function fbdpkuang() {

}
function add_friend(thisObj,Uid,Username) {
var mess = document.getElementById("content").value; 
aaee = mess+ '@' + Username + ' ' ;
document.getElementById("content").value = aaee;
}
function leibiequxiao(){
	  document.getElementById("ondaoshi").style.display ="none";
	  document.getElementById("onxuanshang").style.display ="none";
	    document.getElementById("onziliao").style.display ="none";
	  document.getElementById("onvideo").style.display ="none";
	document.getElementById("whatleibie").value ="1";		
document.getElementById("content").style.height ="70px"; 	
 document.getElementById("pTitle").innerText="";	
}
function quxiao(){
	  document.getElementById("ondaoshi").style.display ="none";
	  document.getElementById("onxuanshang").style.display ="none";
	    document.getElementById("onziliao").style.display ="none";
	  document.getElementById("onvideo").style.display ="none";
	document.getElementById("whatleibie").value ="1";		 
document.getElementById("content").value =""; 
document.getElementById("content").style.height ="70px"; 
 document.getElementById("pTitle").innerText="";	
  document.getElementById("afriend").value ="0";	
  }
function insertTitle(tValue){
   var t1 = tValue.lastIndexOf("\\");
   var t2 = tValue.lastIndexOf(".");
   if(t1 >= 0 && t1 < t2 && t1 < tValue.length){
    document.getElementById("pTitle").innerText= tValue.substring(t1 + 1);
   }
  }
function adjustObjHeight(obj, defaultHeight) {
    if(obj.scrollHeight > defaultHeight) {
        obj.style.height = obj.scrollHeight + 'px';
    } else {
        obj.style.height = defaultHeight + 'px';
    }
}
window.onload = function() {
    var obj = document.getElementsByTagName('textarea');
    var len = obj.length;
    for(var i = 0; i<len; i++)
        adjustObjHeight(obj[i], 20);
}

function onxingxi(thisObj,Num){
var messa=document.getElementById("messagea"+"_"+Num);
var mess=document.getElementById("message"+"_"+Num);
messa.innerHTML= mess.innerHTML;
}
function closexingxi(thisObj,Num){
var messa=document.getElementById("messagea"+"_"+Num);
var messb=document.getElementById("messageb"+"_"+Num);
messa.innerHTML= messb.innerHTML;
}

  function onhuifu(thisObj,Username,Num,Uid){
document.getElementById("hf"+"_"+Num).value = Uid;
document.getElementById("hff"+"_"+Num).value ="";
document.getElementById("hff"+"_"+Num).value ='回复@'+ Username+" "+'：';
 }
   function textonfocus(thisObj,Num){
document.getElementById("hff"+"_"+Num).style.height ="50px";
document.getElementById("hffhf"+"_"+Num).style.display ="block";
 }


 function onlide(thisobj,NUM,e){
 e=e||event;
var ox=e.clientX-10;
var oy=e.clientY-10;
var isIE=!!window.ActiveXObject;
var isIE6=isIE&&!window.XMLHttpRequest;
if(isIE6) {
var ieh=getScrollTop();
oy=ieh+oy;
}
document.getElementById("linshi").style.left=ox+'px';
document.getElementById("linshi").style.top=oy+'px';
document.getElementById("linshi").style.display= "block";
 ajaxget('my.php?mod=myaj&w=32&wh=1&uid='+NUM, 'linshi');

}

function xxxanfriend(thisObj,Num){
document.getElementById("linshi").style.display="block";
}
function xanfriend(thisObj,Num){
document.getElementById("linshi").style.display="none";
}
function onshouuid(thisobj,NUM){
  var x = thisobj.getBoundingClientRect().left;
   var y = thisobj.getBoundingClientRect().top;
var ox=x;
var oy=y;
var isIE=!!window.ActiveXObject;
var isIE6=isIE&&!window.XMLHttpRequest;
if(isIE6) {
var ieh=getScrollTop();
oy=ieh+oy;
}
document.getElementById("showuid").style.left=ox+'px';
document.getElementById("showuid").style.top=oy+'px';
document.getElementById("showuid").style.display= "block";
ajaxget('my.php?mod=myaj&w=32&uid='+NUM, 'showuid');


}
function onshouid(thisObj,Num){
document.getElementById("showuid").style.display="block";
}
function donshowuid(thisObj,Num){
document.getElementById("showuid").style.display="none";
}
function getScrollTop()
{
    var scrollTop=0;
    if(document.documentElement&&document.documentElement.scrollTop)
    {
        scrollTop=document.documentElement.scrollTop;
    }
    else if(document.body)
    {
        scrollTop=document.body.scrollTop;
    }
    return scrollTop;
}
var timer = null;
function callback(thisObj,num) {
onshouuid(thisObj,num);
}
function cleaar() {
document.getElementById("showuid").style.display="none";
   clearTimeout(timer);
}
function onSecondDelay(callback,thisObj,num,event) {
    clearTimeout(timer);
var isIE=!!window.ActiveXObject;
if(isIE) {
timer =window.setTimeout(callback, 500,thisObj,num);
}
else {
    timer = setTimeout(callback, 500,thisObj,num);
	}
}

//获取元素的纵坐标
function getTop(e){
var offset=e.offsetTop;
if(e.offsetParent!=null) offset+=getTop(e.offsetParent);
return offset;
}
//获取元素的横坐标
function getLeft(e){
var offset=e.offsetLeft;
if(e.offsetParent!=null) offset+=getLeft(e.offsetParent);
return offset;
}
function getPos(obj){
 var pos = {"top":0, "left":0};
 if (obj.offsetParent){
   while (obj.offsetParent){
     pos.top += obj.offsetTop;
     pos.left += obj.offsetLeft;
     obj = obj.offsetParent;
   }
 }else if(obj.x){
   pos.left += obj.x;
 }else if(obj.x){
   pos.top += obj.y;
 }
 return pos;
}
