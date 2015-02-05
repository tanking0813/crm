<?php
	//以购买产品试图模型wl
	class Gdrec_infoViewModel extends ViewModel {
		public $viewFields = array(
			
			'gd_record'=>array(
					'cusid'=>'gd_cid',
					'time'=>'gd_time',
					'note',
					'description',
					'nextnote',
					'_as'=>'gd',
					'_type'=>'LEFT',
					
				),
		
			'Cus_info'=>array(
				'id'=>'num',
				'cusname',
				'contact',
				'custype',
				'salemanId',
				'_type'=>'LEFT',
				'_as'=>'c',
				'_on'=>'gd.cusid=c.id'
				),
			
			
			'user'=>array(
					'uid',
					'uname',
					'_as'=>'u',
					'_on'=>'u.uid = c.salemanId'
				),
			);	
	}
?>