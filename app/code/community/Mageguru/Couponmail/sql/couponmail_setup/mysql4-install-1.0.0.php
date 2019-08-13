<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE IF NOT EXISTS `mageguru_email_send_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_discount` text NOT NULL,
  `send_on` datetime NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1=>Not Send 2=>Send',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		
SQLTEXT;

$installer->run($sql);

$installer->endSetup();
	 