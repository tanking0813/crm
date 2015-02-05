<?php
	class IpoolAction extends Action {
		function _initialize() {
			load("@common");
		}
		public function index(){
			
			$Ip=D('ip_pool');
			$count=$Ip->count();
			$this->assign('count',$count+1);
			$pool=$Ip->select();
			$this->assign('pool',$pool);
		
			$this->display();	
		}
	
		public function add_pool(){
			
			$insert['start']=ip2long($_POST['ipleft']);
			$insert['end']=ip2long($_POST['ipright']);
			$insert['name']=trim($_POST['labelname']);
			$insert['ctime']=time();
			$pid=D('ip_pool')->add($insert);
			
			if($pid){
				$this->success('插入成功',__URL__);
			}else{
				$this->error('插入失败',$_SERVER['HTTP_REFERER']);
			}
		
		}
		
		public function get_resource(){
			$where_b['area']=$_GET['searchArea'];
			//$where_b['status']='busy';
			$res=D('ip_resource')->where($where_b)->order('status desc,ip asc')->select();
			$Cus=D('cus_info');
			$return_b=null;$return_i=null;
			foreach($res as &$val){
				if($val['status']=='busy'){
					$cond['id']=$val['userid'];
					$val['customer']=$Cus->where($cond)->getField('cusname');
					$return_b[]=$val;
				}else{
					$return_i[]=$val;
				}
				
			}
			$this->assign('return_b',$return_b);
			$data1=$this->fetch('res_busy');
			
			$this->assign('return_i',$return_i);
			$data2=$this->fetch('res_idle');
			$this->ajaxReturn($data1,$data2,1);
			
		}
		
		
		public function delete_ip_area(){
			$where['id']=$_GET['need'];
			if(D('ip_pool')->where($where)->delete()){
				header('location:'.__URL__);
			}else{
				$this->error('出错啦',$_SERVER['HTTP_REFERER']);
			}
		
		}
		public function checkUniqIp(){
			
			$ip=explode(',',$_GET['check_ip']);
			$j=count($ip);
			for($i=0;$i<$j;++$i){
				$ipInt=ip2long($ip[$i]);
				if(!check_inner_ip($ipInt)){
					exit('a');
				}else{
					$ips[]=$ipInt;
				}
			}
			
			$where['ip']=array('in',$ips);
			$where['attr']=array('neq','pub');
			$where['status']='busy';
			$tag=D('ip_resource')->where($where)->select();
			if($tag){
				exit('c');
			}else{
				exit('b');
			}
		}

		public function flush_resource(){
		
			set_time_limit(0);
			$Pro=D('protype');
			$ipInUse=D('order')->Field('ip,cusid,pid')->select();
		
			foreach($ipInUse as &$vts){
				$parent=$Pro->where('id='.$vts['pid'])->getField('parentId');
				if($parent==57){
					/**虚拟主机IP公用**/
					$vts['attr']='pub';
					$vts['cusid']=0;
				}else{
					$vts['attr']='pri';
				}
			}
			$Resource=D('ip_resource');
			$count=0;
			foreach($ipInUse as &$v){
				$v['ip']=explode(',',$v['ip']);
				$count+=count($v['ip']);
			}
			$width = 1000;   /*显示的进度条长度，单位 px*/
			$total = $count; /*显示的步骤数，可以用数据库中实际取得的数组数代替*/
			$pix = $width / $total; /*每条记录的操作所占的进度条单位长度*/
			$progress = 0;  /*当前进度条长度*/
			$maxheight=$total*20;
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/transitional.dtd">
			<html>
			<head>
			   <title>IP资源池刷新</title>
			   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			   <style>
			   body, div input { font-family: Tahoma; font-size: 9pt; }
			   .scrolldiv{font-family: Tahoma; font-size: 9pt;height:20px;line-height:20px;}
			   </style>
			   <script language="JavaScript">
			   <!--
			   function updateProgress(sMsg, iWidth)
			   { 
				   document.getElementById("status").innerHTML = sMsg;
				   document.getElementById("progress").style.width = iWidth + "px";
				   document.getElementById("percent").innerHTML = parseInt(iWidth /'.$width.' * 100) + "%";
				}
				
				function listDetail(message,scrollpix){
					var txtName = document.getElementById("txtName");
					var htmlSpan = document.createElement("div"); 
					htmlSpan.setAttribute("class","scrolldiv");
					htmlSpan.innerHTML = message; 
					document.getElementById("proclist").appendChild(htmlSpan);
					document.getElementById("proclist").scrollTop=scrollpix;
				}
			   //-->
			   </script>    
			</head>
			<body style="background:#DDEEF2;">
			<div style="margin: 4px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: '.($width+8).'px">
			   <div style="margin:0 auto;text-align:center"><font color="gray">IP资源刷新程序</font></div>
			   <div style="padding: 0; background-color: white; border: 1px solid navy; width:'.$width.'px">
				   <div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center;  height: 16px"></div>            
			   </div>
			   <div id="status">&nbsp;</div>
			   <div id="percent" style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt">0%</div>
			</div>

			<div style="margin: 4px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: '.($width+8).'px">
			   <div><font color="gray">详细信息:</font></div>
				<div id="proclist" style="width:'.$width.'px;height:300px;background:#fff;overflow-y:auto;"></div>
			</div>
			
			<div style="margin: 4px auto;width:'.($width+8).'px;text-align:center;"><input style="width:80px;height:30px;margin:0 auto;text-align:center;line-height:30px;font-size:12px;font-weight:bold;" type="button" value="完 成" onclick="window.location.href=\''.__URL__.'\'"/></div>';
			flush();    /*将输出发送给客户端浏览器*/
			$procY=0;
			foreach($ipInUse as $vbp){
				$vir_ip=$vbp['ip'];
				foreach($vir_ip as $val){
					$save['status']='busy';
					$save['userid']=$vbp['cusid'];
					$save['attr']=$vbp['attr'];
					$where['ip']=ip2long($val);
					$Resource->where($where)->save($save);
					echo '<script language="JavaScript">
						updateProgress("正在操作 '.$val.'，请稍候....", '.min($width, intval($progress)).');
						listDetail("<font color=\"green\">'.$val.'刷新成功,</font>",'.min($maxheight,intval($procY)).');
						</script>';
					flush(); 
					
				}
				$progress += $pix;
				$procY+=20;
				
			}
			echo '<script language="JavaScript">
				  updateProgress("操作完成！", '.$width.');
				  listDetail("<font color=\"green\">完成!</font>",'.$maxheight.');
				  </script>';
			flush();
			echo '</body></html>';
		}
	}

?>