<?php
class Mageguru_Couponmail_Model_Mysql4_Emailcoupon extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("couponmail/emailcoupon", "id");
    }
}