<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

class PublicAction extends Action {
	// 检查用户是否登录
	protected function checkUser() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('jumpUrl','/Public/login');
			$this->error('没有登录');
		}
	}
	
//用户登录函数
public function checklogin() {
		$username=trim($_POST['username']);
		$password=trim($_POST['password']);
		if(empty($username)||empty($password)){
			$this->user_jilu($_POST);
			$this->error('请输入用户名及密码',$_SERVER['HTTP_REFERER']);
		}
		if($_SESSION['verify'] != md5(trim($_POST['verify']))) {
			$this->user_jilu($_POST);
			$this->error('验证码错误',$_SERVER['HTTP_REFERER']);
		}else{
			$user=M('user');
			$map['loginname']=trim($_POST['username']);
			$map['password'] = md5($_POST['password']);
			$userlist=$user->where($map)->find();
			
			if(empty($userlist)){	
				$this->user_jilu($_POST);			
				$this->error('帐号或者密码错误',$_SERVER['HTTP_REFERER']);
			}
		//	dump($userlist);
			if($userlist['userswitches'] !=1 || empty($userlist['userswitches'])){
				$this->error('该用户被禁用','login');
			}
				load("@common");
				$stdtime=gate_kq_time();
				$now=time();
				//if($now>=$stdtime['am_s']&$now<=$stdtime['pm_e']){
			
					Session('loginname',trim($_POST['username']));
					Session('uname',$userlist['uname']);//将用户名写入Session
					Session('uid',$userlist['uid']);
					Session('perm',$userlist['perm']);
					Session('group',$userlist['department']);
					Session('inherit',$userlist['inherit']);
					Session('userswitches',$userlist['userswitches']);
					Session('permLevel',$userlist['permLevel']);
				//	dump($_SESSION);
					$this->user_login();
				//	exit;
					$this->redirect('Index/index');
				//}else{
				//	$this->redirect('Error/index');
				//}
			
		}
}
private function user_jilu($arr){
	import("ORG.Net.IpLocation");
	$user_login_record = M('user_login_record');
	//dump($user_login_record);
		$data[uid]='';
		$data[user]=$arr['username'];
		$data[optime]=time();
		$data[login_ip]=get_client_ip();
	//	print_r($data);
		$dd=$user_login_record->add($data);	
	//	dump($dd);
	return $dd;
}
private function user_login(){
		import("ORG.Net.IpLocation");
			$user_login_record = M('user_login_record');
			//dump($user_login_record);
				$data[uid]=Session('uid');
				$data[user]=Session('loginname');
				$data[optime]=time();
				$data[login_ip]=get_client_ip();
			//	print_r($data);
				$dd=$user_login_record->add($data);	
		//	dump($dd);
			return $dd;
	}

	public function logout(){
		$_SESSION=null;
		session_destroy();
		$this->success('欢迎下次再来',__APP__);
	
	}
	// 用户登录页面
	public function login() {
		 $this->display();
	
	}

		// 用户注册个人信息
	public function regname() {
	$uid=Session('uid');
	$this->assign('uid',$uid);
	if(empty($_POST['username'])) {		$this->display();  
	}	else {
	$user=M('User');
	$username=$_POST['username'];
	$condition['uid'] = $uid;
	$result=$user-> where($condition)->setField('username',$username);
	if($result !==false) {	
	Session('username','$username');
	$this->redirect("Index/index");
	} else {
echo $result ;
	}
	}
	}
	
		

	// 修改资料
	public function change() {
		$this->checkUser();
		$User	 =	 D("User");
		if(!$User->create()) {
			$this->error($User->getError());
		}
		$result	=	$User->save();
		if(false !== $result) {
			$this->success('资料修改成功！');
		}else{
			$this->error('资料修改失败!');
		}
	}

    // 更换密码
    public function changePwd()
    {
		$this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据
		if(md5($_POST['verify'])	!= $_SESSION['verify']) {
			$this->error('验证码错误！');
		}
		$map	=	array();
        $map['password']= pwdHash($_POST['oldpassword']);
        if(isset($_POST['account'])) {
            $map['account']	 =	 $_POST['account'];
        }elseif(isset($_SESSION[C('USER_AUTH_KEY')])) {
            $map['id']		=	$_SESSION[C('USER_AUTH_KEY')];
        }
        //检查用户
        $User    =   M("User");
        if(!$User->where($map)->field('id')->find()) {
            $this->error('旧密码不符或者用户名错误！');
        }else {
			$User->password	=	pwdHash($_POST['password']);
			$User->save();
			$this->assign('jumpUrl',__APP__.'/Public/main');
			$this->success('密码修改成功！');
         }
    }
	
	// 验证码显示
    public function verify()
    {
        import("ORG.Util.Image");
        Image::buildImageVerify();
    }

}
?>