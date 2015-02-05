<?php
	function check_permission($param){
		$perm=Session('perm');
		if($perm=='all'){
			return 1;
		}
		//继承子组权限
		if(Session('inherit')=='2'){
			//$perm=get_permission(Session('group'));
			//特殊权限用户,判断其权限
			
			$pms=explode(',',$perm);
			if(in_array($param,$pms)){
				return 1;
			}else{
				return false;
			}
		}elseif(Session('inherit')=='1'){
			//继承部门权限,忽略自身权限
			$perm=get_perm_d(Session('group'));
			
			if(in_array($param,$perm)){
				return 2;
			}else{
				return false;
			}
		
		}
	
	}
	//部门权限数组
	function get_perm_d($groupid){
		$perm=array();
		$pm=D('department')->where('did='.$groupid)->getField('perm');
		$perm=explode(',',$pm);
		return $perm;
	
	}
	//员工权限数组
	function get_perm_m($uid){
		$User=D('User');
		$perm=array();
		$pm=$User->Field('department,perm,inherit')->where('uid='.$uid)->find();
		if($pm['inherit']==1){
			$perm=get_perm_d($pm['department']);
		}elseif($pm['inherit']==2){
			if(!empty($pm['perm']))
			$perm=explode(',',$pm['perm']);
		}
		return $perm;
	}
	
	//返回所有部门
	function get_department(){
		$User=D('department');
		$depart=$User->Field('did,dname,perm')->select();
		
		if($depart){
			array_shift($depart);
			return $depart;
		}else{
			return false;
		}
	}
	//返回销售部所有人
	function saleman(){
		$User=D('user');
		$saleman=$User->Field('uid,uname')->where('department in ("2","7","8")')->select();
		if($saleman){
			if(Session('group')!='2'){
				array_unshift($saleman,array('uid'=>1,'uname'=>'石秀川'));
			}
			return $saleman;
		}else{
			return false;
		}
	}
	
	//同部门人列表
	function same_depart_man(){
		$where['department']=Session('group');
		$man=D('user')->Field('uid,uname')->where($where)->select();
		if($man)
			return $man;
		else
			return false;
	}
	//返回所有员工
	function allusers(){
		$User=D('user');
		$tech=$User->Field('uid,uname')->select();
		if($tech){
			return $tech;
		}else{
			return false;
		}
	
	}
	//返回技术部所有人
	function techman(){
		$User=D('user');
		$tech=$User->Field('uid,uname')->where('department=3 ')->select();
		if($tech){
			return $tech;
		}else{
			return false;
		}
	}
	
	function prolist(){
		$Pro=D('protype');
		$prolist=$Pro->Field('tid,labelname')->select();
		if($prolist){
			return $prolist;
		}else{
			return false;
		}
	}
	//获取产品全称
	function prod_fullname($tid){
		$Pro=D('protype');
		$bpath=$Pro->Field('concat(path,"-",tid) as bpath')->where('tid='.$tid)->find();
		$array=explode('-',$bpath['bpath']);
		array_shift($array);//去0
		$map['tid']=array('in',$array);
		$labelname=$Pro->Field('labelname')->where($map)->select();
		$return='';
		foreach($labelname as $val){
			$return.=$val['labelname'].'>>';
		}
		$return=rtrim($return,'>>');
		return $return;
	}
	
	
	function get_jgcate_name($id){
			$cate=D('khjg');
			if(empty($id)){
			$list=$cate->Field('id,parent,storename,path,concat(path,"-",id) as bpath')->order('bpath asc')->select();
			
			foreach($list as $key=>&$value){
				
				$bpath=$cate->Field('concat(path,"-",id) as bpath')->where('id='.$value['id'])->find();
				$array=explode('-',$bpath['bpath']);
				array_shift($array);//去0
				$map['id']=array('in',$array);
				$labelname=$cate->Field('storename')->where($map)->select();
				$return='';
				foreach($labelname as $val){
					$return.=$val['storename'].'-';
				}
				$return=rtrim($return,'-');
				$value['fullname']=$return; 

			}
			return $list;
			}else{
			
				$bpath=$cate->Field('concat(path,"-",id) as bpath')->where('id='.$id)->find();
			$array=explode('-',$bpath['bpath']);
			array_shift($array);//去0
			$map['id']=array('in',$array);
			$storename=$cate->Field('storename')->where($map)->select();
			$return='';
			foreach($storename as $val){
				$return.=$val['storename'].'-';
			}
			$return=rtrim($return,'-');
			return $return;
			
			
			
			}
	
	
	
	}
	
	
	function get_jgcate(){
			$cate=D('khjg');
			$list=$cate->Field('id,parent,storename,path,concat(path,"-",id) as bpath')->order('bpath asc')->select();
			
			foreach($list as $key=>$value){
				
				$total=(count(explode('-',$value['bpath']))-2)*3;

				for($i=0;$i<$total;$i++){

					$list[$key]['fg'].='&nbsp;&nbsp;&nbsp;';
				}

			}
			return $list;
	
	}
	//部门分类列表
	function get_dcate(){
		$cate = D('department');
		 $list = $cate->Field('did,parentid,dname,path,concat(path,"-",did) as bpath')->order('bpath asc')->select();
		foreach($list as $key=>$value){
				$total=(count(explode('-',$value['bpath']))-2)*3;
				for($i=0;$i<$total;$i++){
					$list[$key]['fg'].='&nbsp;&nbsp;';
				}
			} 
		return ($list);

	}
	//分类列表
	function get_cate(){
			$cate=D('protype');
			$list=$cate->Field('tid,parentId,labelname,path,concat(path,"-",tid) as bpath')->order('bpath asc')->select();
			
			foreach($list as $key=>$value){
				
				$total=(count(explode('-',$value['bpath']))-2)*3;

				for($i=0;$i<$total;$i++){

					$list[$key]['fg'].='&nbsp;&nbsp;&nbsp;';
				}

			}
			return $list;
	}
	
	
		//后台删除分类列表函数
		function findMenu($cat_id,$path){
			//传入cat_id和path
			$d=D('protype');
			$data=$d->select();
			//dump($data);
			foreach($data as $value){
					if(0===stripos($value['path'],$path.'-'.$cat_id)){
						//查找包含path-cat_id的子目录，将其cat_id组合成数组
						$arr[]=$value['tid'];
						continue;
					}	
			}
			if(empty($arr)){
				//最终节点获取到空数组，直接使用其cat_id
				$arr=array($cat_id);
			
			}else{

				array_unshift($arr,$cat_id);
			
			}
			//返回需删除的节点树列表
			return $arr;
		}
		
		function findjg($id,$path){
			//传入cat_id和path
			$d=D('khjg');
			$data=$d->select();
			//dump($data);
			foreach($data as $value){
					if(0===stripos($value['path'],$path.'-'.$id)){
						//查找包含path-cat_id的子目录，将其cat_id组合成数组
						$arr[]=$value['id'];
						continue;
					}	
			}
			if(empty($arr)){
				//最终节点获取到空数组，直接使用其cat_id
				$arr=array($id);
			
			}else{

				array_unshift($arr,$id);
			
			}
			//返回需删除的节点树列表
			return $arr;
		}
		//日志记录
	function write_log($path,$content){
			//dirname($path)
		if(is_writable(dirname($path))){
		//$hand=@fopen($path,'a+');
			if($hand=@fopen($path,'a+')){
				
				fwrite($hand,$content);
				fclose($hand);
				return true;
			}else{
				return false;
			}
		}
	}
	
	
	
	//new 12-22
	/*输出订单到期时间格式*/
	function order_end_check($totime){
		if(empty($totime)){
			return '无';
		}
		$time=$totime-time();
		if($time<=0){
			return '已过期';
		}elseif($time<=86400*7){
			switch(ceil($time/86400)){
				case 1:
					$str='1天';
					break;
				case 2:
					$str='2天';
					break;
				case 3:
					$str='3天';
					break;
				case 4:
					$str='4天';
					break;
				case 5:
					$str='5天';
					break;
				case 6:
					$str='6天';
					break;
				case 7:
					$str='7天';
					break;
				
			}
			return  $str;
		}else{
			return date('Y-m-d',$totime);
		
		}
	
	}
	//换算到期时间范围new
	function get_order_endtime($day){
		$day*=86400;
		$tm=time();
		$time=$day+$tm;//-$day;
		//return $time;
		return array(array('egt',$tm),array('elt',$time),);
	}
	//new
	function gate_kq_time($tonum=true){
				$array=getdate(time());
				
			if($array['wday']==0||$array['wday']==6){	//周末
				$id=2;
			
			}else{
				$id=1;
			}
	
			$kaoqin=D('kaoqin_conf')->where('id='.$id)->find();
			$tm['am_s']=date('Y-m-d').' '.$kaoqin['am_s'];//早上开始时
			$tm['am_e']=date('Y-m-d').' '.$kaoqin['am_e'];//早上结束时
			$tm['pm_s']=date('Y-m-d').' '.$kaoqin['pm_s'];//下午开始时
			$tm['pm_e']=date('Y-m-d').' '.$kaoqin['pm_e'];//下午结束时
			$tm['std_up']=date('Y-m-d').' '.$kaoqin['std_up'];//标准早上时
			$tm['std_down']=date('Y-m-d').' '.$kaoqin['std_down'];//标准下午时
			if($tonum){
				$map=array_map('strtotime',$tm);
				return $map;
			}else{
				return $tm;
			}
	}
	
	//星期输出
	function week_zh_cn($time){
		if(empty($time)){
			$week=date('D');
		}else{
			$week=date('D',$time);
		}
		switch($week){
			case 'Mon':
				return '周一';
			case 'Tue':
				return '周二';
			case 'Wed':
				return '周三';
			case 'Thu':
				return '周四';
			case 'Fri':
				return '周五';
			case 'Sat':
				return '周六';
			case 'Sun':
				return '周日';
		
		}
	
	
	}
	//客户联系人列表
	function get_contact_list(&$customer){
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
	
	}
	function get_cus_type($type){
		switch($type){
			
			case 1:
				return '<strong style="color:green">意向客户</strong>';
			case 2:
				return '<strong style="color:blue">成交客户</strong>';
			case 3:
				return '<strong style="color:#666">曾合作客户</strong>';
			

		}
	
	
	}
	
	function order_ctime_sql($st){
		$mt=date('n');
		$year=date('Y');
		$month=date('Y-m');
		if(in_array($mt,array(1,2,3))){
			//第一季度
			$start=$year.'-01-01';
			$end=$year.'-04-01';
		}elseif(in_array($mt,array(4,5,6))){
			//第二季度
			$start=$year.'-04-01';
			$end=$year.'-07-01';
		}elseif(in_array($mt,array(7,8,9))){
			//第三季度
			$start=$year.'-07-01';
			$end=$year.'-10-01';
		}elseif(in_array($mt,array(10,11,12))){
			//第四季度
			$start=$year.'-10-01';
			$end=($year+1).'-01-01';
		}
		$pm=($mt-1)==0?12:$mt-1;
		$nm=($mt+1)==13?12:$mt+1;
		$premonth=date('Y').'-'.$pm;//上月一号
		$nextmonth=date('Y').'-'.$nm;//下月一号
		switch($st){
		
			case '1':
				$data=array(array('egt',strtotime($month.'-01')),array('lt',strtotime($nextmonth.'-01')));
				break;//本月
			case '2':
				$data=array(array('egt',strtotime($premonth.'-01')),array('lt',strtotime($month.'-01')));
				break;//上月
			case '3':
				$data=array(array('egt',strtotime($start)),array('lt',strtotime($end)));
				break;//本季度
			case '4':
				$data=array(array('egt',strtotime($year.'-01-01')),array('lt',strtotime((++$year).'-01-01')));
				break;//本年
			default:
				$data=array(array('egt',strtotime($st.'-01-01')),array('elt',strtotime($st.'-12-31')));
				break;//其他年份
		}
		return $data;
	
	}
	//IP池是否内部资源判断
	function check_inner_ip($ip){
		$Pool=D('ip_pool');
		$po=$Pool->select();
		foreach($po as $p){
			if($ip>=$p['start'] && $ip<=$p['end'])
				return true;
			else
			    continue;
		}
		return false;
	
	}
	function set_ip_busy($ipstring){
		$ip=explode(',',$ipstring);
		foreach($ip as &$vbn){
			$vbn=ip2long($vbn);
		}
		$ipin['ip']=array('in',$ip);
		$save['status']='busy';
		D('ip_resource')->where($ipin)->save($save);
		return;
	}
	
	
	
	
	function upload() {
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
		if(!$upload->upload()) {// 上传错误提示错误信息
			//$this->error($upload->getErrorMsg());
			return false;
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			return $info;
		}

    }
?>
