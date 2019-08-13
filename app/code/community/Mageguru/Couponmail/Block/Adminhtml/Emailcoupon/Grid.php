<?php

class Mageguru_Couponmail_Block_Adminhtml_Emailcoupon_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("emailcouponGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("couponmail/emailcoupon")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("couponmail")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("email", array(
				"header" => Mage::helper("couponmail")->__("Email-Id"),
				"index" => "email",
				));
				$this->addColumn("customer_name", array(
				"header" => Mage::helper("couponmail")->__("Customer Name"),
				"index" => "customer_name",
				));
				$this->addColumn("customer_discount", array(
				"header" => Mage::helper("couponmail")->__("Generated Coupon"),
				"index" => "customer_discount",
				));
					$this->addColumn('send_on', array(
						'header'    => Mage::helper('couponmail')->__('Email send on'),
						'index'     => 'send_on',
						'type'      => 'datetime',
					));
						$this->addColumn('status', array(
						'header' => Mage::helper('couponmail')->__('Status'),
						'index' => 'status',
						'type' => 'options',
						'options'=>Mageguru_Couponmail_Block_Adminhtml_Emailcoupon_Grid::getOptionArray11(),				
						));
						
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return '#';
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_emailcoupon', array(
					 'label'=> Mage::helper('couponmail')->__('Remove Emailcoupon'),
					 'url'  => $this->getUrl('*/adminhtml_emailcoupon/massRemove'),
					 'confirm' => Mage::helper('couponmail')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray11()
		{
            $data_array=array();
			$data_array[1]='Not Sent';
			$data_array[2]='Sent';			
            return($data_array);
		}
		static public function getValueArray11()
		{
            $data_array=array();
			foreach(Mageguru_Couponmail_Block_Adminhtml_Emailcoupon_Grid::getOptionArray11() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}