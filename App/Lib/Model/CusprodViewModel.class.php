<?php
	//以购买产品试图模型wl
	class CusprodViewModel extends ViewModel {
		public $viewFields = array(
			//客户
			'Cus_info'=>array(
				//'id'=>'cus_id',
				'cusname',//=>'customer_name',
				//'contact',
				//'cont_job',
				'mobile',
				'tel',
				'email',
				'address',
				//'id_card',
				//'web',
				//'salemanId',
				//'ctime'=>'cus_ctime',
				//'custype',
				'_as'=>'c',
				),
				//订单
			'Order'=>array(
				'id'=>'order_id',
				//'cusid',
				//'creator',
				'ip'=>'order_ip',
				'domain'=>'order_domain',
				//'payment',
				//'ctime'=>'order_ctime',
				//'from'=>'fromtime',
				//'to'=>'totime',
				//'note',
				//'status'=>'order_status',
				'bindID',
				'_as'=>'o',
				'_on'=>'c.id=o.cusid',
			
				),
			'Products'=>array(
				'pid'=>'products_id',//唯一产品id
				//'proname',//内部识别名
				'type'=>'products_type',//类型关联类型表tid
				'model'=>'products_model',//设备型号
				'store',
				//'size',
				'ip'=>'products_ip',//设备ID，唯一
				//'techid',
				//'password',
				//'uptime',
				//'downtime',
				//'note'=>'Products_note',
				'_as'=>'pd',
	
				'_on'=>'o.bindID=pd.ip',
				),
				//产品类型
			'Protype'=>array(
				'tid',
				//'parentId',
				'labelname',
				'path',
				'_as'=>'p',
				'_on'=>'p.tid=pd.type',
			
				),
			
			
		);
	}
?>