<?php
	class BBSAction extends Action {
		public function _initialize(){
			load("@common");
			if(empty($_SESSION['uid'])){
				$this->redirect("Public/login");
			}
		
		
		}
		public function index(){
			$content=D('title')->Field('id,uid,title,ctime')->order('ctime desc')->select();
			$User=D('user');
			foreach($content as &$v){
				$v['username']=$User->where('uid='.$v['uid'])->getField('uname');
			
			}
			$this->assign('content',$content);
			$this->display();
		}
		
		public function  publish(){
			
			$this->display();
		}
		public function ventChk(){
            $Title=D('title');
            if(!$Title->autoCheckToken($_POST)){
               $this->error('请不要重复提交',__URL__);
            }
			$data['title']=trim($_POST['title']);
			$data['title_type']=$_POST['title_type'];
			$data['content']= htmlspecialchars(stripslashes($_POST['myVent']));//$_POST['myVent'];
			$data['uid']=Session('uid');//$_POST['title']);
			$data['ctime']=time();
		
			if($Title->add($data)){
				$this->success('添加成功',__URL__);
			}else{
				$this->error('添加失败',__URL__);
			}
		
		}
		
		public function title_detail(){
			$cont=D('title')->where('id='.$_GET['id'])->find();
			$cont['content']=htmlspecialchars_decode($cont['content']);
			$cont['publisher']=D('user')->where('uid='.$cont['uid'])->getField('uname');
			$this->assign('cont',$cont);
			$reply=D('title_reply')->where('tid='.$_GET['id'])->select();
			$this->assign('reply',$reply);
			$this->display();
		}
		
		public function add_click(){
			isset($_POST['title_id']) or die();
			$Tit_rep=D('title');
			$where['id']=$_POST['title_id'];
			$Tit_rep->where($where)->setInc('clicked');
		}
		
		public function title_reply(){
			$Rep=D('title_reply');
			$add['tid']=$_POST['reply_id'];
			$add['reply']=$_POST['content'];
			$add['time']=time();
			$add['rep_name']=Session('uname');
			if($Rep->add($add)){
				die('succ');
			}else{
				die('err');
			}     
		
		}
	}
?>