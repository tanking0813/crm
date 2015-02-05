<?php
class OrderAction extends CommonAction{
	
	
	public function index(){
	
		$this->assign('store',get_jgcate_name());
		$parse=parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($parse['query'])) {
            parse_str($parse['query'],$params); 
        }
		$this->assign('param',$params);
		$this->assign('prolist',get_cate());
		if($_SESSION['group'] ==2){
			$user=same_depart_man();
			//dump($user);
			$this->assign('sale',$user);	
		}else{
			$this->assign('sale',saleman());
		}
		//$this->assign('sale',saleman());
		$this->display();
	
	}
	
	//12-23---new
	public function search(){
		$data='';
		if(!empty($_GET['cusname'])){
			$data['cusname']=array('like','%'.trim($_GET['cusname']).'%');
		}
		if(!empty($_GET['proid'])){
			$menu=explode('-',$_GET['proid']);
			
			$insql=findMenu(array_pop($menu),join('-',$menu));
			
			$data['pro_tid']=array('in',$insql);
		}
		if(!empty($_GET['order_ctime'])){
			$data['order_ctime']=order_ctime_sql($_GET['order_ctime']);
		
		}
		if(!empty($_GET['store'])){
			$data['store']=$_GET['store'];
		}

		if(!empty($_GET['to'])){
			if($_GET['to']=='e'){
				$data['totime']=array('elt',time());
			
			}else{
				$data['totime']=get_order_endtime($_GET['to']);
			}
			
		}
		if(!empty($_GET['ip'])){
			$data['ip']=array('like','%'.$_GET['ip'].'%');
		
		}
		$data['custype']=array('neq',7);
		$data['order_deleted']='1';
		$data['is_on']='enabled';
		$Od=D('ProdView');
		import("ORG.Util.AjaxPage"); 
		$sort=empty($_GET['field'])?'fromtime':$_GET['field'];
		$xulie=$_GET['order']?' asc':' desc';
		array_multisort($sort,$xulie, $ordr);
		$order=$_GET['order']?1:0;
		$this->assign('shunxu',$order);
		$permission=check_permission(MODULE_NAME.':'.ACTION_NAME);
		if($permission=='1'){//有独立权限
			if(!empty($_GET['salemanId'])){
				$data['salemanId']=$_GET['salemanId'];
			}
			if(Session('group')=='2'){
				$data['salemanId']=array('neq',1);
			}
			$total=$Od->where($data)->select();		
			$page=new AjaxPage(count($total),24);
			$ordr=$Od->where($data)->order($sort.$xulie)->limit($page->firstRow.','.$page->listRows)->select();
		
		}elseif($permission=='2'){//有组权限
			if(Session('group')!='2'){
			
				$total=$Od->where($data)->select();		
				$page=new AjaxPage(count($total),24);
				$ordr=$Od->where($data)->order($sort.$xulie)->limit($page->firstRow.','.$page->listRows)->select();
			
			}else{
				$data['salemanId']=Session('uid');
				$total=$Od->where($data)->select();		
				$page=new AjaxPage(count($total),24);
				
				$ordr=$Od->where($data)->order($sort.$xulie)->limit($page->firstRow.','.$page->listRows)->select();
			}
			
		}
		$total_payment=0;$total_paid=0;
		foreach($total as $v){
			$total_payment+=$v['payment'];
			$total_paid+=$v['paid'];
		}
		$this->assign('count_payment',$total_payment);
		$this->assign('count_paid',$total_paid);
		//$rdata=$Od->getLastSql();
		$show= $page->show(); 
		$Us=D('user');
		foreach($ordr as $kp=>&$vpo){
			$vpo['salename']=$Us->where('uid='.$vpo['salemanId'])->getField('uname');
			//$sort1[$kp]=$vpo['fromtime'];
			//$sort2[$kp]=$vpo['totime'];
			//$orderlist=D('order')->where('product_id='.$vpo['order_id'])->order('id desc')->limit('0,1')->select();
			//$vpo['payment']=$orderlist[0]['payment'];
			//$vpo['fromtime']=$orderlist[0]['from'];
			//$vpo['totime']=$orderlist[0]['to'];
			$t=D('user')->where('uid='.$val['techID'])->getField('uname');
			$vpo['tech']=$t;
			if(!empty($vpo['store'])){
				$vpo['position']=get_jgcate_name($vpo['store']);
			}else{
				$vpo['position']='无';
			}
		}
		
		$parse=parse_url($_SERVER['REQUEST_URI']);
		$this->assign('param',$parse['query']);
		$this->assign('page',$show);
		$this->assign('order',$ordr);
		$rdata=$this->fetch('searchAjax');
		//$rdata=$Od->getLastSql();
		$this->ajaxReturn($rdata,'succ',1);
	}

	public function have_buy(){
		$Pro=D('cus_prod');
		$buy=$Pro->where('status=0')->select();
		$this->assgin('buy',$buy);
		$this->display();
	}
	
	//编辑订单  update 12-28  1-18
	public function edit_order(){
		$dm=D('products');	
		if(Session('group')==3||Session('group')<=1){
			$this->assign('viewable',true);
		}else{
			$this->assign('viewable',false);
		}
		
		$damess=$dm->Field('cusid,pid')->where('id='.$_GET['id'])->find();
		$modle=M('cus_info');
		$customer=$modle->where('id="'.$damess['cusid'].'"')->find();
		
		get_contact_list($customer);
		$this->assign('cust',$customer);
		$Or=D('ProdView');
		$find['order_id']=$_GET['id'];
		$pro=$Or->where($find)->find();
	
		if($pro){
				$tech=D('user')->where('uid='.$pro['selemanId'])->getField('uname');
				//dump($tech);
				$pro['salename']=$tech;
				$findt=explode('-',$pro['path']);
				array_shift($findt);
				$array=array();
				$cplx='';
				foreach($findt as $pd){
					$dd=D('protype')->where('tid='.$pd)->getField('labelname');
					//dump($dd);
					$cplx.=$dd.'->';
					array_push($array,$dd);
				}
				$ol=D('order')->where('product_id='.$_GET['id'])->order('id desc')->limit('0,1')->select();
				$pro['orders']=$ol[0];
				$pro['cplx']=$cplx;
				$pro['parent']=$array;
		}
	
		$this->assign('pl',$pro);
		$this->assign('store',get_jgcate_name());
		$parse=parse_url($_SERVER['REQUEST_URI']);
		$this->assign('param',$parse['query']);
		$this->assign('tech',techman());//技术部员工名单
		$this->assign('cate',get_cate());
		$this->display();
	
	}
	/*new edit 12-22*/
	/*update 12-28  功能整合，订单处理与产品添加合为同一过程*/
	public function edit_order_save(){
		//dump($_POST);
		//exit;
		if(empty($_POST['prod_moveto'])){
			//产品信息修改
			$data=array_map('trim',$_POST);
			if(!empty($_FILES['photo1'])&&!empty($_FILES['photo2'])){
				$fileUp=upload();
				$data['picture1']=$fileUp[0]['savename'];
				$data['picture2']=$fileUp[1]['savename'];
			}
			
			$new=$data;
			$new['from']=strtotime($new['from']);
			$new['to']=strtotime($new['to']);
			if(isset($new['xf_totime'])){
				$new['xf_totime']=strtotime($new['xf_totime']);
			}
			$Pd=D('products');
			$Od=D('order');
			$old=$Pd->where('id='.$_POST['order'])->find();
		//	dump($new);
			$new=array_diff_assoc($new,$old);
			$oldone = $Od->field('from,to,note,payment')->where('product_id ='.$_POST['order'])->find();
			$new=array_diff_assoc($new,$oldone);
		//	dump($old);
		//	dump($new);
		//	exit;
			unset($new['param']);
			unset($new['__hash__']);
			unset($new['sbt']);
			unset($new['order']);
			unset($new['xgorder_id']);
			$string='';
			foreach($new as $key=>$val){
				if($key=='from'||$key=='to'){
					if($key == 'from' ){
						$key = '开通日期';
					}
					if($key == 'to' ){
						$key = '到期日期';
					}
					$string.=$key.':'.date('Y-m-d',$val).'<br />';
				}elseif($key=='xf_totime'){
					$string.=$key.':'.date('Y-m-d',$val).'<br />';
				}else{
					if($key == 'payment' ){
						$key = '应付金额';
					}
					if($key == 'domain' ){
						$key = '域名';
					}
					if($key == 'note' ){
						$key = '备注';
					}
					if($key == 'note' ){
						$key = '备注';
					}
					if($key == 'cus_username' ){
						$key = '用户名';
					}
					$string.=$key.':'.$val.'; <br /> ';
				}
			}
		
			$Pd->where('id='.$_POST['order'])->save($data);
			if(!empty($_POST['prod_xufei'])&&!empty($_POST['xf_payment'])&&!empty($_POST['xf_totime'])){
				/*续费操作*/
					if(!$Od->autoCheckToken($_POST)){
                        $this->error('请不要重复提交',__APP__.'/Order/index?'.$_POST['param']);
                    }
                    $insertOrder['product_id']=$_POST['order'];
					$insertOrder['payment']=$data['xf_payment'];
					$insertOrder['cusid']=$_POST['cusid'];
					$insertOrder['from']=time();
					$insertOrder['to']=strtotime($data['xf_totime']);
					$insertOrder['note']=$data['xf_note'];
					$insertOrder['creator']=Session('uid');
					$setto['is_on']='disabled';
					$Od->where('product_id='.$_POST['order'])->save($setto);
					$Od->add($insertOrder);
					
					$add['oid']=$_POST['order'];
					$add['user']=Session('uname');
					$add['time']=time();
					$add['event']='续费';
					$add['content']=$string;
					D('order_history')->add($add);
					$this->success('处理完毕',__APP__.'/Order/index?'.$_POST['param']);
			}else{
				
				/*修改操作*/
					
					$saveOrder['from']=strtotime($data['from']);
					$saveOrder['to']=strtotime($data['to']);
					$saveOrder['payment']=$data['payment'];
					D('order')->where('id='.$_POST['xgorder_id'])->save($saveOrder);
					$add['oid']=$_POST['order'];
					$add['user']=Session('uname');
					$add['time']=time();
					$add['event']='修改产品信息';
					$add['content']=$string;
					D('order_history')->add($add);
					$this->success('处理完毕',__APP__.'/Order/index?'.$_POST['param']);
			}
		}else{
			//产品转移
			$Od=D('Products');
			$data=array_map('trim',$_POST);
			if(!empty($_FILES['photo1'])&&!empty($_FILES['photo2'])){
				$fileUp=upload();
				$data['picture1']=$fileUp[0]['savename'];
				$data['picture2']=$fileUp[1]['savename'];
			}
			$new=$data;
			$new['from']=strtotime($new['from']);
			$new['to']=strtotime($new['to']);
			$where['cusname']=$_POST['newcusname'];
			$data['cusid']=D('cus_info')->where($where)->getField('id');
			
			
			$old=$Od->where('id='.$_POST['order'])->find();
			$new['oldcus']=D('cus_info')->where('id='.$old['cusid'])->getField('cusname');
			$new=array_diff_assoc($new,$old);
			$cond['id']=$new['order'];
			unset($new['param']);
			unset($new['__hash__']);
			unset($new['sbt']);
			unset($new['order']);
			unset($new['prod_moveto']);
			unset($new['xgorder_id']);
			$string='';
			foreach($new as $key=>$val){
				if($key=='from'||$key=='to'){
					$string.=$key.':'.date('Y-m-d',$val);
				}else{
					$string.=$key.':'.$val.';';
				}
			}
		
			if($Od->where('id='.$_POST['order'])->save($data)){
				D('Order')->where('id='.$_POST['xgorder_id'])->save($data);
				$add['oid']=$_POST['order'];
				$add['user']=Session('uname');
				$add['time']=time();
				$add['content']=$string;
				$add['event']='产品用户转移';
				D('order_history')->add($add);
				$this->success('处理完毕',__APP__.'/Order/index?'.$_POST['param']);
			}else{
		
				$this->error('未操作成功',__APP__.'/Order/index?'.$_POST['param']);
			}
		}
	}
	/****入账*************new*************/
	public function finance(){
		$this->assign('sale',saleman());
		$this->display();
	}
	//*****入账查询******************new*/
	public function finaSearch(){
		$data='';
		if(!empty($_GET['cusname'])){
			$data['cusname']=array('like','%'.trim($_GET['cusname']).'%');
		}
		if(!empty($_GET['contract_No'])){
			if(trim($_GET['contract_No'])=='*'){
			
				$data['contract_No']='';
			}else{
				$data['contract_No']=$_GET['contract_No'];
			}
		}
	
		if(!empty($_GET['to'])){
			if($_GET['to']=='e'){
				$data['totime']=array('elt',time());
			
			}else{
				$data['totime']=get_order_endtime($_GET['to']);
			}
		}
		
		 
		if($_GET['status'] == 'all'){
			$data['paid']=array('eq','0');
		//	$data['paid']=array('lt','payment');
		} 
		if($_GET['status'] == 1){
			$data['notpaid']=array('eq','1');
		//	$data['paid']=array('lt','payment');
		} 
		
	 	/* if($_GET['status']='1'){
			$data['paid']=array('eq','0');
		} */
		/*  if($_GET['status']== 3){
			$data['paid']=array(array('gt','0'),array('lt','payment'),'and'); 
		}  */
		//$data['paid']=array(array('gt','0'),array('lt','payment'),'and'); 
		/* if($_GET['status']='2'){
			$data['paid']=array();
		}  */
		if(!empty($_GET['salemanId'])){
			$data['salemanId']=$_GET['salemanId'];
		}
		// dump($data['paid']);
		// exit;
		$Od=D('OrderView');
		$ordr=$Od->where($data)->select();
		$Us=D('user');
		foreach($ordr as &$v){
			$v['salename']=$Us->where('uid='.$v['salemanId'])->getField('uname');
			$prodname=D('protype')->field('labelname')->where('tid='.$v['pid'])->select();
			$v['labelname']=$prodname[0]['labelname'];
		}

		//$rdata=$Od->getLastSql();
		
		$this->assign('order',$ordr);
		$parse=parse_url($_SERVER['REQUEST_URI']);
		$this->assign('param',$parse['query']);
		$rdata=$this->fetch();
		
		$this->ajaxReturn($rdata,'succ',1);
	
	
	}
	//查看订单详细
	public function order_detail(){
			$data['order_id']=$_GET['num'];
			$Od=D('ProdView');
			$Olist=D('order');
			$or=$Od->where($data)->find();
			
			$list=$Olist->where('product_id='.$or['order_id'])->order('id desc')->select();
			$or['fromtime']=$list[0]['from'];
			$or['totime']=$list[0]['to'];
			$or['ip'] = $list[0]['ip'];
			$or['payment']=$Olist->where('product_id='.$or['order_id'])->sum('payment');
			$or['paid']=$Olist->where('product_id='.$or['order_id'])->sum('paid');
			$or['note']=$list[0]['to'];
			$or['totime']=$list[0]['to'];
			$or['contract_No']=$list[0]['contract_No'];
			
			$this->assign('or',$or);
		
			$where['oid']=$or['order_id'];

			$His=D('order_history');
			
			
			$fin_his = $His->where($where)->select();
/* 			dump($fin_his);
			dump(count($fin_his));
			for($i=0;$i<=count($fin_his);$i++){
			$str = $fin_his[$i]['content'];
			dump($str);
			$str = strstr($str,'from','起始时间');
			$str = strstr($str,'to','截止时间');
			$str = strstr($str,'payment','应付金额');
			$str = strstr($str,'domain','域名');
			$str = strstr($str,'note','备注');
			dump ($str);
			}
			exit;
 */			$this->assign('finance_history',$fin_his);
			$parse=parse_url($_SERVER['REQUEST_URI']);
			$this->assign('param',$parse['query']);
			$this->display();
	
	
	}
	/**暂留
	public function finance_detail(){
			$data['order_id']=$_GET['num'];
			$Od=D('OrderView');
			$or=$Od->where($data)->find();
			$this->assign('or',$or);
			$where['ptable']=C('DB_PREFIX').'order';
			//$where['oid']=$or['order_id'];
			$where['pid']=$or['order_id'];
			$where['type']='in';
			$Fin=D('finger');
			//$His=D('order_history');
			
			
			$fin_his=$Fin->where($where)->select();
			$this->assign('finance_history',$fin_his);
			$parse=parse_url($_SERVER['REQUEST_URI']);
			$this->assign('param',$parse['query']);
			$this->display();
	
	
	}
	*/
