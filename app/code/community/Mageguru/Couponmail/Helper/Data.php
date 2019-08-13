<?php

class Mageguru_Couponmail_Helper_Data extends Mage_Core_Helper_Abstract{
    
    public function generate_custom_coupon($customerFirstName,$customerLastName,$custId){
		$couponcode='';
        $couponSuffix = Mage::getStoreConfig('birthday_coupon/discount_settings/discount_suffix');
        $couponPrefix = Mage::getStoreConfig('birthday_coupon/discount_settings/discount_prefix');
        $couponType = Mage::getStoreConfig('birthday_coupon/discount_settings/discount_type');
        $couponExpiry = Mage::getStoreConfig('birthday_coupon/discount_settings/discount_expiry');
        $couponDiscountAmount = Mage::getStoreConfig('birthday_coupon/discount_settings/applied_discount_amount');
        $todayDate=date('m/d/Y');
        $toDate=date('m/d/Y',strtotime($todayDate. '+'.$couponExpiry.' days'));
        
		if($couponPrefix!=''){
			$couponcode.=$couponPrefix.'-';
		}
        $couponcode.=Mage::helper('core')->getRandomString(4).'-';
		$couponcode.=strtoupper($customerFirstName);
		if($couponSuffix!=''){
			$couponcode.='-'.$couponSuffix;
		}
        $couponcode=strtoupper($couponcode);
        $this->generateRule($couponcode,$customerFirstName,$couponDiscountAmount,$todayDate,$toDate,'',0,strtolower($couponcode),$customerLastName,$custId,$couponType);
        return $couponcode;
    }
    
    public function create_log_email_send($data=array()){
        //Mage::log(print_r($data,true),null,'coupon-log.log');
        $couponMailModel=Mage::getModel('couponmail/emailcoupon');
        $couponMailModel->setData($data);
        $couponMailModel->save();
    }
    
    public function generateRule($code,$customer_name,$disAmt,$fromDate,$toDate,$description,$sortOrder,$skuStr,$customerLastName,$customerId,$couponType){
            
            $data = array(
                'product_ids' => null,
                'name' => 'AUTO_GENERATION CUSTOMER_'.$customerId.' - '.$disAmt.'% Summer discount',
                'description' => $description,
                'is_active' => 1,
                'website_ids' => array(1),
                'customer_group_ids' => array(1),
                'coupon_type' => 2,
                'coupon_code' => $code,
                'uses_per_coupon' => 1,
                'uses_per_customer' => 1,
                'from_date' => $fromDate,
                'to_date' => $toDate,
                'sort_order' => 0,
                'is_rss' => 1,
                'rule' => array(
                    'conditions' => array(
                        array(
                            'type' => 'salesrule/rule_condition_combine',
                            'aggregator' => 'all',
                            'value' => 1,
                            'new_child' => null
                        )
                    )
                ),
                'simple_action' => $couponType,
                'discount_amount' => $disAmt,
                'discount_qty' => 0,
                'discount_step' => null,
                'apply_to_shipping' => 0,
                'simple_free_shipping' => 0,
                'stop_rules_processing' => 0,
                'rule' => array(
                    'actions' => array(
                        array(
                            'type' => 'salesrule/rule_condition_product_combine',
                            'aggregator' => 'all',
                            'value' => 1,
                            'new_child' => null
                        )
                    )
                ),
                'store_labels' => array('Summer discount')
            );
            
            
            $model = Mage::getModel('salesrule/rule');
            //$data = $this->_filterDates($data, array('from_date', 'to_date'));
             
            $validateResult = $model->validateData(new Varien_Object($data));
            
            if ($validateResult == true) {
             
                //if (isset($data['simple_action']) && $data['simple_action'] == 'by_percent'
                //        && isset($data['discount_amount'])) {
                //    $data['discount_amount'] = min(100, $data['discount_amount']);
                //}
             
                if (isset($data['rule']['conditions'])) {
                    $data['conditions'] = $data['rule']['conditions'];
                }
             
                if (isset($data['rule']['actions'])) {
                    $data['actions'] = $data['rule']['actions'];
                }
             
                unset($data['rule']);
             
                $model->loadPost($data);
             
                $model->save();
            }
            
            
        }
    
    
}