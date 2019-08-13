<?php
class Mageguru_Couponmail_Model_Observer {
    
    
    public function checkbirthday() {
        
        $enable_email=Mage::getStoreConfig('birthday_coupon/birthday_mail/birthdaymail_enable');
        
        
        if($enable_email){
            $daymonthNow = date('d').'-'.date('m');
            
            
            $collection = Mage::getModel("customer/customer")
            ->getCollection()->addAttributeToSelect("*")
            ->addFieldToFilter("dob",array('notnull' => false));
    
            foreach ($collection as $customer)
                {
                    $dob = explode(' ',$customer->getDob());
                    $date = explode('-',$dob[0]);
                    $daymonthBirthday = $date[2].'-'.$date[1];
             
                    if ( $daymonthBirthday  == $daymonthNow ) {
                        $customerId=$customer->getId();
                        $customerFirstName = mb_convert_case($customer->getFirstname(), MB_CASE_TITLE, "UTF-8");
                        $customerLastName = mb_convert_case($customer->getLastname(), MB_CASE_TITLE, "UTF-8");
                        $customerEmail = $customer->getEmail();
                        $this->sendBirthdayEmail($customerEmail,$customerFirstName,$customerLastName,$customerId);
             
                    }
                }
            
        }else{
            Mage::log('Email sending disabled',null,'info.log');
        }

    }

    public function sendBirthdayEmail($customerEmail,$customerFirstName,$customerLastName,$customerId)
    {
        $enable_coupon=Mage::getStoreConfig('birthday_coupon/discount_settings/discount_enable');
        $customerName=$customerFirstName.' '.$customerLastName;
        if($enable_coupon){
            $emailLogo=Mage::getStoreConfig('birthday_coupon/birthday_mail/image_logo');
            $url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product/watermark/'.$emailLogo;
            $couponCode = Mage::helper('couponmail')->generate_custom_coupon($customerFirstName,$customerLastName,$customerId);
            $emailTemplate  = Mage::getModel('core/email_template');
 
            $emailTemplate->loadDefault('couponmail_email_template');
            $emailTemplate->setTemplateSubject('Happy Birthday');
    
            $salesData['email'] = 'admin@siteowner.com' ; //Mage::getStoreConfig('trans_email/ident_general/email');
            $salesData['name']  = 'Site Owner'; //Mage::getStoreConfig('trans_email/ident_general/name');
     
            $emailTemplate->setSenderName($salesData['name']);
            $emailTemplate->setSenderEmail($salesData['email']);
    
            $emailTemplateVariables['username']  = $customerName;
            $emailTemplateVariables['logo_url'] = $url;
            $emailTemplateVariables['couponcode'] = $couponCode;
            $emailTemplateVariables['store_name'] = Mage::app()->getStore()->getFrontendName();
            $emailTemplateVariables['store_url'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
            $status = $emailTemplate->send($customerEmail, 'test', $emailTemplateVariables);
            $logData=array('email'=>$customerEmail,
                           'customer_name'=>$customerName,
                           'customer_id'=>$customerId,
                           'send_on'=>date('Y-m-d H:i:s'),
                           'customer_discount'=>$couponCode);
            if($status){
                $logData['status']=2;
            }else{
                $logData['status']=1;
            }
            Mage::helper('couponmail')->create_log_email_send($logData);
        }

    }
    
    
}