/* 	public function finance_save(){
	
		if(!empty($_POST['paid'])){
		//	dump($_POST);
		//	exit;			
			$Ordr=D('order');
				if(!empty($_POST['hetong_num'])){
					$data['contract_No']=trim($_POST['hetong_num']);//写入合同号
				}
				$data['paid']=trim($_POST['paid']);
				$data['finnote']=trim($_POST['note']);
				$data['rebate']=trim($_POST['rebate']);
				$data['tax'] = $_POST['tax'];
 		//		dump($data);
		//		exit;
 				$tag=$Ordr->where('id='.$_POST['onum'])->save($data);
				if($tag){
					//$Fin->commit();//
					$this->success('付款成功',__URL__.'/finance');
				}else{
					//$Fin->rollback();
					$content="\r\n".date('Y:m:d-H:i:s',time)."   MONEY:".$data['paid']."   INFO:".iconv('utf-8','gb2312//IGNORE',$data['finnote'])." 	|CREATE ERROR!\n\r";
					write_log(LOG_PATH.'order_'.$od['id'].'.log',$content);
					$this->error('错误,请查看日志',__URL__.'/finance');
				}
			
		}else{
			$data['order_id']=$_GET['num'];
			$Od=D('OrderView');
			$or=$Od->where($data)->find();
 			dump($or);
			exit;
 			$this->assign('or',$or);
			$this->display();
		}
	}
 */	
	
		public function finance_save(){
	
		if(!empty($_POST['paid'])){
		//	dump($_POST);
		//	exit;			
			$Ordr=D('order');
				if(!empty($_POST['hetong_num'])){
					$data['contract_No']=trim($_POST['hetong_num']);//写入合同号
				}
				$data['paid']=trim($_POST['paid']);
				$data['finnote']=trim($_POST['note']);
				$data['rebate']=trim($_POST['rebate']);
				$data['tax'] = $_POST['tax'];
				$kouqu = $_POST['tax'] + $_POST['rebate'] + $_POST['paid'];
			//	dump($kouqu);
				if((double)$_POST['payment'] > $kouqu){
			//		echo 1213213234;
					$data['notpaid'] = 1;
			//		dump($data['notpaid']);
				}
			//	dump((double)$_POST['payment']);
			//	dump($kouqu);
				if((double)$_POST['payment'] == $kouqu){
					$data['notpaid'] = 0;
			//		dump($data['notpaid']);
				}
			//	echo $kouqu;
 				dump($data);
			//	exit;
 				$tag=$Ordr->where('id='.$_POST['onum'])->save($data);
				if($tag){
					//$Fin->commit();//
					$this->success('付款成功',__URL__.'/finance');
				}else{
					//$Fin->rollback();
					$content="\r\n".date('Y:m:d-H:i:s',time)."   MONEY:".$data['paid']."   INFO:".iconv('utf-8','gb2312//IGNORE',$data['finnote'])." 	|CREATE ERROR!\n\r";
					write_log(LOG_PATH.'order_'.$od['id'].'.log',$content);
					$this->error('错误,请查看日志',__URL__.'/finance');
				}
			
		}else{
			$data['order_id']=$_GET['num'];
			$Od=D('OrderView');
			$or=$Od->where($data)->find();
/* 			dump($or);
			exit;
 */			$this->assign('or',$or);
			$this->display();
		}
	}

	
	public function modify_order(){
		if(isset($_POST['oid'])){
			$id=$_POST['oid'];
			$cusid=D('order')->where('id='.$id)->getField('cusid');
			$save['ip']=trim($_POST['ip']);
			$save['domain']=trim($_POST['domain']);
			$save['from']=strtotime($_POST['starttime']);
			$save['to']=strtotime($_POST['endtime']);
			$save['payment']=trim($_POST['payment']);
			$save['cus_username']=trim($_POST['username']);
			$save['note']=trim($_POST['note']);
			if(D('order')->where('id='.$id)->save($save)){
				$hand['cusid']=$cusid;
				$hand['uname']=Session('uname');
				$hand['time']=time();
				$hand['note']='修改订单：'.$_POST['oid'];
				$hand['description']=htmlspecialchars('修改订单内容&nbsp;&nbsp;&nbsp;IP：'.$save['ip'].'&nbsp;&nbsp;&nbsp;domain：'.$save['domain'].'&nbsp;&nbsp;&nbsp;起始时间：'.$_POST['starttime'].'&nbsp;&nbsp;&nbsp;结束时间：'.$_POST['endtime'].'&nbsp;&nbsp;&nbsp;应付金额：'.$_POST['payment']);
				if(D('handle')->add($hand)){
					echo 1;
				}else{
					$path='CRM_ERROR_ORDER'.$_POST['oid'].'.log';
					$content=iconv('utf-8','gb2312//IGNORE',"修改订单内容\tIP：".$save['ip']."\tdomain：".$save['domain']."\t起始时间：".$_POST['starttime']."\t结束时间：".$_POST['endtime']."\t应付金额：".$_POST['payment']);
					write_log(LOG_PATH.$path,$content);
						
					echo 2;
				}
			}else{
				echo 0;
			
			}
		
		}else{
			$dt['order_id']=$_GET['onumber'];
			$Od=D('OrderView');
			$orinfo=$Od->where($dt)->find();
			$orinfo['pro_fullname']=prod_fullname($orinfo['tid']);
			$this->assign('oinfo',$orinfo);
			$rdata=$this->fetch();
			$this->ajaxReturn($rdata,'succ',1);
		}
	}
	
	
	/*12-29 update*/
	//置删除标记
	public function remove_order(){
		$id=$_POST['onum'];
		//$save['deleted']='0';
		if(D('products')->where('id='.$id)->delete()){
			//D('order')->where('product_id='.$id)->delete();
			echo 1;
		}else{
			echo 0;
		}
	
	}
	//彻底删除
	public function delete_order(){
	
		if(isset($_POST['del'])){
			if($_POST['caozuo']=='d'){
				$wheresql['id']=array('IN',$_POST['orderids']);
				D('order')->where($wheresql)->delete();
				$this->success('清理完成',$_SERVER['HTTP_REFERER']);
			}elseif($_POST['caozuo']=='r'){
				$save['deleted']='1';
				
				$wheresql['id']=array('IN',$_POST['orderids']);
				
				if(D('order')->where($wheresql)->save($save)){
					$this->success('恢复完成',$_SERVER['HTTP_REFERER']);
				}else{
					$this->error('恢复失败',$_SERVER['HTTP_REFERER']);
				}
			}
		}else{
			$where['deleted']='0';
			$User=D('user');
			$Cus=D('cus_info');
			$rubish=D('order')->where($where)->select();
			foreach($rubish as &$v){
				$v['cusname']=$Cus->where('id='.$v['cusid'])->getField('cusname');
				$v['products_name']=prod_fullname($v['pid']);
				$v['saleman']=$Cus->where('uid='.$v['owner'])->getField('uname');
				
			}
			$this->assign('rubish',$rubish);
			$this->display();
		}	
	}
	//财务报表
	
	public function  report(){		
		$where = array();
		if(Session('permLevel')==2){
			
			$user=allusers();	/***权限等级,全局范围***/
			$level=true;
		}elseif(Session('permLevel')==1){
			
			$user=same_depart_man();	/***权限等级,仅部门范围***/
			$level=false;
		}
		if($_SESSION['group'] ==2){
			$user=same_depart_man();
			//dump($user);
			$this->assign('sale',$user);	
		}else{
			$this->assign('sale',saleman());
		}
		$Fin=D('ReportView');
		/* if(empty($_REQUEST['ctime'])){
			$where['fromtime']='';			
		}else{
			$where['fromtime']=order_ctime_sql($_REQUEST['ctime']);
		} */
		if(!empty($_REQUEST['ctime'])){
			$where['fromtime']=order_ctime_sql($_REQUEST['ctime']);
		}
	 	
		if(!empty($_REQUEST['saleman'])){
			  $where['salemanId']=$_REQUEST['saleman'];
		}else{
			if(!$level){
				$smUser=null;
				foreach($user as $val){
					  $smUser[]=$val['uid'];
				}
				$where['salemanId']=array('in',$smUser);
			}

		}
		//$where['ptable']='crm_order';
		//$where['type']='in';
		//dump($where);
		//exit;
		$result=$Fin->where($where)->select();
		//dump($result);
		if(isset($_REQUEST['down'])){
			header("Content-Type: application/vnd.ms-excel; charset=UTF-8");   
			header("Pragma: public");   
			header("Expires: 0");   
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   
			header("Content-Type: application/force-download");   
			header("Content-Type: application/octet-stream");   
			header("Content-Type: application/download");   
			header("Content-Disposition:attachment;filename=report.xls");   
			header("Content-Transfer-Encoding: binary ");   
			echo "产品\t用户\t应收\t实收\t备注\t\n";
		
			foreach($result as $val){
				echo $val['labelname']."\t".$val['cusname']."\t".$val['payment']."\t".$val['paid']."\t".$val['finnote']."\t\n";
			}
		}else{
			$total_payment=0;
			$total_money=0;
			foreach($result as &$v){
				$total_payment+=$v['payment'];
				$total_money+=$v['paid'];
			} 
		
			$this->assign('repo',$result);
			$this->assign('total_payment',round($total_payment,2));
			$this->assign('total_money',round($total_money,2));
			$this->assign('total',count($result));
			$this->display();
		}
	}
}
?>
