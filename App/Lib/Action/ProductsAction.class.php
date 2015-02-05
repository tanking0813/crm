<?php
class ProductsAction extends CommonAction{
	
	public function index(){
	
		$this->assign('store',get_jgcate_name());
		$parse=parse_url($_SERVER['REQUEST_URI']);
		
		if(isset($parse['query'])) {
            parse_str($parse['query'],$params); 
        }
		$this->assign('param',$params);
		$this->display();
		
		
	}
	/*update12-29*/
	
	public function prodAjax(){
		$map='';
		if(!empty($_GET['cusname'])){
			$map['cusname']=array('like','%'.$_GET['cusname'].'%');
		}
		if(!empty($_GET['ip'])){
			$map['ip']=array('like','%'.$_GET['ip'].'%');
		}
		if(!empty($_GET['store'])){
			$map['store']=$_GET['store'];
		}
		import("ORG.Util.AjaxPage"); 
		$Prod=D('ProdView');
		$total=$Prod->where($map)->count();		
		$page=new AjaxPage($total,20);
		
		$show= $page->show(); 
		
		//$page=new Page();
		
		
		$data=$Prod->where($map)->order('fromtime desc')->limit($page->firstRow.','.$page->listRows)->select();
	
		//$fdata=$Prod->getLastSql();
		
		foreach($data as &$val){
			$t=D('user')->where('uid='.$val['techID'])->getField('uname');
			$val['tech']=$t;
			if(!empty($val['store'])){
				$val['position']=get_jgcate_name($val['store']);
			}else{
				$val['position']='无';
			}
		}
		$parse=parse_url($_SERVER['REQUEST_URI']);
		$this->assign('param',$parse['query']);
		$this->assign('page',$show);
		$this->assign('prod',$data);
		$fdata=$this->fetch();
		$this->ajaxReturn($fdata,'succ',1);
	
	
	}
	public function prodtype_list(){
		$this->assign('cate',get_cate());
		$this->display();
	
	}
	//添加产品类别
	public function add_prodtype(){
			$da=get_cate();
			$this->assign('cate',$da);
			//dump($da);
			foreach($da as $k=>$v){
				
			}
			$this->display();
		
	
	}
	public function add_prodtype_save(){
	
	
			$Prod=D('protype');
			$data=array_map('trim',$_POST);
			$data['parentId']=array_pop(explode('-',$data['path']));
			//dump($data);
			if($Prod->add($data)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}

	}
	function prodtype_remove(){
			//传入删除节点的cat_id,及其path;
			//dump($_GET);
			$arr=findMenu($_GET['tid'],$_GET['path']);
			$arr=join(',',$arr);
			//dump($arr);
			$model=D('protype');
			$model->delete($arr)?$this->success():$this->error();
	}
	
	function prodtype_modify(){
			$id=$_POST['tid'];
			$map['labelname']=trim($_POST['labelname']);
			
			$model=D('protype');
			$model->where('tid='.$id)->save($map)?$this->success('修改成功',$_SERVER['HTTP_REFERER']):$this->error('未做修改',$_SERVER['HTTP_REFERER']);
	}
		
	public function add_product(){
		if($_POST['sbt']&&!empty($_POST['type'])){
			$data=array_map('trim',$_POST);
			$data['uptime']=strtotime($data['uptime']);
			$data['ip']=ip2long($_POST['ip']);
			$data['downtime']=strtotime($data['downtime']);
			if(D('products')->add($data)){
				$this->success();
			}else{
				$this->error();
			
			}
		}else{
			$this->assign('store',get_jgcate_name());
			$this->assign('cate',get_cate());
			$this->assign('tech',techman());//技术部员工名单
			$this->display();
		}
	
	}
	
	//产品详细信息
	public function prod_detail(){
		
		$Prod=D('ProdView');
		$find['pro_id']=$_GET['id'];
		$data=$Prod->where($find)->find();
		$t=D('user')->where('uid='.$data['techID'])->getField('uname');
		$data['techname']=$t;
		if(!empty($data['store'])){
			$data['position']=get_jgcate_name($data['store']);
		}else{
			$data['position']='无';
		}
	
		$parse=parse_url($_SERVER['REQUEST_URI']);
		$this->assign('param',$parse['query']);
		$this->assign('detail',$data);
		$this->display();
	}
	/*产品编辑*/
	public function edit_prod(){
		if(isset($_POST['sub'])){
			$id=$_POST['pro_id'];
			$data=$_POST;
			//$data['uptime']=strtotime($data['uptime']);
			//$data['downtime']=strtotime($data['downtime']);
			if(D('products')->where('id='.$id)->save($data)){
				$this->success('修改成功',__APP__.'/Products/index?'.$_POST['param']);
			}else{
				$this->error('未作修改',__APP__.'/Products/index?'.$_POST['param']);
			}
		}else{
			$Prod=D('ProdView');
			$find['pro_id']=$_GET['id'];
			$data=$Prod->where($find)->find();
			$t=D('user')->where('uid='.$data['techID'])->getField('uname');
			$data['techname']=$t;
			if(!empty($data['store'])){
				$data['position']=get_jgcate_name($data['store']);
			}else{
				$data['position']='无';
			}
			$this->assign('store',get_jgcate_name());
			$this->assign('cate',get_cate());
			$this->assign('tech',techman());
			$parse=parse_url($_SERVER['REQUEST_URI']);
			$this->assign('param',$parse['query']);
			$this->assign('detail',$data);
			$this->display();
		}
	}
	//产品删除
	
