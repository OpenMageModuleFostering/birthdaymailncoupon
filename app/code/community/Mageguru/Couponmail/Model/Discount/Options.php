<?php

class Mageguru_Couponmail_Model_Discount_Options{
    
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'by_percent', 'label'=>Mage::helper('adminhtml')->__('Fixed Discount on whole cart')),
            array('value' => 'cart_fixed', 'label'=>Mage::helper('adminhtml')->__('Fixed Amount Discount for whole cart')),
        );
    }
    
    
}

?>