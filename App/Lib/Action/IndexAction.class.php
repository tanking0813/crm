<?php
class IndexAction extends CommonAction {
    public function index(){
		$this->display();
    }	
		
		function top(){
			$this->display();
		}
		
		function left(){
			$this->display();
		}
		
		function zhu(){
			$MAn=D('cus_info');
			$date=time();
			$cron['uid']=Session('uid');
			$cron['nexttime']=array('egt',$date);
			$cron_total=D('cron')->where($cron)->select();
			foreach($cron_total as &$v){
				$da=$MAn->Field('cusname,contact,mobile,qq')->where('id='.$v['cusid'])->find();
				$v['cusname']=$da['cusname'];
				$contact=explode(',',$da['contact']);
				$mobile=explode(',',$da['mobile']);
				$qq=explode(',',$da['qq']);
				$v['contact']=$contact[0];
				$v['mobile']=$mobile[0];
				$v['qq']=$qq[0];
			}
			$this->assign('cron_total',$cron_total);
			$tm=mktime (0 , 0, 0, date('m',$date),1, date('Y',$date));
			
			$order=$MAn->query('select count(c.id) as count,u.uid,u.uname,u.rank from '.C('DB_PREFIX').'cus_info as c,'.C('DB_PREFIX').'user as u where u.department=2 and c.salemanId=u.uid group by c.salemanId order by count desc');
		
			$this->assign('gold',$order[0]);
		
			$cus['ctime']=array('egt',$tm);
			$cus['salemanId']=Session('uid');
		
			$total_cus=$MAn->where($cus)->select();
		
			$this->assign('total_cus',count($total_cus));
			$Odp=D('ProdView');
			$orderwhere['order_ctime']=array('egt',$tm);
			$orderwhere['salemanId']=Session('uid');
			$total_order=$Odp->Field('order_id')->where($orderwhere)->select();
			//dump($Odp->getLastSql());
			$this->assign('total_order',count($total_order));
			$tpm=null;
			foreach($total_order as $vbs){
				$tpm[]=$vbs['order_id'];
			}
			$finance['product_id']=array('in',$tpm);
			$finance['is_on']='enabled';
			$finance['from']=array('egt',$tm);
			$total_payment=D('order')->where($finance)->sum('payment');
			$total_paid=D('order')->where($finance)->sum('paid');
			$this->assign('total_payment',$total_payment);
			$this->assign('total_paid',$total_paid);
			$where['uid']=Session('uid');
			$where['status']=array('egt','1');
			$where['is_warn']='1';
			$message=D('leave')->Field('id')->where($where)->select();
			$this->assign('message',$message);
			
			$Tr=D('title_reader');
			$readed=$Tr->Field('notice_id')->where('reader='.Session('uid'))->select();
			$Titl=D('title');
			$array=array(0);
			if($readed){
				foreach($readed as $v){
					array_push($array,$v['notice_id']);
				}
			}
			$mapsql['id']=array('NOT IN',$array);
			$notice=$Titl->where($mapsql)->select();
			$this->assign('notice',$notice);
			$fdata=$this->fetch();
			$this->display();
		}
		
		public function show_cron(){
			$MAn=D('cus_info');
			$date=time();
			$cron['uid']=Session('uid');
			$cron['nexttime']=array('egt',$date);
			$cron_total=D('cron')->where($cron)->select();
			foreach($cron_total as &$v){
				$da=$MAn->Field('cusname,contact,mobile,qq')->where('id='.$v['cusid'])->find();
				$v['cusname']=$da['cusname'];
				$contact=explode(',',$da['contact']);
				$mobile=explode(',',$da['mobile']);
				$qq=explode(',',$da['qq']);
				$v['contact']=$contact[0];
				$v['mobile']=$mobile[0];
				$v['qq']=$qq[0];
			}
			$this->assign('cron_total',$cron_total);
			$fdata=$this->fetch();
			$this->ajaxReturn($fdata,'succ',1);
		
		
		}
		
		public function show_message(){
			$Lv=D('leave');
			$where['uid']=Session('uid');
			$where['is_warn']='1';
			$where['status']=array('neq','1');
			$message=$Lv->Field('id,reason,ctime,status,action')->where($where)->select();
			//$fdata=$Lv->getLastSql();
			$this->assign('leave',$message);
			$fdata=$this->fetch();
			$this->ajaxReturn($fdata,'succ',1);
		}
		
		public function show_notice(){
			$uid=Session('uid');
			$Tr=D('title_reader');
			$readed=$Tr->Field('notice_id')->where('reader='.$uid)->select();
			$Titl=D('title');
			$array=array(0);
			if($readed){
				foreach($readed as $v){
					array_push($array,$v['notice_id']);
				}
			}
			$map['id']=array('NOT IN',$array);
			$notice=$Titl->where($map)->select();
		
			$this->assign('notice',$notice);
			$fdata=$this->fetch();
			$this->ajaxReturn($fdata,'succ',1);
		}
		
		public function read_message(){
			$save['is_warn']='0';
			$Lea=D('leave');
			if($Lea->where('id='.$_POST['mid'])->save($save)){
				echo 1;
			}else{
				echo 0;
			}
		}
		
		public function read_notice(){
			$Lea=D('title_reader');
			$add['notice_id']=$_POST['nid'];
			$add['reader']=Session('uid');
			$add['rtime']=time();
			if($Lea->add($add)){
				echo 1;
			}else{
				echo 0;
			}
		}
}