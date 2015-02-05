<?php

	class SysAction extends Action {
		public function _initialize(){
			load("@common");
			if(empty($_SESSION['uid'])){
				$this->redirect("Public/login");
			}
	
			
			$permission=check_permission(MODULE_NAME.':'.ACTION_NAME);
			
			if(!$permission){
			
				$this->error('权限不足');
			}
		}
	
		public function index(){
			$user=D('user')->Field('uid,uname')->select();
			$this->assign('user',$user);
			$this->display();
		}
		
		
		public function search(){
			$st=strtotime($_GET['stime']);
			$ed=strtotime($_GET['etime'].' 23:59:59');
			//if($st>$ed){
				//$st=$ed-86400;
			//}
			$where['uid']=$_GET['uid'];
			$name=D('user')->where('uid='.$_GET['uid'])->getField('uname');
			$where['time']=array(array('egt',$st),array('lt',$ed));
			$kqin=D('kq_record')->where($where)->select();
			
			for($i=$st;$i<=$ed;$i+=86400){
				$diff=date('Y-m-d',$i);
				$kqq[$i]=array();
				foreach($kqin as $key=>$v){
					$do=date('Y-m-d',$kqin[$key]['time']);
					$kqq[$i]['uname']=$name;
					//$diff=$diff['mday'];
					if($do==$diff&&$kqin[$key]['mark']=='up'){
						$kqq[$i]['u_time']=$kqin[$key]['time'];
						$kqq[$i]['u_mark']=$kqin[$key]['mark'];
						$kqq[$i]['u_note']=$kqin[$key]['note'];
						$kqq[$i]['u_delay_time']=$kqin[$key]['delay_time'];
					}elseif($do==$diff&&$kqin[$key]['mark']=='down'){
						$kqq[$i]['d_time']=$kqin[$key]['time'];
						$kqq[$i]['d_mark']=$kqin[$key]['mark'];
						$kqq[$i]['d_note']=$kqin[$key]['note'];
						$kqq[$i]['d_delay_time']=$kqin[$key]['delay_time'];
					}
					
				}
			}
			$this->assign('kq',$kqq);
			$fdata=$this->fetch();
			$this->ajaxReturn($fdata,'succ',1);
		
		
		}
		
		public function searchLeave(){
			$Leave=D('leave');
			$condition['uid']=$_GET['uid'];
			$condition['ctime']=array('between',array(strtotime($_GET['stime']),strtotime($_GET['etime'].' 23:59:59')));
			$condition['status']='2';
			$lv=$Leave->where($condition)->select();
			$this->assign('wc_and_qj',$lv);
			$fdata=$this->fetch();
			$this->ajaxReturn($fdata,'succ',1);
		
		}
		public function edit_time(){
			//in
			if(isset($_POST['sbt'])){
				$save1['am_s']=trim($_POST['am_s5']);
				$save1['am_e']=trim($_POST['am_e5']);
				$save1['pm_e']=trim($_POST['pm_e5']);
				$save1['pm_s']=trim($_POST['pm_s5']);
				$save1['std_up']=trim($_POST['std_up5']);
				$save1['std_down']=trim($_POST['std_down5']);
				//$save['fangan']=$_POST['fa'];
				$save1['id']=1;
				$save2['am_s']=trim($_POST['am_s6']);
				$save2['am_e']=trim($_POST['am_e6']);
				$save2['pm_e']=trim($_POST['pm_e6']);
				$save2['pm_s']=trim($_POST['pm_s6']);
				$save2['std_up']=trim($_POST['std_up6']);
				$save2['std_down']=trim($_POST['std_down6']);
				//$save2['fangan']=$_POST['fa'];
				$save2['id']=2;
				
				$Cf=D('kaoqin_conf');
				if($Cf->add($save1,null,true)&&$Cf->add($save2,null,true)){
				
					$this->success('配置成功',__URL__);
				}else{
					$this->error('配置成功',__URL__);
				}
				
			
			}else{
				$confa=D('kaoqin_conf')->where('id=1')->find();
				$confb=D('kaoqin_conf')->where('id=2')->find();
				$this->assign('confa',$confa);
				$this->assign('confb',$confb);
				//dump($conf);
				$this->display();
			}
		}
		
		
		public function other(){
		
		
		
		}
	}

?>