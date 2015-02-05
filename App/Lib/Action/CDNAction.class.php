<?php
	class CDNAction extends CommonAction {
		public function index(){
			$resource=D('cdn_resource')->where('creator='.Session('uid'))->order('ctime desc')->select();
			//dump($resource);
			$this->assign('resource',$resource);
			$this->display();
		
		}

		public function auth(){
			$Cdn=D('cdn_resource');
			$res=$Cdn->where('status!=0')->order('ctime desc')->select();
			foreach($res as &$v){
				switch($v['status']){
					case '1':
						if(check_permission('CDN:auth:2')){
							$v['chuli']='<a href="javascript:;" onclick="cdn_shenpi('.$v['id'].',\'2\')">总经办审批</a>';
						}
						break;
					case '2':
						if(check_permission('CDN:auth:3')){
							$v['chuli']='<a href="javascript:;" onclick="cdn_caigou('.$v['id'].',\'3\',\''.$v['resource'].'\')">采购</a>';
						}
						break;
					case '3':
						if(check_permission('CDN:auth:0')){
							$v['chuli']='<a href="javascript:;" onclick="cdn_ruzhang('.$v['id'].',\''.$v['money'].'\')">入账</a>';
						}
						break;
				}
			}
			$this->assign('resource',$res);
			$this->display();
		}
		
		
		public function ask_resource(){
			$this->display();
		
		}
		
		
		public function apply(){
			//dump($_POST);
			$Cdn=D('cdn_resource');
			$data['creator']=Session('uid');
			$data['creator_text']=Session('uname');
			$data['ctime']=time();
			$data['reason']=trim($_POST['reason']);
			if($Cdn->add($data)){
				$this->success('已申请，请等待审核',$_SERVER['HTTP_REFERER']);
			}else{
				$this->error('系统出错，请稍后再试',$_SERVER['HTTP_REFERER']);
			}
		
		}
		
		public function shenpi(){
			
			$id=$_POST['sid'];
			$mess=D('cdn_resource')->where('id='.$id)->find();
			$tag=false;
			switch($_POST['buzhou']){
				case 2:
					if($_POST['zhun']==1){
						$save['status']=2;
						$save['firstman']=Session('uid');
						$save['resource']=$_POST['resource'];
						$save['firsttime']=time();
					}else{
						$save['status']=0;
						$save['lastman']=Session('uid');
						$save['lastman_text']=Session('uname');
						$save['last_content']=$_POST['reason'];
						$save['lasttime']=time();
						$tag='拒绝';
					}
					break;
				case 3:
					$save['status']=3;
					$save['lastman']=Session('uname');
					$save['last_content']=$_POST['last_content'];
					$save['lasttime']=time();
					$save['money']=$_POST['money'];
					$tag='通过';
					break;
			}
			//dump($save);
			if(D('cdn_resource')->where('id='.$id)->save($save)){
				if($tag){
					//添加系统提醒
					$message['relation_table']=C('DB_PREFIX').'cdn_resource';
					$message['relation_id']=$id;
					$message['uid']=$mess['creator'];
					$message['message']=$tag;
					D('message')->add($message);
				}
				$this->success('已审核',$_SERVER['HTTP_REFERER']);
			}else{
				$this->error('系统出错，请稍候再试',$_SERVER['HTTP_REFERER']);
			}
		
		}
		
		public function ruzhang(){
			
			$add['note']=$_POST['rz_note'];
			$add['ptable']=C('DB_PREFIX').'cdn_resource';
			$add['pid']=$_POST['sid'];
			$add['oparator']=Session('uid');
			$add['oparator_text']=Session('uname');
			$add['time']=time();
			$add['money']=$_POST['money'];
			$add['note']=$_POST['rz_note'];
			$add['purpose']='CDN资源购买';
			if(D('finger')->add($add)){
				$save['status']=0;
				D('cdn_resource')->where('id='.$_POST['sid'])->save($save);
				$this->success('成功入账',$_SERVER['HTTP_REFERER']);
			}else{
				$this->success('系统错误，请稍后再试',$_SERVER['HTTP_REFERER']);
			}
		}
	}
	

?>