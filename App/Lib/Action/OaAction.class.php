<?php

	class OaAction extends Action {
		public function _initialize(){
			load("@common");
			if(empty($_SESSION['uid'])){
				$this->redirect("Public/login");
			}
		
		
		}
		
		public function index(){
			$time=time();
			$needtime=gate_kq_time();
			//dump($needtime);
			//dump($map);
			//echo date('Y-m-d H:i:s',1356190231);
			$Kqr=D('kq_record');
			$where['uid']=Session('uid');
			$up['uid']=Session('uid');
			if($time>=$needtime['am_s']&&$time<=$needtime['am_e']){
				//在上班打卡段内
				$where['time']=array(array('egt',$needtime['am_s']),array('elt',$needtime['am_e']));//上班段
				$this->assign('dksj','s');//
				if($ykao=$Kqr->where($where)->find()){
					$this->assign('sbdk',date('Y-m-d H:i:s',$ykao['time']));//已打卡
					$this->assign('updesc','<a  href="javascript:;" onclick="reason_write('.$ykao['id'].');">情况说明</a>');
					if($kqa['time']>=$needtime['std_up']){
						$this->assign('delay','&nbsp;&nbsp;&nbsp;迟到');//已打卡
					}
				}else{
			
					$this->assign('sbdk','<input type="button" name="sb" value="上班登记" onclick="shangban();" />');//未打卡
					
					if($time>=$needtime['std_up']){
						$this->assign('delay','&nbsp;&nbsp;&nbsp;迟到');//已打卡
					}

				}
				

				
			}elseif($time>=$needtime['pm_s']&&$time<=$needtime['pm_e']){
				//下班打卡段内
				$where['time']=array(array('egt',$needtime['pm_s']),array('elt',$needtime['pm_e']));//下班段
				$up['time']=array(array('egt',$needtime['am_s']),array('elt',$needtime['pm_e']));
				$up['mark']='up';
				$this->assign('dksj','x');//
				if($ykao=$Kqr->where($up)->find()){
					
					$this->assign('kaed','已登记');
					$this->assign('updesc','<a  href="javascript:;" onclick="reason_write('.$ykao['id'].');">情况说明</a>');
				}else{
					$this->assign('kaed','未登记');
				}
				if($kpa=$Kqr->where($where)->find()){
					$this->assign('downdesc','<a  href="javascript:;" onclick="reason_write('.$kpa['id'].');">情况说明</a>');
					$this->assign('xbdk',date('Y-m-d H:i:s',$kpa['time']));//已打卡
					if($kpa['time']<$needtime['std_down']){
						$this->assign('delay','&nbsp;&nbsp;&nbsp;早退');//已打卡
					}
				}else{
			
					$this->assign('xbdk','<input type="button" name="xb" value="下班登记" onclick="xiaban();" />');//未打卡
					if($time<$needtime['std_down']){
						$this->assign('delay','&nbsp;&nbsp;&nbsp;早退');//已打卡
					}
				}
			
			}else{
				$where['time']=array(array('egt',$needtime['am_s']),array('elt',$needtime['pm_e']));//下班段
				$kpa=$Kqr->where($where)->select();
				foreach($kpa as $v){
					if($v['mark']=='up'){
						$upmess='已登记';
					}else{
						$upmess='未登记';
					}
					if($v['mark']=='down'){
						$downmess='已登记';
					}else{
						$downmess='未登记';
					}
				}
				$this->assign('upmess',$upmess);
				$this->assign('downmess',$downmess);
				
			}
			
			$this->assign('kaoqin',$needtime);
			
			$Lea=D('leave');
			$lv['uid']=Session('uid');
			$lv['action']='qj';
			$leave=$Lea->where($lv)->order('ctime desc')->select();
			$this->assign('history',$leave);
			
			$wc['uid']=Session('uid');
			$lv['action']='wc';
			$wcRec=$Lea->where($lv)->order('ctime desc')->select();
			$this->assign('waichu',$wcRec);
	
			$this->display();
		
		}
		
		public function daka(){
			$stdtime=gate_kq_time();
			if(isset($_POST['sbt'])){
				$data['mark']=$_POST['mark'];
				//$data['note']=trim($_POST['note']);
				$data['time']=time();
				if($_POST['mark']=='up'){
					$data['delay_time']=round(($data['time']-$stdtime['std_up'])/60);
				}elseif($_POST['mark']=='down'){
					$data['delay_time']=round(($stdtime['std_down']-$data['time'])/60);
				
				}
				$data['uid']=Session('uid');
				if(D('kq_record')->add($data)){
					echo date('Y-m-d H:i:s',$data['time']);
				}else{
					echo 0;
				}
			
			}
			
		}
		
		public function ask_leave(){
			$Leav=D('leave');
            if(!$Leav->autoCheckToken($_POST)){
                    $this->error('请不要重复提交',$_SERVER['HTTP_REFERER']);
            }
			$data['reason']=trim($_POST['reason']);
			$data['leave_type']=$_POST['leave_type'];
			$s_h=empty($_POST['leave_start_h'])?'00':trim($_POST['leave_start_h']);
			$s_m=empty($_POST['leave_start_m'])?'00':trim($_POST['leave_start_m']);
			$e_h=empty($_POST['leave_end_h'])?'00':trim($_POST['leave_end_h']);
			$e_m=empty($_POST['leave_end_m'])?'00':trim($_POST['leave_end_m']);
			$data['leave_start']=strtotime($_POST['leave_start'].' '.$s_h.':'.$s_m);
			$data['leave_end']=strtotime($_POST['leave_end'].' '.$e_h.':'.$e_m);
			
			$data['is_warn']=$_POST['is_warn'];
			$data['uid']=Session('uid');
			$data['username']=Session('uname');
			$data['action']='qj';
			$data['ctime']=time();
			
			if($Leav->add($data)){
				$this->success('请假完成，请耐心等待结果',__URL__);
			}else{
				$this->error('出错啦！请稍候再试',$_SERVER['HTTP_REFERER']);
			}
			
		}
		public function ask_waichu(){
            $Leav=D('leave');
            if(!$Leav->autoCheckToken($_POST)){
                    $this->error('请不要重复提交',$_SERVER['HTTP_REFERER']);
            }
			$data['reason']=trim($_POST['wc_reason']);
			$s_h=empty($_POST['wc_leave_start_h'])?'00':trim($_POST['wc_leave_start_h']);
			$s_m=empty($_POST['wc_leave_start_m'])?'00':trim($_POST['wc_leave_start_m']);
			$e_h=empty($_POST['wc_leave_end_h'])?'00':trim($_POST['wc_leave_end_h']);
			$e_m=empty($_POST['wc_leave_end_m'])?'00':trim($_POST['wc_leave_end_m']);
			$data['leave_start']=strtotime($_POST['wc_leave_start'].' '.$s_h.':'.$s_m);
			$data['leave_end']=strtotime($_POST['wc_leave_end'].' '.$e_h.':'.$e_m);
			$data['uid']=Session('uid');
			$data['username']=Session('uname');
			$data['ctime']=time();
			$data['action']='wc';
			if($Leav->add($data)){
				$this->success('登记完成',__URL__);
			}else{
				$this->error('出错啦！请稍候再试',$_SERVER['HTTP_REFERER']);
			}
		}
		
		public function modiReason(){
			$save['note']=trim($_POST['rtext']);
			$where['id']=$_POST['kqid'];
			if(D('kq_record')->where($where)->save($save)){
				$this->success('添加成功',__URL__);
				
			}else{
				$this->error('添加失败',__URL__);
			}
			
		
		}
	
		
		public function kq_history_search(){
			$st=strtotime($_GET['stime']);
			$ed=strtotime($_GET['etime'].' 23:59:59');
		
			$where['uid']=Session('uid');//"19";
			$where['time']=array(array('egt',$st),array('lt',$ed));
			$kqin=D('kq_record')->where($where)->select();
			$kqq=array();
			
			//$start=;$end=1356233187;
			for($i=$st;$i<=$ed;$i+=86400){
				$diff=date('Y-m-d',$i);
				$kqq[$i]=array();
				foreach($kqin as $key=>$v){
					$do=date('Y-m-d',$kqin[$key]['time']);
					
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
		
	
	
	}


?>