<?php
	//以购买产品试图模型wl
	class OrderViewModel extends ViewModel {
		public $viewFields = array(
			'Order'=>array(
				'id'=>'order_id',
				'product_id',
				'cusid',
				'payment',
				//'cus_username',
				'paid',
				//'is_paid',
				 'tax',
				 'rebate',
				'from'=>'fromtime',
				'to'=>'totime',
				'note',
				'contract_No',
				//'deleted'=>'order_deleted',
				'_as'=>'o',
				
				),
			'Cus_info'=>array(
				'id'=>'cus_id',
				'cusname',		
				'salemanId',
				'_as'=>'c',
				'_on'=>'o.cusid=c.id'
				),
			'Products'=>array(
				//'id'=>'proid',
				'pid',
				'_as'=>'pro',
				'_on'=>'o.product_id=pro.id',
			),
		);
	}
?>