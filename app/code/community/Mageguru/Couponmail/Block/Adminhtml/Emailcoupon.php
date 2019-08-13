<?php


class Mageguru_Couponmail_Block_Adminhtml_Emailcoupon extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_emailcoupon";
	$this->_blockGroup = "couponmail";
	$this->_headerText = Mage::helper("couponmail")->__("Emailcoupon Manager");
	$this->_addButtonLabel = Mage::helper("couponmail")->__("Add New Item");
	parent::__construct();
	$this->_removeButton('add');
	}

}