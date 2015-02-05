<?php
	class ExpenseAction extends CommonAction {
		public function index(){
			//申请记录
			//@Session('uid');
			$Exp=D('expense');
			$map['uid']=Session('uid');
			if(!isset($_GET['status'])){
				$map['step']=array(array('egt','1'),array('lt','5'));	
			}else{
				if($_GET['status']=='ea'){
					$map['step']=array(array('egt','1'),array('lt','5'));	
			
				}elseif($_GET['status']=='6'){
					$map['step']='6';
				}
			}
			$exlist=$Exp->where($map)->order('time desc')->select();
			$this->assign('exlist',$exlist);
			$this->display();
		}
		//申请报销
		public function application(){
			$Exp=D('expense');
            if(!$Exp->autoCheckToken($_POST)){
                $this->error('请不要重复提交');
            }
			$map['money']=$_POST['money'];
			$map['ask_type']=$_POST['ask_type'];
			$map['reason']=htmlspecialchars(trim($_POST['reason']));
			$map['uid']=Session('uid');
			$map['user_text']=Session('uname');
			$map['time']=time();
			if($Exp->add($map)){
				$this->success('已申请成功，请等待审核结果',__URL__);
			}else{
				$this->error('未申请成功,请稍候重试');
			}
		}	
		
		//审核
		public function examine(){
			$user=D('user')->Field('uid,uname')->select();
			$this->assign('user',$user);
			$map=null;
			switch($_GET['status']){
				case '0':
				case '':
					$map['step']=array(array('neq','0'),array('neq','6'));
					break;
					
				case '1':
					$map['step']='1';
					break;
				case 'neq':
					$map['step']=array(array('neq','0'),array('neq','1'));
					break;
				case 'all':
					break;
			}
			if(!empty($_GET['uid'])){
				$map['uid']=$_GET['uid'];
			}
			if(!empty($_GET['ask_type'])){
				$map['ask_type']=$_GET['ask_type'];
			}
			$Exp=D('expense');
			
			$exlist=$Exp->where($map)->order('time desc')->select();
			foreach($exlist as &$v){
				switch($v['step']){
					case '0':
						$v['chuli']='已完成';
						break;
					case '1':
						if(check_permission('Expense:examine:2')){
							$v['chuli']='<a href="javascript:;" onclick="shenpi('.$v['id'].',\'2\')">财务审批</a>';
						}
						break;
					case '2':
						if(check_permission('Expense:examine:3')){
							$v['chuli']='<a href="javascript:;" onclick="shenpi('.$v['id'].',\'3\')">总经办审批</a>';
						}
						break;
					case '3':
						if(check_permission('Expense:examine:4')){
							$v['chuli']='<a href="javascript:;" onclick="zhizhang('.$v['id'].',\'4\',\''.$v['money'].'\')">财务支帐</a>';
						}
						break;
					case '5':
						if(check_permission('Expense:examine:0')){
							$v['chuli']='<a href="javascript:;" onclick="ruzhang('.$v['id'].',\'0\',\''.$v['paid'].'\')">入账记录</a>';
						}
						break;
				
				}
			
			}
		
			$this->assign('exlist',$exlist);
			$parse=parse_url($_SERVER['REQUEST_URI']);
			$this->assign('param',$parse['query']);
			$this->display();
		}
		
		
		public function shenpi(){
			//dump($_POST);
			if($_POST['zhun']==1){
				switch($_POST['buzhou']){
					case '2':
					//财审
						$save['step']=$_POST['buzhou'];
						$save['first_man']=Session('uname');
						$save['first_time']=time();
						$save['first_reason']=$_POST['reason'];
						break;
					case '3':
					//总审
						$save['step']=$_POST['buzhou'];
						$save['second_man']=Session('uname');
						$save['second_time']=time();
						$save['second_reason']=$_POST['reason'];
						break;
					case '4':
					//支付
						$save['step']=$_POST['buzhou'];
						$save['last_man']=Session('uname');
						$save['last_time']=time();
						$save['last_note']=$_POST['reason'];
						$save['paid']=$_POST['shizhi'];
						break;
				
				}
				if(D('expense')->where('id='.$_POST['sid'])->save($save)){
					$this->success('已审核',__APP__.'/Expense/examine?'.$_POST['param']);
					
				}else{
					$this->success('系统错误，请稍候重试',__APP__.'/Expense/examine?'.$_POST['param']);
				}
			
			}else{
				$save['step']='6';//未审核通过
				$save['first_man']=Session('uname');
				$save['first_reason']=$_POST['reason'];
				$save['first_time']=time();
				
				if(D('expense')->where('id='.$_POST['sid'])->save($save)){
					$this->success('已修改',__APP__.'/Expense/examine?'.$_POST['param']);
					
				}else{
					$this->success('系统错误，请稍候重试',__APP__.'/Expense/examine?'.$_POST['param']);
				}
			}
		
		
		}
		public function ruzhang(){
			//入账写入数据库
			//dump($_POST);
                $Expens=D('expense');
                 if(!$Expens->autoCheckToken($_POST)){
                    $this->error('请不要重复提交',__APP__.'/Expense/examine?'.$_POST['param']);
                }
				$save['step']=$_POST['buzhou'];
			
				$save['finish']=Session('uname');
				$save['finish_time']=time();
				$purp=$Expens->where('id='.$_POST['sid'])->find();
				if($Expens->where('id='.$_POST['sid'])->save($save)){
					$add['ptable']=C('DB_PREFIX').'expense';//报销
					if($purp['ask_type']=='b'){
						$add['purpose']='报销账款';//报销
					}elseif($purp['ask_type']=='g'){
						$add['purpose']='发放工资';//报销
					}
					$add['pid']=$_POST['sid'];
					$add['payment']=$_POST['paid'];
					$add['money']=$_POST['paid'];
					$add['oparator']=Session('uid');
					$add['oparator_text']=Session('uname');
					$add['time']=$save['finish_time'];
					$add['note']=$_POST['note'];
					if(D('finger')->add($add)){
						$this->success('处理成功',__APP__.'/Expense/examine?'.$_POST['param']);
					}else{
						$path='CRM_ERROR_EXPENSE.log';
						$content="\r\n".date('Y:m:d-H:i:s',$add['time'])."   EXID:".$add['pid']."  MONEY:".$add['money']."   USERNAME:".iconv('utf-8','gb2312//IGNORE',$add['oparator_text'])."|OPARATOR ERROR!\n\r";
						write_log(LOG_PATH.$path,$content);
						$this->error('系统出错，稍后再试',__APP__.'/Expense/examine?'.$_POST['param']);
					}
				}else{
						
					$this->error('系统出错，稍后再试',__APP__.'/Expense/examine?'.$_POST['param']);
				}
		}
		
		public function shoukuan(){
			$save['step']='5';
			
			if(D('expense')->where('id='.$_GET['eid'])->save($save)){
				$this->success('已通知收款',$_SERVER['HTTP_REFERER']);
			}else{
				$this->success('服务期错误，请售后再试',$_SERVER['HTTP_REFERER']);
			}
		}
		
	}

?>