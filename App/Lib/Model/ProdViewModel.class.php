<?php
	//已购买产品试图模型wl
	class ProdViewModel extends ViewModel {
		public $viewFields = array(
			'Products'=>array(
				'id'=>'order_id',
				'cusid',
				'pid',
				'creator',
				'ip',
				'domain',
				
				'cus_username',
				
				'ctime'=>'order_ctime',
				
				'update_time',
				
				'run_status'=>'order_status',
				
				'deleted'=>'order_deleted',
				'store',
				'style',
				'port',	
				'mac',
				'manum',
				'size',
				'techID',
				'passwd',
				'technote',
				'run_status',
				'serialNo',
				'cpu',
				'memory',
				'disk',
				'motherboard',
				'picture1',
				'picture2',
				'_as'=>'o'
				),
			'Cus_info'=>array(
				'id'=>'cus_id',
				'cusname',
				'contact',
				'cont_job',
				'mobile',
				'tel',
				'email',
				'address',
				'id_card',
				'web',
				'salemanId',
				'ctime'=>'cus_ctime',
				'custype',
				'_as'=>'c',
				'_on'=>'o.cusid=c.id'
				),
			'Order'=>array(
				'from'=>'fromtime',
				'to'=>'totime',
				'note'=>'ordernote',
				'payment',
				'paid',
				'contract_No',
				'is_on',
				'_as'=>'od',
				'_on'=>'od.product_id=o.id',
			
			),	
			'Protype'=>array(
				'tid'=>'pro_tid',
				'parentId',
				'labelname',
				'path',
				'_as'=>'p',
				'_on'=>'o.pid=p.tid'
				),
		);
	}
?>