<?php
	class LeaveAction extends CommonAction {
		public function index(){
			//请假审核
			if(Session('permLevel')==2){
				/***权限等级,全局范围***/
				$user=allusers();
				$level=true;
			}elseif(Session('permLevel')==1){
				/***权限等级,仅部门范围***/
				$user=same_depart_man();
				$level=false;
			}
			if(!$level){
				$smUser=null;
				foreach($user as $val){
					$smUser[]=$val['uid'];
				}
				$where['uid']=array('in',$smUser);
			}
			$where['status']='1';
			$where['action']='qj';
			$leave=D('leave')->where($where)->order('ctime desc')->select();
			
			$this->assign('leave_show',$leave);
			$this->display();
			
		
		}
		
		public function wc_list(){
			//请求外出
			if(Session('permLevel')==2){
				/***权限等级,全局范围***/
				$user=allusers();
				$level=true;
			}elseif(Session('permLevel')==1){
				/***权限等级,仅部门范围***/
				$user=same_depart_man();
				$level=false;
			}
			if(!$level){
				$smUser=null;
				foreach($user as $val){
					$smUser[]=$val['uid'];
				}
				$where['uid']=array('in',$smUser);
			}
			$where['status']='1';
			$where['action']='wc';
			$leave=D('leave')->where($where)->order('ctime desc')->select();
			$this->assign('wc_show',$leave);
			$this->display();
		
		}
		
		public function apply(){
			//审批
			$save['authman']=Session('uname');
			$save['lasttime']=time();
			if(empty($_POST['zhun'])){
				$save['status']='0';
			}else{
				$save['status']='2';
			}
			$save['auth_reason']=trim($_POST['reason']);
			if(D('leave')->where('id='.$_POST['sid'])->save($save)){
				$this->success('已审核成功',$_SERVER['HTTP_REFERER']);
			}else{
				$this->error('系统出错，请稍候再试',$_SERVER['HTTP_REFERER']);
			}
		}
	
	}

?>