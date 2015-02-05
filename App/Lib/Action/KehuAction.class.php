<?php
// 本类由系统自动生成，仅供测试用途
	class KehuAction extends CommonAction{
		
	
	public function index(){
		vendor('Page.Page');
		$parse=parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($parse['query'])) {
            parse_str($parse['query'],$params); 
        }
		$this->assign('param',$params);
		$this->assign('sale',saleman());	//销售人列表
		$this->assign('prolist',get_cate());//产品列表
		$this->display();
	}
	//添加客户用产品多级分类列表输出
	public function cate_out(){
		$fcate=D('protype')->where('parentId='.$_GET['cate'])->select();
		$this->assign('fcate',$fcate);
		$str=$this->fetch('ajaxCate');
		$this->ajaxReturn($str,'suss',1);
		//dump($fcate);
	}
	//客户跟单信息
	public function follow(){
		//vendor('Page.Page');

		$data='';
		
		
		if(!empty($_GET['cusname'])){
		
			$data['cusname']=array('like','%'.trim($_GET['cusname']).'%');
		
		}
		if(!empty($_GET['contact'])){
			
			$data['contact']=array('like','%'.trim($_GET['contact']).'%');
		}
		if(!empty($_GET['salemanId'])){
			
			$data['salemanId']=$_GET['salemanId'];
		}
			
		
		//dump($data);
		$Cus=D('Gdrec_infoView');
		
		

		$permission=check_permission(MODULE_NAME.':'.ACTION_NAME);
		if($permission=='1'){
			if(Session('group')!='2'){//非销售组
				$retrn=$Cus->Field('num,cusname,custype,contact,salemanId,note,description,gd_time,nextnote,uname')->where($data)->group('gd_cid')->order('gd_time')->select();//管理员操作,查全部 
			}else{
				if(empty($data['salemanId'])){
					$data['salemanId']=array('neq',1);//单独,销售组无法查看总经办客户
				}
				$retrn=$Cus->Field('num,cusname,custype,contact,salemanId,note,description,gd_time,nextnote,uname')->where($data)->group('gd_cid')->order('gd_time')->select();//管理员操作,查全部
			
			
			}
		
		}elseif($permission=='2'){
			if(Session('group')!='2'){
				$retrn=$Cus->Field('num,cusname,custype,contact,salemanId,note,description,gd_time,nextnote,uname')->where($data)->group('gd_cid')->order('gd_time')->select();//管理员操作,查全部
			
			}else{
				$data['salemanId']=Session('uid');
				$retrn=$Cus->Field('num,cusname,custype,contact,salemanId,note,description,gd_time,nextnote,uname')->where($data)->group('gd_cid')->order('gd_time')->select();//管理员操作,查全部
			}
		}
		
		foreach($retrn as $k => &$v){
			$ctime = $v['gd_time'] - time();
			$v['gd_time'] = date("Y-m-d",$v['gd_time']);
			$day = ceil($ctime/86400);
			if($day>0){
				$v['cday'] = $day;
			}elseif($day = 0){
				$v['cday'] = "当天";
			}else{
				$v['cday'] = "过期";
			}
		
		}
		//dump($retrn);
		$parse=parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($parse['query'])) {
            parse_str($parse['query'],$params); 
        }
		$namesel = $params['namesearch'];
		$this->assign('namesel',$namesel);
		$this->assign('param',$params);
		$this->assign('cust',$retrn);
		$this->assign('sale',saleman());
		$this->display();
	}


	/**
	//客户跟单信息视图显示
	public function followAjax(){
	
		//vendor('Page.AjaxPage');
		//视图查询条件

		$data='';
		
		
		if(!empty($_GET['cusname'])){
		
			$data['cusname']=array('like','%'.trim($_GET['cusname']).'%');
		
		}
		if(!empty($_GET['contact'])){
			
			$data['contact']=array('like','%'.trim($_GET['contact']).'%');
		}
		
		
		
		$Cus=D('Cus_infoView');
		
		//import("ORG.Util.AjaxPage"); 
		//if(empty($_GET['per_page'])){
		//	$per_page=22;
		//}else{
		//	$per_page=$_GET['per_page'];
		//}
		$permission=check_permission(MODULE_NAME.':'.ACTION_NAME);
		if($permission=='1'){
			if(Session('group')!='2'){//非销售组
				$ret=$Cus->Field('num')->where($data)->distinct('num')->order($order_str)->select();//管理员操作,查全部
				//$total_count=count($ret);
				//$limit=$per_page=='all'?$total_count:$per_page;
				//$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,salemanId,handle_time,description,uname')->where($data)->group('num')->order('handle_time')->select();//管理员操作,查全部 
			}else{
				if(empty($data['salemanId'])){
					$data['salemanId']=array('neq',1);//单独,销售组无法查看总经办客户
				}
				$ret=$Cus->Field('num')->where($data)->distinct('num')->order($order_str)->select();//管理员操作,查全部
				//$total_count=count($ret);
				///$limit=$per_page=='all'?$total_count:$per_page;
				//$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,salemanId,handle_time,description,uname')->where($data)->group('num')->order('handle_time')->select();//管理员操作,查全部
			
			
			}
		
		}elseif($permission=='2'){
			if(Session('group')!='2'){
				$ret=$Cus->Field('num')->where($data)->group('num')->order($order_str)->select();//管理员操作,查全部
				//$total_count=count($ret);
				//$limit=$per_page=='all'?$total_count:$per_page;
				//$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,salemanId,handle_time,description,uname')->where($data)->group('num')->order('handle_time')->select();//管理员操作,查全部
			
			}else{
				$data['salemanId']=Session('uid');
				$ret=$Cus->Field('num')->where($data)->group('num')->order($order_str)->select();//去重复,以用户id别名,加入用户ID
				//$total_count=count($ret);
				//$limit=$per_page=='all'?$total_count:$per_page;
				//$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,salemanId,handle_time,description,uname')->where($data)->group('num')->order('handle_time')->select();//管理员操作,查全部
			}
		}
		$fdata=$Cus->getLastSql();
		//$show= $page->show(); 
		//foreach($retrn as $k => $v){
		//$v['vp_money']=$Cus->where('cusid='.$v['num'])->sum('payment');
		
		//}
		//foreach($retrn as $kp=>$vp){
		//	$sort1[$kp]=$vp['vp_money'];
		//}
	
		//$xulie=!empty($_GET['order'])?SORT_ASC:SORT_DESC;
		//array_multisort($retrn);
		$parse=parse_url($_SERVER['REQUEST_URI']);
		$this->assign('param',$parse['query']);
		//$order=$_GET['order']?1:0;
		//$this->assign('order',$order);
		$this->assign('cust',$retrn);
		//$this->assign('page',$show);
		
		$fdata = $this->fetch();
		$this->ajaxReturn($fdata,'succ',1);
	}

	**/
	public function _empty($method){
					if(is_numeric($method)) {	
					$modle=M('customers');
					$map[cid]=$method;
					$customers=$modle->where($map)->find();
					$this->assign('customers',$customers);
					$fdata = $this->fetch('showcustomers');
					//$fdata=$customers[cid];
					$this->ajaxReturn($fdata,'正确~',1);
					} else {

					}
	}
	public function view(){
		$backname = $_GET['backname'];
		$this->assign('backname',$backname);
		$saleman = $_GET['salename'];
		$this->assign('saleman',$saleman);
		$modle=M('cus_info');
		$customer=$modle->where('id="'.$_GET['id'].'"')->find();
		//dump($customer);
		
		
			$customer['contact_list']=array(
									'contact'=>explode('|',$customer['contact']),
									'cont_job'=>explode('|',$customer['cont_job']),
									'mobile'=>explode('|',$customer['mobile']),
									'tel'=>explode('|',$customer['tel']),
									'email'=>explode('|',$customer['email']),
									'qq'=>explode('|',$customer['qq']),
									'id_card'=>explode('|',$customer['id_card']),
									
									);
									
			$customer['contact']=$customer['contact_list']['contact'][0];
			$customer['mobile']=$customer['contact_list']['mobile'][0];
			$customer['cont_job']=$customer['contact_list']['cont_job'][0];
			$customer['qq']=$customer['contact_list']['qq'][0];
			$customer['email']=$customer['contact_list']['email'][0];
			$customer['tel']=$customer['contact_list']['tel'][0];
			$customer['id_card']=$customer['contact_list']['id_card'][0];
		
	
			$this->assign('cust',$customer);	
			
			$Od=D('ProdView');
			$find['cusid']=$_GET['id'];
			$pro=$Od->where($find)->select();
			$Odlist=D('order');
			if($pro){
				$data=array();
				foreach($pro as $key=>$val){
					$data[$key]=$val;
					$tech=D('user')->where('uid='.$val['salemanId'])->getField('uname');
					//dump($tech);
					$orderC['cusid']=$_GET['id'];
					$orderC['product_id']=$val['order_id'];
					$orderline=$Odlist->where($orderC)->order('id desc')->select();
					$data[$key]['fromtime']=$orderline[0]['from'];
					$data[$key]['totime']=$orderline[0]['to'];
					$data[$key]['note']=$orderline[0]['note'];
					$data[$key]['payment']=$Odlist->where($orderC)->sum('payment');
					$data[$key]['salename']=$tech;
				
					$findt=explode('-',$val['path']);
					array_shift($findt);
					$array=array();
					$cplx='';
					foreach($findt as $pd){
						$dd=D('protype')->where('tid='.$pd)->getField('labelname');
						//dump($dd);
						$cplx.=$dd.'->';
						array_push($array,$dd);
					}
					$data[$key]['cplx']=$cplx;
					$data[$key]['parent']=$array;
				}
			}
		
		
		/*
		//查询订单
		$dm=D('order');		
		$pro=$dm->query('select o.*,p.labelname,p.path from '.C('DB_PREFIX').'order as o,'.C('DB_PREFIX').'protype as p WHERE  o.pid=p.tid and o.cusid="'.$_GET['id'].'"');
		//echo $dm->getLastSql();
		//dump($pro);
		if($pro){
			foreach($pro as $key=>&$val){
				$data[$key]=$val;
				$tech=D('user')->where('uid='.$val['creator'])->getField('uname');
				//dump($tech);
				$data[$key]['salename']=$tech;
				$findt=explode('-',$val['path']);
				array_shift($findt);
				$array=array();
				$cplx='';
				foreach($findt as $pd){
					$dd=D('protype')->where('tid='.$pd)->getField('labelname');
					//dump($dd);
					$cplx.=$dd.'->';
					array_push($array,$dd);
				}
				$data[$key]['cplx']=$cplx;
				$data[$key]['parent']=$array;
			}
		}
		*/
		//dump($data);
		$parse=parse_url($_SERVER['REQUEST_URI']);
						
		//dump($parse);
		//exit();
		$this->assign('path',$parse['path']);
		$this->assign('param',$parse['query']);
		$this->assign('prod',$data);
		
		$this->display();
		
	}
	
	
	public function hand_history(){
		$hand=D('handle')->where('cusid='.$_GET['cid'])->order('time desc')->select();
			$this->assign('handhis',$hand);
		$fdata = $this->fetch('hand_history');
		  $this->ajaxReturn($fdata,'正确~',1);
	
	}
	public function addCus(){

		if($_POST['sbt']){
            $Cuser=D('cus_info');
            if(!$Cuser->autoCheckToken($_POST)){
                $this->error('请不要重复提交',$_SERVER['HTTP_REFERER']);
            }
			$data=array_map('trim',$_POST);
			$arr=$data;
			$arr['contact']=join('|',array_map('trim',$_POST['contact']));
			$arr['cont_job']=join('|',array_map('trim',$_POST['cont_job']));
			$arr['mobile']=join('|',array_map('trim',$_POST['mobile']));
			$arr['tel']=join('|',array_map('trim',$_POST['tel']));
			$arr['email']=join('|',array_map('trim',$_POST['email']));
			$arr['qq']=join('|',array_map('trim',$_POST['qq']));
			$arr['id_card']=join('|',array_map('trim',$_POST['id_card']));
			$arr['cremanId']=Session('uid');
			$arr['salemanId']=Session('uid');
			$arr['uptime']=time();
			$arr['ctime']=time();
			
			$uniq=$Cuser->where('cusname='.trim($_POST['cusname']))->getField('id');
			if($uniq){
				$this->error('客户已经存在',$_SERVER['HTTP_REFERER']);
			}
			//添加新用户
			$tag=$Cuser->add($arr);
			//dump($arr);
			if($tag){
				if($_POST['type_id']=='0'){
					$Hju=D('handle');
					$jilu['cusid']=$tag;
					$jilu['uname']=Session('uname');
					$jilu['time']=time();
					$jilu['note']='新增潜在用户';
					$jilu['description']=htmlspecialchars('用户名:&nbsp;&nbsp;&nbsp;'.$arr['cusname']);
					
					if($Hju->add($jilu)){
						$this->success('添加成功',__URL__);
						
					}else{
					
						$this->error('添加失败',__URL__);
					}
				
				}elseif($_POST['custype']!='0'&&$_POST['type_id']!='0'){
					//如果有订单，就添加订单
					$Pd=D('products');
					$Od=D('order');
					$cus['cusid']=$tag;
					$cus['creator']=Session('uid');	
					$cus['pid']=$_POST['type_id'];
					$cus['ip']=$data['ip'];
					$cus['domain']=$data['domain'];
				
					$cus['cus_username']=$data['cus_username'];
					
					$cus['ctime']=time();
					
					
					//添加订单
					if($dingdan=$Pd->add($cus)){
						$ord['product_id']=$dingdan;
						$ord['cusid']=$tag;
						$ord['payment']=$data['payment'];
						$ord['note']=$data['note'];
						$ord['owner']=Session('uid');
						$ord['from']=strtotime($data['from']);
						$ord['to']=strtotime($data['to']);
						$Od->add($ord);
						$han['cusid']=$tag;
						$han['uname']=Session('uname');
						$han['time']=$arr['ctime'];
						$han['note']='新增客户并开通产品';//事件
						$han['description']=htmlspecialchars('产品:&nbsp;&nbsp;&nbsp;'.prod_fullname($cus['pid']).'&nbsp;&nbsp;&nbsp;提交ip:'.trim($_POST['ip']).'&nbsp;&nbsp;&nbsp;提交域名:'.$cus['domain']);
						D('handle')->add($han);
						$this->success('添加成功',__URL__);
					}else{
							$str=date('Y-m',$cus['ctime']);
							$path='CRM_ERROR'.$str.'.log';
							$content="\r\n".date('Y:m:d-H:i:s',$cus['ctime'])."   CUSTOMERID:".iconv('utf-8','gb2312//IGNORE',$_POST['cusname'])."   INFO:".iconv('utf-8','gb2312//IGNORE','添加产品失败')."   USERNAME:".iconv('utf-8','gb2312//IGNORE',$han['uname'])."|CREATE ERROR!\n\r";
							write_log(LOG_PATH.$path,$content);
							$this->success('添加客户成功，产品未添加成功',__URL__);
					
					}
				}
			}else{
				
				$this->error('添加客户失败',__URL__);
			
			}
		
		}else{
		
			$da=get_cate();
			
			$this->assign('cate',$da);
		
			$this->display();
		}
	
	}
	
	public function search(){
		//vendor('Page.AjaxPage');
		//视图查询条件
		$data='';
		//$this->assign('searchsel',$_POST['namesearch']);
		//if($_POST['namesearch'] == 0){
		
		if(!empty($_GET['cusname'])){
		
			$data['cusname']=array('like','%'.trim($_GET['cusname']).'%');
		//}
		}
		//else{
		
		if(!empty($_GET['contact'])){
			
			$data['contact']=array('like','%'.trim($_GET['contact']).'%');
		}
		
		//}

		if(!empty($_GET['ip'])){
			
			$data['ip']=array('like','%'.trim($_GET['ip']).'%');
		}

		if(!empty($_GET['proid'])){
			$data['pid']=$_GET['proid'];
		}

		if(!empty($_GET['salemanId'])){
			
			$data['salemanId']=$_GET['salemanId'];
		}

		
		/*if(!empty($_GET['rangeb'])){
				switch($_GET['rangeb']){
					case '=':
						$data['totime']=strtotime(trim($_GET['to']));
						break;
					case '>=':
						$data['totime']=array('egt',strtotime(trim($_GET['to'])));
						break;
					case '<=':
						$data['totime']=array('elt',strtotime(trim($_GET['to'])));
						break;
					case '>7<':
						$left=strtotime(trim($_GET['to']))-7*86400;
						$right=strtotime(trim($_GET['to']))+7*86400;
						$data['totime']=array('BETWEEN',array($left,$right));
						break;
				}
			}else{
				$data['totime']=array('lt',strtotime(trim($_GET['to'])));
				//$mn=$Od->where('`cusid`='.$v['num'])->order('ctime desc')->limit('0,1')->select();
			}
		*/
		$data['custype']=array('neq',7);
		$date['order_deleted']='0';
		$Cus=D('Cus_infoView');
		//$salemaninfo = saleman();
		import("ORG.Util.AjaxPage"); 
		if(empty($_GET['per_page'])){
			$per_page=22;
		}else{
			$per_page=$_GET['per_page'];
		}
		$permission=check_permission(MODULE_NAME.':'.ACTION_NAME);
		if($permission=='1'){
			if(Session('group')!='2'){//非销售组
				$ret=$Cus->Field('num')->where($data)->distinct('num')->order($order_str)->select();//管理员操作,查全部
				$total_count=count($ret);
				$limit=$per_page=='all'?$total_count:$per_page;
				$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,email,qq,mobile,address,custype,salemanId,payment,uname')->where($data)->group('num')->order('custype')->limit($page->firstRow.','.$page->listRows)->select();//管理员操作,查全部 
			}else{
				if(empty($data['salemanId'])){
					$data['salemanId']=array('neq',1);//单独,销售组无法查看总经办客户
				}
				$ret=$Cus->Field('num')->where($data)->distinct('num')->order($order_str)->select();//管理员操作,查全部
				$total_count=count($ret);
				$limit=$per_page=='all'?$total_count:$per_page;
				$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,email,qq,mobile,address,custype,salemanId,payment,uname')->where($data)->group('num')->order('custype')->limit($page->firstRow.','.$page->listRows)->select();//管理员操作,查全部
			
			
			}
		
		}elseif($permission=='2'){
			if(Session('group')!='2'){
				$ret=$Cus->Field('num')->where($data)->group('num')->order($order_str)->select();//管理员操作,查全部
				$total_count=count($ret);
				$limit=$per_page=='all'?$total_count:$per_page;
				$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,email,qq,mobile,address,custype,salemanId,order_id,uname')->where($data)->group('num')->order('custype')->limit($page->firstRow.','.$page->listRows)->select();//管理员操作,查全部
			
			}else{
				if($_SESSION['rank'] != "部门经理"){
					$data['salemanId']=Session('uid');
				}	
				$ret=$Cus->Field('num')->where($data)->group('num')->order($order_str)->select();//去重复,以用户id别名,加入用户ID
				$total_count=count($ret);
				$limit=$per_page=='all'?$total_count:$per_page;
				$page=new AjaxPage($total_count,$limit);
				$retrn=$Cus->Field('num,cusname,contact,email,qq,mobile,address,custype,salemanId,order_id,uname')->where($data)->group('num')->order('custype')->limit($page->firstRow.','.$page->listRows)->select();//管理员操作,查全部
			}
		}
		$fdata=$Cus->getLastSql();
		//dump($retrn);
		$show= $page->show(); 
		//视图模型,基于用户表left->order-left->protype
		//$DD=D('handle');
		$Vpd=D('VPDView');
		$Od=D('order');
		foreach($retrn as $key=>&$v){
			$v['contact_list']=array(
									'contact'=>explode('|',$v['contact']),
									'mobile'=>explode('|',$v['mobile']),
									'email'=>explode('|',$v['email']),
									'qq'=>explode('|',$v['qq']),
									);
			$v['contact']=$v['contact_list']['contact'][0];
			$v['mobile']=$v['contact_list']['mobile'][0];
			$v['qq']=$v['contact_list']['qq'][0];
			$pdwhere['cusid']=$v['num'];
			$pdwhere['is_on']='enabled';
			$v['products']=$Vpd->field('order_id,ip,totime')->where($pdwhere)->select();
			$v['vp_money']=$Od->where('cusid='.$v['num'])->sum('payment');
			
		}
	
		foreach($retrn as $kp=>$vp){
			$sort1[$kp]=$vp['vp_money'];
		}
		//$retrn[]['siname'] = $siname;
		//dump($retrn);
		//$sort='payment';
		$xulie=!empty($_GET['order'])?SORT_ASC:SORT_DESC;
		array_multisort($sort1,$xulie, $retrn);
		$parse=parse_url($_SERVER['REQUEST_URI']);
		$this->assign('param',$parse['query']);
		$order=$_GET['order']?1:0;
		$this->assign('order',$order);
		$this->assign('cust',$retrn);
		$this->assign('page',$show);
		$fdata = $this->fetch('cusAjax');
		$this->ajaxReturn($fdata,'正确~',1);
	}
	public function add_order(){
		if($_POST['cusid']){
			
				$Cus=D('Cus_info');
                if(!$Cus->autoCheckToken($_POST)){
                    $this->error('请不要重复提交',$_SERVER['HTTP_REFERER']);
                }
				$cus['cusid']=$_POST['cusid'];
				$cus['creator']=Session('uid');
				
				$cus['pid']=$_POST['type_id'];
				if(empty($cus['pid'])){
				
					$this->error('请填写产品类别',$_SERVER['HTTP_REFERER']);
				}
				$cus['ip']=trim($_POST['ip']);
				$cus['domain']=trim($_POST['domain']);
			
				
				$cus['cus_username']=trim($_POST['cus_username']);
				
				$cus['ctime']=time();
				
				if($dingdan=D('products')->add($cus)){
					$ord['product_id']=$dingdan;
					$ord['payment']=trim($_POST['payment']);
					$ord['note']=trim($_POST['note']);
					$ord['cusid']=$_POST['cusid'];
					$ord['owner']=Session('uid');
					$ord['from']=strtotime($_POST['from']);
					$ord['to']=strtotime($_POST['to']);
					
					D('order')->add($ord);
					if(!empty($cus['ip'])){
						set_ip_busy($cus['ip']);
					}
				
					$han['cusid']=$cus['cusid'];
					$han['uname']=Session('uname');
					$han['time']=$cus['ctime'];
					$han['note']='开通产品';
					$han['description']=htmlspecialchars('购买产品:&nbsp;&nbsp;&nbsp;'.prod_fullname($cus['pid']).'&nbsp;&nbsp;&nbsp;提交ip:'.trim($_POST['ip']).'&nbsp;&nbsp;&nbsp;提交域名:'.$cus['domain']);
					D('handle')->add($han);
					$this->success('添加成功',__APP__.'/Kehu/index?'.$_POST['param']);
					
				}else{
				
						$str=date('Y-m',$cus['ctime']);
						$path='CRM_ERROR'.$str.'.log';
						$content="\r\n".date('Y:m:d-H:i:s',$time)."   CUSTOMERID:".iconv('utf-8','gb2312//IGNORE',$cus['cusname'])."   INFO:".iconv('utf-8','gb2312//IGNORE',$han['note'])."   USERNAME:".iconv('utf-8','gb2312//IGNORE',$han['uname'])."|CREATE ERROR!\n\r";
						write_log(LOG_PATH.$path,$content);
						$this->error('添加失败',__APP__.'/Kehu/index?'.$_POST['param']);
				}
			
				
		}else{
			//页面显示
				$cname=D('cus_info')->Field('id,cusname,custype')->where('id='.$_GET['id'])->find();
				$parse=parse_url($_SERVER['REQUEST_URI']);
		
				$this->assign('param',$parse['query']);
				
				$this->assign('customer',$cname);
				$this->assign('cate',get_cate());
		
			$this->display();
		}
	}
	public function handle(){
		if($_POST['cusname']){
		//dump($_POST);
            $Hand=D('gd_record');
            if(!$Hand->autoCheckToken($_POST)){
                $this->error('请不要重复提交',$_SERVER['HTTP_REFERER']);
            }
			$map['cusname']=$_POST['cusname'];
			$add['cusid']=D('cus_info')->where($map)->getField('id');
			$add['uname']=Session('uname');
			$add['time']=$_POST['nexttime'];
			$add['note']=trim($_POST['note']);
			$add['nextnote'] = trim($_POST['nextnote']);
			$add['description']=htmlspecialchars(trim($_POST['description']));
			//dump($add);//下次跟单信息
			$ta=$Hand->add($add);
			if($ta){
				$mess='跟单信息添加成功,&nbsp;&nbsp;';
			}else{
				$mess='跟单信息添加失败,&nbsp;&nbsp;';
			}
				if(isset($_POST['nextct'])){
					$dda['cusid']=$add['cusid'];
					$dda['uid']=Session('uid');
					$dda['nexttime']=strtotime($_POST['nexttime']);
					$dda['note']=htmlspecialchars(trim($_POST['nextnote']));
					$dda['creatime']=$add['time'];
					$th=D('cron')->add($dda);
					if($th){
						$mess.='并添加下次跟单';
					}else{
						$mess.='下次跟单未添加';
					}
				}
			
			$this->success($mess,__URL__);
			
			
		}elseif($_POST['customer_id']){
			//ajax方式提交
			$add['cusid']=$_POST['customer_id'];
			$add['uname']=Session('uname');
			$add['time']=time();
			$add['note']=trim($_POST['note']);
			$add['nextnote'] = trim($_POST['nextnote']);
			$add['description']=htmlspecialchars(trim($_POST['description']));
			//dump($add);//下次跟单信息
			$this->assign('add',$add);
			$ta=D('gd_record')->add($add);
			if($ta){
				
				$mess=1;
			}else{
				$mess=-1;
			}
			if(!empty($_POST['nextct'])){
				$dda['cusid']=$add['cusid'];
				$dda['uid']=Session('uid');
				$dda['creatime']=$add['time'];
				$dda['nexttime']=strtotime($_POST['nexttime']);
				$dda['note']=$_POST['nextnote'];
				$th=D('cron')->add($dda);
				if($th){
					$mess+=1;
				}else{
					$mess-=1;
				}
			}
			echo $mess;
		
		}else{
			if($_GET['oid']){
				//从意向订单进来
				$Od=D('OrderView');
				$map['order_id']=$_GET['oid'];
				$info=$Od->where($map)->find();
				//echo $Od->getLastSql();
				//$order=D('order')->
				//$kehu['cusid']=$order['cusid'];
				//D
				//$kehu['cusname']=$order[''];
				$this->assign('info',$info);
				
				//dump($info);
			}
			
			$this->display();
			
		}
	
	}
	//开通意向订单
	public function order_open(){
		if($_POST['sbt']){
			//$_POST['order_id'];
			$save['creator']=Session('uid');
			$save['owner']=Session('uid');
			$save['ip']=trim($_POST['ip']);
			$save['domain']=trim($_POST['domain']);
			$save['from']=strtotime($_POST['from']);
			$save['to']=strtotime($_POST['to']);
			$save['note']=trim($_POST['note']);
			$save['status']='2';//状态设为已成交
			$Order=D('order');
			
			if($Order->where('id='.$_POST['order_id'])->save($save)){
				$han['cusid']=$_POST['cusid'];
				$han['uname']=Session('uname');
				$han['time']=time();
				$han['note']='开通产品';
				$han['description']=htmlspecialchars('开通产品:&nbsp;&nbsp;&nbsp;'.prod_fullname($_POST['proid']).'&nbsp;&nbsp;&nbsp;提交ip:'.trim($_POST['ip']).'&nbsp;&nbsp;&nbsp;提交域名:'.$save['domain']);
				$custype['custype']=2;
				if(D('handle')->add($han)){
					D('Cus_info')->where('id='.$_POST['cusid'])->save($custype);//setInc('custype'); //设置用户状态
					$this->success('开通成功,已添加跟进记录',__URL__);
				}else{
					D('Cus_info')->where('id='.$_POST['cusid'])->save($custype);//setInc('custype'); //设置用户状态
					$this->success('开通成功',__URL__);
				
				}
			}else{
				$this->error('开通失败');
			
			}
		}else{
		
		
			$oinfo=D('order')->where('id='.$_GET['oid'])->find();
			$data['order_id']=$_GET['oid'];
			$data['proid']=$oinfo['pid'];
			$cus=D('cus_info')->Field('id,cusname')->where('id='.$oinfo['cusid'])->select();
			$data['cusid']=$cus[0]['id'];
			$data['cusname']=$cus[0]['cusname'];
			$data['proname']=prod_fullname($oinfo['pid']);
			
			//dump($data);
			$this->assign('info',$data);
			$this->display();
		}
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
	//14-21新增by wl
	function edit_cusinfo(){
		$Cus=D('cus_info');
		if(isset($_POST['sbt'])){
            if(!$Cus->autoCheckToken($_POST)){
                $this->error('请不要重复提交',__APP__.'/Kehu/index?'.$_POST['param']);
            }
			$id=$_POST['cus'];
			$data['cusname']=trim($_POST['cusname']);
			//$exi=$Cus->where('cusname='.$data['cusname'])->getField('id');
			$data['address']=trim($_POST['address']);	
			$data['contact']=join('|',array_map('trim',$_POST['contact']));
			$data['cont_job']=join('|',array_map('trim',$_POST['cont_job']));
			$data['mobile']=join('|',array_map('trim',$_POST['mobile']));
			$data['tel']=join('|',array_map('trim',$_POST['tel']));
			$data['email']=join('|',array_map('trim',$_POST['email']));
			$data['qq']=join('|',array_map('trim',$_POST['qq']));
			$data['id_card']=join('|',array_map('trim',$_POST['id_card']));
			$data['web']=trim($_POST['web']);
			$data['uptime']=time();
			$logmess=$data;
			array_pop($logmess);
			$content='修改内容\t';
			$message='';
			foreach($logmess as $key=>$value){
				$message.=$key.':'.$value.'&nbsp;&nbsp;&nbsp;';
				$content.=$key.":".$value."\t";
			}
			$content.="\n\r";
			if($Cus->where('id='.$id)->save($data)){
				$hand['cusid']=$id;
				$hand['uname']=Session('uname');
				$hand['time']=time();
				$hand['note']='修改客户信息';
				//备注 未完待续
				$hand['description']=htmlspecialchars('修改内容&nbsp;&nbsp;&nbsp;'.$message);
				if(D('handle')->add($hand)){
					$this->success('编辑成功',__APP__.'/Kehu/index?'.$_POST['param']);
				}else{
					$path='CRM_ERROR_CUSTOMER'.$id.'.log';
					$content=iconv('utf-8','gb2312//IGNORE',$content);
					write_log(LOG_PATH.$path,$content);
					$this->success('编辑成功',__APP__.'/Kehu/index?'.$_POST['param']);
				}
			}else{
				$this->error('未做修改',__APP__.'/Kehu/index?'.$_POST['param']);
			}
		}else{
		
			$id=$_GET['cusid'];
			$info=$Cus->where('id='.$id)->find();
			
			$info['contact_list']=array(
									'contact'=>explode('|',$info['contact']),
									'cont_job'=>explode('|',$info['cont_job']),
									'mobile'=>explode('|',$info['mobile']),
									'tel'=>explode('|',$info['tel']),
									'email'=>explode('|',$info['email']),
									'qq'=>explode('|',$info['qq']),
									'id_card'=>explode('|',$info['id_card']),
									
									);
			
			
			
			$parse=parse_url($_SERVER['REQUEST_URI']);
			$this->assign('param',$parse['query']);
			$this->assign('cusinfo',$info);
			$this->display();
		
		}
	
	}
	//12-27 update 
	public function modi_custype(){
		$id=$_POST['cusid'];
		$map['custype']=$_POST['custype'];
		if(D('cus_info')->where('id='.$id)->save($map)){
			echo 1;
		}else{
			echo 0;
		}
	
	
	}
	public function delete_costomer(){
		if(isset($_POST['del'])){
			if($_POST['caozuo']=='d'){
				$save['order_deleted']='0';
				$where['cusid']=array('IN',$_POST['cusids']);
				$wherecus['id']=array('IN',$_POST['cusids']);
				D('Cus_infoView')->where($where)->save($save);
				D('cus_info')->where($wherecus)->delete();
				$this->success('清理成功',$_SERVER['HTTP_REFERER']);
			}elseif($_POST['caozuo']=='r'){
				$save['custype']=0;
				$wheresql['id']=array('IN',$_POST['cusids']);
				if(D('cus_info')->where($wheresql)->save($save)){
					$this->success('恢复成功',$_SERVER['HTTP_REFERER']);
				}else{
					$this->error('恢复失败',$_SERVER['HTTP_REFERER']);
				}
			}
			
		}else{
			$Cus=D('cus_info');
			$User=D('user');
			$custo=$Cus->where('custype=7')->Field('id,cusname,salemanId,ctime')->select();
			foreach($custo as &$v){
				$v['saleman']=$User->where('uid='.$v['salemanId'])->getField('uname');
			}
			$this->assign('rubish',$custo);
			$this->display();
		}
	
	}
	
	
//class end!
}
?>