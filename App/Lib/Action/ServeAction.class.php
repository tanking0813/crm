<?php
// 本类由系统自动生成，仅供测试用途
class ServeAction extends CommonAction{
	public function index(){
		$this->display();
	
	}
	//查询
	public function search(){
		if(!empty($_GET['status'])){
			$map['status']=$_GET['status'];
		}
		if(!empty($_GET['cname'])){
			$map['ctime']=array(array('egt',strtotime($_GET['cname'])),array('elt',time()));
			
		}
		if(!empty($_GET['content'])){
			$map['content']=array('like','%'.trim($_GET['content']).'%');
		}
		
		if(!empty($_GET['cusname'])){
			$map['cusname']=array('like','%'.trim($_GET['cusname']).'%');
		}
	
		$Ser=D('service_rec');
		$server=$Ser->where($map)->order('ctime desc')->select();
		$this->assign('server',$server);
		$fdata=$this->fetch('searchAjax');
		$this->ajaxReturn($fdata,'succ',1);
	
	
	}
	//添加售后服务记录
	public function add_srecord(){
		$time=time();
		if(empty($_POST['cusname'])){
			$this->display();
		}else{
			$data=array_map('trim',$_POST);
			$data['content']=htmlspecialchars($data['content']);
			$data['note']=htmlspecialchars($data['note']);
			$data['ctime']=strtotime($data['ctime']);
			$data['endtime']=$time;
			$data['lastman']=Session('uname');
			$Ser=D('service_rec');
            
			$cus['cusname']=$data['cusname'];
			$cus['cusid']=D('cus_info')->where($cus)->getField('id');
			if(!$cus['cusid']){
				$this->error('用户输入有误');
			}
            if(!$Ser->autoCheckToken($data)){
                 $this->error('请不要重复提交');
            }
			if($Ser->add($data)){
				
				$cus['note']='提交客户反馈信息';
				$cus['uname']=Session('uname');
				$cus['time']=$time;
				if(D('handle')->add($cus)){
					;
				}else{
					//$time=time();
					$str=date('Y-m',$time);
					$path='CRM_ERROR'.$str.'.log';
					$content="\r\n".date('Y:m:d-H:i:s',$time)."   CUSTOMERID:".iconv('utf-8','gb2312//IGNORE',$cus['cusname'])."   INFO:".iconv('utf-8','gb2312//IGNORE',$cus['note'])."   USERNAME:".iconv('utf-8','gb2312//IGNORE',$cus['uanme'])."|CREATE ERROR!\n\r";
					write_log(LOG_PATH.$path,$content);
				}
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		
		}
	}
	//处理售后服务记录
	public function doneIt(){
	
		if(empty($_POST['doId'])){
			$map['id']=$_GET['docid'];
			$Ser=D('service_rec');
			$cus=$Ser->where($map)->find();
			///echo $Ser->getLastSql();
			$this->assign('msg',$cus);
		
			$this->display('doneIt');
		}else{
			$Serv=D('service_rec');
			$where['id']=$_POST['doId'];
			$data['ip']=$_POST['ip'];
			$data['lastman']=Session('uname');
			$data['content']=htmlspecialchars($_POST['content']);
			$data['note']=htmlspecialchars($_POST['note']);
			$data['endtime']=time();
			$data['status']=$_POST['status'];
			if($Serv->where($where)->save($data)){
				$this->success('修改成功',__URL__);
			}else{
				$this->error('未做任何修改');
			}
		}

	}
	//客服记录详细信息
	public function detail(){
			$map['id']=$_GET['docid'];
			$Ser=D('service_rec');
			$cus=$Ser->where($map)->find();
			///echo $Ser->getLastSql();
			$this->assign('msg',$cus);
			$Pd=D('ProdView');
			$mpd['cusname']=$cus['cusname'];
			$out=$Pd->where($mpd)->select();
			foreach($out as &$val){
				$t=D('user')->where('uid='.$val['techID'])->getField('uname');
				$val['tech']=$t;
				if(!empty($val['store'])){
					$val['position']=get_jgcate_name($val['store']);
				}else{
					$val['position']='无';
				}
			}
			
			$this->assign('usrtable',$out);	
			$server_d=D('server')->where('sid='.$_GET['docid'])->order('time desc')->select();
			$this->assign('server_d',$server_d);
			$this->display();
	
	}
	//用户快捷输入AJAX调用
	public function cusAjaxBack(){
		$Cus=D('Cus_info');
		if(!empty($_GET['cusname'])&&mb_strlen($_GET['cusname'])){
			$map['cusname']=array('like','%'.$_GET['cusname'].'%');
		
			$data=$Cus->Field('cusname')->where($map)->limit('0,10')->select();
			if(!empty($data)){
				$this->assign('fullname',$data);
				$ret=$this->fetch('jsonback');
				$this->ajaxReturn($ret,'succ',1);
			}else{
				$this->ajaxReturn('','err',0);
			}
		}else{
			$this->ajaxReturn('','err',0);
		}
	}
	public function serverTop(){
		$this->assign('prolist',get_cate());
		$this->assign('sale',saleman());
		$this->display();
	}
	//服务次数排名
	public function serverTopAjax(){
		$Ser=D('service_rec');
		$start=strtotime($_GET['starttime']);
		$end=strtotime($_GET['endtime']);
		$where=' and (s.ctime between '.$start.' and '.$end.') ';
		if(!empty($_GET['saleman'])){
			$where.=' and c.salemanId='.$_GET['saleman'];
		}
		
		$freq=$Ser->query('SELECT count(s.cusname) as frequency,s.id,s.status,s.ctime,s.ip,c.id as cid,c.cusname,c.contact,c.mobile,c.email,c.qq ,c.salemanId FROM '.C('DB_PREFIX').'service_rec as s  join '.C('DB_PREFIX').'cus_info as c  on s.cusname=c.cusname  where s.status=3 '.$where.' group by s.cusname order by frequency  desc limit 0,10');
	
		foreach($freq as &$val){
			$val['contact_list']=array(
									'contact'=>explode('|',$val['contact']),
									
									'mobile'=>explode('|',$val['mobile']),
								
									'email'=>explode('|',$val['email']),
									'qq'=>explode('|',$val['qq']),
									
									);
									
			$val['contact']=$val['contact_list']['contact'][0];
			$val['mobile']=$val['contact_list']['mobile'][0];
			$val['qq']=$val['contact_list']['qq'][0];
		
		}
		
		$this->assign('freq',$freq);
		$back=$this->fetch();
		$this->ajaxReturn($back,'succ',1);
	
	}
	
	public function top_detail(){
		$Pd=D('ProdView');
		$mpd['cus_id']=$_GET['cid'];
		$out=$Pd->where($mpd)->select();
		$this->assign('usrtable',$out);
		$this->display();
	}
	
	public function zhidao(){
		$Dser=new Model();//D('service_record');
		$keyword=trim($_GET['keyword']);
		if($keyword){
			import('ORG.Util.Page');
			$total_result=$Dser->query('select id,lastman,endtime,content,note  from '.C('DB_PREFIX').'service_rec  where content like "%'.$keyword.'%" or note like "%'.$keyword.'%"');
			$total_count=count($total_result);
			$page=new Page($total_count,11);
			$result=$Dser->query('select id,lastman,endtime,content,note  from '.C('DB_PREFIX').'service_rec  where content like "%'.$keyword.'%" or note like "%'.$keyword.'%" order by endtime desc limit '.$page->firstRow.','.$page->listRows);
			//echo $Dser->getLastSql();
			$this->assign('showpage',$page->show());
			foreach($result as &$v){
				$v['content']=str_replace($keyword,'<font color="red">'.$keyword.'</font>',strip_tags(htmlspecialchars_decode($v['content'])));
				$v['note']=str_replace($keyword,'<font color="orange">'.$keyword.'</font>',strip_tags(htmlspecialchars_decode($v['note'])));
				$v['endtime']=date('Y-m-d H:i',$v['endtime']);
			}
		}
		
		$this->assign('search_result',$result);
		
		$this->display();
	
	}
	public function jiansuo(){
			$this->display();
	}
	public function jiansuosearch(){
		$data = array();
		 if(!empty($_GET['caozuoname'])){
			$data['user'] = array('like','%'.$_GET['caozuoname'].'%');
		}
		if(!empty($_GET['pro'])){
			$data['labelname'] = array('like','%'.$_GET['pro'].'%');
		}
		if(!empty($_GET['username'])){
			$data['cusname'] = array('like','%'.$_GET['username'].'%');
		}
		if(!empty($_GET['username'])){
			$data['cusname'] = array('like','%'.$_GET['username'].'%');
		} 
		 if(!empty($_GET['cname'])){
			$data['time']= array(array('egt',strtotime($_GET['cname'])),array('elt',strtotime($_GET['sname'])))	;
		} 
		if($_GET['status'] == 1){
				$reult = D('OhView');
				$date = $reult->where($data)->select();
				$this->assign('date',$date); 
				$fdata=$this->fetch('jiansuosearchAjax');
				$this->ajaxReturn($fdata,'succ',1); 
				}
		if($_GET['status'] == 2){
				$reult = D('HaView');
				$date = $reult->where($data)->select();
				$this->assign('date',$date); 
				$fdata=$this->fetch('jiansuosearchAjax');
				$this->ajaxReturn($fdata,'succ',1); 
				}
/* 		if($_GET['status'] == 3){
				$user_log = M('user_login_record');
				$date = $user_log->select();
				$this->assign('date',$date); 
				$fdata=$this->fetch('jsearchAjax');
				$this->ajaxReturn($fdata,'succ',1);
			} */
	}
}
?>