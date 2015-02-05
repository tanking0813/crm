<?php
	//以购买产品试图模型wl
	class Cus_infoViewModel extends ViewModel {
		public $viewFields = array(
			'Cus_info'=>array(
				'id'=>'num',
				'cusname',
				'contact',
				'cont_job',
				'mobile',
				'tel',
				'qq',
				'email',
				'address',
				'id_card',
				'web',
				'salemanId',
				'ctime'=>'cus_ctime',
				'custype',
				'_type'=>'LEFT',
				'_as'=>'c'
				
				),
			'Handle'=>array(
				'cusid'=>'handle_cid',
				'time'=>'handle_time',
				'statify',
				'note'=>'handle_note',
				'description',
				'_as'=>'hd',
				'_type'=>'LEFT',
				'_on'=>'hd.cusid=c.id'
			),
			
			'Products'=>array(
				'id'=>'order_id',
				'cusid',
				'ip',
				'pid',
				'ctime'=>'order_ctime',
				'_as'=>'o',
				'_type'=>'LEFT',
				'_on'=>'o.cusid=c.id'
				),
			'Protype'=>array(
				'tid',
				'parentId',
				'labelname',
				'path',
				'_as'=>'p',
				'_on'=>'p.tid=o.pid'
				),
			'user'=>array(
					'uname',
					'_as'=>'u',
					'_on'=>'u.uid = c.salemanId',
					
				),
			);	
	}
?>