	public function remove_products(){
		if(D('products')->where('id='.$_POST['id'])->delete()){
			echo 1;
		}else{
			echo 0;
		}
		
	
	}
	
	public function add_jhjg(){
		if(isset($_POST['storename'])){
		
		
			$Jh=D('khjg');
			$data=array_map('trim',$_POST);
			$data['parent']=array_pop(explode('-',$data['path']));
			//dump($data);
			if($Jh->add($data)){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}

			//D('jhjg')->save($data);
		}else{
			$dad=get_jgcate();
			$this->assign('cate',$dad);
			//dump($da);
			foreach($da as $k=>$v){
				
			}
			$this->display();
		}
	}
	//机柜列表
	public function jg_list(){
	
		$this->assign('jg',get_jgcate());
		$this->display();
	}
	
	//删除机柜
	function jg_remove(){
			//传入删除节点的cat_id,及其path;
			//dump($_GET);
			$arr=findjg($_GET['id'],$_GET['path']);
			$arr=join(',',$arr);
			//dump($arr);
			$model=D('khjg');
			$model->delete($arr)?$this->success('删除成功'):$this->error('未删除');
	}
	//编辑机柜
	function jg_modify(){
			$id=$_POST['id'];
			$map['storename']=trim($_POST['storename']);
		//	dump($_POST);
			$model=D('khjg');
			$model->where('id='.$id)->save($map)?$this->success('修改成功',$_SERVER['HTTP_REFERER']):$this->error('未做修改',$_SERVER['HTTP_REFERER']);
	}

	function product_down(){
		$id=$_POST['id'];
		$save['bind']='0';
		$array['run_status']=0;
		D('order')->where('bind='.$id)->save($save);
		D('products')->where('id='.$id)->save($array);
		//订单ip列表释放
	}
	public function open_products(){
		//产品开通
		if(empty($_POST['cusid'])){
			if(empty($_GET['step'])){
				$this->assign('cate',get_cate());
				$this->display();
			}elseif($_GET['step']==2){
				$modle=M('cus_info');
				$customer=$modle->where('cusname="'.trim($_GET['cusname']).'"')->find();
				get_contact_list($customer);
				$this->assign('cust',$customer);
				$this->assign('cate',get_cate());
				$this->assign('store',get_jgcate_name());
				$this->assign('tech',techman());//技术部员工名单
				$parse=parse_url($_SERVER['REQUEST_URI']);
				$this->assign('param',$parse['query']);
				$this->display('open_products_form');
			}
		}else{
            $PD=D('products');
			$OD=d('order');
            if(!$PD->autoCheckToken($_POST)){
                $this->error('请不要重复提交',__APP__.'/Order/index?'.$_POST['param']);
            }
			$pdata=array_map('trim',$_POST);
			if(!empty($_FILES['photo1'])&&!empty($_FILES['photo2'])){
				$fileUp=upload();
				$pdata['picture1']=$fileUp[0]['savename'];
				$pdata['picture2']=$fileUp[1]['savename'];
			}
			
			$pdata['ctime']=time();
			if($pid=$PD->add($pdata)){
				$odata=$pdata;
				unset($pdata);
				$odata['from']=strtotime($odata['from']);
				$odata['to']=strtotime($odata['to']);
				$odata['product_id']=$pid;
				$OD->add($odata);
				
					//set_ip_busy($odata['ip']);
					$han['cusid']=$odata['cusid'];
					$han['uname']=Session('uname');
					$han['time']=time();
					$han['note']='开通产品';
					$han['description']=htmlspecialchars('购买产品:&nbsp;&nbsp;&nbsp;'.prod_fullname($_POST['pid']).'&nbsp;&nbsp;&nbsp;提交ip:'.trim($_POST['ip']).'&nbsp;&nbsp;&nbsp;提交域名:'.$_POST['domain']);
					if(D('handle')->add($han)){//写入跟进记录
						
						$this->success('开通成功',__APP__.'/Order/index?'.$_POST['param']);
					}else{
						$str=date('Y-m',time());
						$path='CRM_ERROR'.$str.'.log';
						$content="\r\n".date('Y:m:d-H:i:s',$time)."   CUSTOMERID:".iconv('utf-8','gb2312//IGNORE',$cus['cusname'])."   INFO:".iconv('utf-8','gb2312//IGNORE',$han['note'])."   USERNAME:".iconv('utf-8','gb2312//IGNORE',$han['uanme'])."|CREATE ERROR!\n\r";
						write_log(LOG_PATH.$path,$content);
						$this->error('操作记录写入失败,请查看日志',__APP__.'/Order/index?'.$_POST['param']);
					}
				
			
			}else{
				$this->error('请稍候再试',__URL__.'/open_products?'.$_POST['param']);
			
			}
		
		}
	}
	
	
	
//class end!
}
?>