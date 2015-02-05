<?php
	//已购买产品试图模型wl
	class HaViewModel extends ViewModel {
		public $viewFields = array(
			'Products'=>array(
				'id'=>'order_id',
				'cusid',
				'pid',
				'_as'=>'o',
				),
			'Cus_info'=>array(
				'id'=>'cus_id',
				'cusname',
				'_as'=>'c',
				'_on'=>'o.cusid=c.id',
				),
			'Protype'=>array(
				'tid'=>'pro_tid',
				'parentId',
				'labelname',
				'path',
				'_as'=>'p',
				'_on'=>'o.pid=p.tid',
				),
			'handle'=>array(
				'id'=>'hid',
				'cusid',
				'uname'=>'user',
				'time',
				'description'=>'content',
				'_as'=>'h',
				'_on'=>'h.cusid=c.id',
			),
		);
	}
?>