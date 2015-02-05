<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-cn" lang="zh-cn">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"  />
  <title>中光电信CRM</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/General.css" /><link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/main.css" />
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript">
if (top.location !== self.location) {
	top.location = self.location;
}
 function getCookie(c_name){
     if (document.cookie.length > 0) {
         c_start = document.cookie.indexOf(c_name + "=")
         if (c_start != -1) { 
             c_start = c_start + c_name.length + 1;
             c_end = document.cookie.indexOf("^",c_start);
             if (c_end==-1)
                 c_end=document.cookie.length;
             return unescape(document.cookie.substring(c_start,c_end));
     } 
   }
     return "";
 }
 
 function setCookie(c_name, n_value, p_name, p_value, expiredays)        //设置cookie
 {
     var exdate = new Date();
     exdate.setDate(exdate.getDate() + expiredays);
     document.cookie = c_name + "=" + escape(n_value) + "^" + p_name + "=" + escape(p_value) + ((expiredays == null) ? "" : "^;expires=" + exdate.toGMTString());
    // console.log(document.cookie)
 }
 
 function checkCookie()      //检测cookie是否存在，如果存在则直接读取，否则创建新的cookie
 {
    // alert(document.cookie)
     var username = getCookie('username');
     var password = getCookie('password');
     if (username != null && username != "" && password != null && password != "") {
       document.getElementById('username').value=username;
	   document.getElementById('password').value=password;
	   //alert('Your name: ' + username + '\n' + 'Your password: ' + password);
	   $('#remem').attr('checked',true);
	
     }else {
		$('#remem').attr('checked',false);
     }
  
 }
 
 function cleanCookie (c_name, p_name) {     //使cookie过期
     document.cookie = c_name + "=" + ";" + p_name + "=" + ";expires=Thu, 01-Jan-70 00:00:01 GMT";
 }
 
 function remember_me(obj){
		if($(obj).attr('checked')==true){
			var user=document.getElementById('username').value;
			var pass=document.getElementById('password').value;
			setCookie('username',user,'password',pass,30);
		}else{
			cleanCookie('username','password');	
		}
}
 </script>
</head>
<body style="background:#278296" onLoad="checkCookie();">
<form method="post" action="__URL__/checklogin" name="theForm">
  <table width="30%" cellspacing="0" cellpadding="0" style="margin-top: 100px" align="center">
   <tr>
        <td class="label">管理员姓名：</td>
        <td><input type="text" name="username" id="username" /></td>
		<td></td>
      </tr>
      <tr>
        <td class="label">管理员密码：</td>
        <td><input type="password" name="password" id="password" /></td>
		<td></td>
      </tr>
        <tr>
        <td class="label">验证码：</td>
        <td><input type="text" name="verify" class="capital" /></td><td><img width="80" height="30" style="cursor:pointer;" title="刷新验证码" src="__URL__/verify" id="verifyImg" onclick="this.src='__URL__/verify?'+Math.random();" />
      </td></tr>
       <tr><td class="label">记住密码</td><td><input type="checkbox"  onclick="remember_me(this);" id="remem" /></td><td></td></tr>  
      <tr><td>&nbsp;</td><td><input type="submit" value="进入管理中心" class="button"  /></td><td></td></tr>
 
  </table>
  <input type="hidden" name="act_this" value="signin" />
</form>
</body>
</html>