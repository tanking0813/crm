<?php
	class DailyAction extends Action {
	
		public function _initialize(){
			load("@common");
			if(empty($_SESSION['uid'])){
				$this->redirect("Public/login");
			}
		
		
		}
		
		public function index(){
			$where['uid']=Session('uid');
			$DR=D('daily_record');
			$Rp=D('daily_reply');
			$limit=20;
			import("ORG.Util.Page");
			$total_count=$DR->where($where)->count('id');
			$page=new Page($total_count,$limit);
			$daily=$DR->where($where)->order('lasttime desc')->limit($page->firstRow.','.$page->listRows)->select();
			
			foreach($daily as &$v){
				$v['reply_total']=$Rp->where('daid='.$v['id'])->count();
				$v['reply']=$Rp->where('daid='.$v['id'])->order('time desc')->select();
				$v['content']=htmlspecialchars_decode($v['content']);
			}
			$this->assign('daily',$daily);
			$this->assign('page',$page->show());
			$this->display();
		}
		
		public function write_daily(){
			$where['did']=Session('group');
			$depart=D('department')->where('did='.Session('group'))->getField('dname');
		
			$this->assign('depart',$depart);
			$this->display();
		
		}
		
		public function ventChk(){
			//dump($_POST);
            $DI=D('daily_record');
            if(!$DI->autoCheckToken($_POST)){
                $this->error('请不要重复提交',__URL__);
            }
			$data['title']=trim($_POST['title']);
			$data['type']=$_POST['type'];
			$data['content']=htmlspecialchars(stripslashes($_POST['myVent']));//$_POST['myVent'];
			$data['uid']=Session('uid');//$_POST['title']);
			$data['time']=time();
			$data['lasttime']=time();
			//dump($data);
			if($DI->add($data)){
				$this->success('添加成功',__URL__);
			}else{
				$this->error('添加失败',__URL__);
			}
		
		}
		
		public function edit_daily(){
			$where['id']=$_GET['daily_id'];
			$daily=D('daily_record')->where($where)->find();
			$daily['content']=addslashes(htmlspecialchars_decode($daily['content']));
			$this->assign('daily',$daily);
			$this->display();
		
		}
		
		public function edit_daily_save(){
			$where['id']=$_POST['daily_id'];
			$data['title']=trim($_POST['title']);
			$data['type']=$_POST['type'];
			$data['content']= htmlspecialchars(stripslashes($_POST['myVent']));//$_POST['myVent'];	
			$data['lasttime']=time();
			if(D('daily_record')->where($where)->save($data)){
				$this->success('修改成功',__URL__);
			}else{
				$this->error('未作修改，情稍后再试',$_SERVER['HTTP_REFERER']);
			}
		}
		
		
		public function delete_daily(){
		
			$mp['id']=array('in',$_POST['dai_id']);
			if(D('daily_record')->where($mp)->delete()){
				$this->success('已删除',__URL__);
			}else{
				$this->error('请稍候再试',$_SERVER['HTTP_REFERER']);
			}
			
		}
		
		public function detail(){
		
			$where['id']=$_GET['daily_id'];
			$dai=D('daily_record')->where($where)->find();
		
			$dai['content']=htmlspecialchars_decode($dai['content']);
			
			$this->assign('dl',$dai);
			$this->display();
		
		}
		
		
		public function seek(){
			$parse=parse_url($_SERVER['REQUEST_URI']);
		
			$this->assign('param',$parse['query']);
			$now=time();
			
			if(Session('permLevel')==2){
				/***权限等级,全局范围***/
				$user=allusers();
				$level=true;
			}elseif(Session('permLevel')==1){
				/***权限等级,仅部门范围***/
				
				$user=same_depart_man();
				$level=false;
			}
			$this->assign('alluser',$user);
			
			if(empty($_GET['time'])){
				$where['lasttime']=array(array('egt',$now-86400),array('lt',$now));
			}else{
				$where['lasttime']=array(array('egt',strtotime($_GET['time'])),array('lt',$now));
			}
			if(!empty($_GET['user'])){
				$where['uid']=$_GET['user'];
			}else{
				if(!$level){
					$smUser=null;
					foreach($user as $val){
						$smUser[]=$val['uid'];
					}
					$where['uid']=array('in',$smUser);
				}
			
			}
			$where['type']='j';
			$DR=D('daily_record');
			$Rp=D('daily_reply');
			$limit=15;
			import("ORG.Util.Page");
			$total_count=$DR->where($where)->count('id');
			$page=new Page($total_count,$limit,$parse['query']);
			$daily=$DR->where($where)->order('lasttime desc')->limit($page->firstRow.','.$page->listRows)->select();
			foreach($daily as &$v){
				$v['reply_total']=$Rp->where('daid='.$v['id'])->count();
				$v['reply']=$Rp->where('daid='.$v['id'])->order('time desc')->select();
				$v['content']=htmlspecialchars_decode($v['content']);
			}
			$this->assign('daily',$daily);
			$this->assign('page',$page->show());
			$this->display();
		}
		
		public function daily_reply(){
			$Rep=D('daily_reply');
			$add['daid']=$_POST['reply_id'];
			$add['reply']=$_POST['content'];
			$add['time']=time();
			$add['reperson']=Session('uname');
			if($Rep->add($add)){
				die('succ');
			}else{
				die('err');
			}
		}
	}

?>