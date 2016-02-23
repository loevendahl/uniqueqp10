<?php
include('quickpay10.php');
include(DIR_FS_DOCUMENT_ROOT.'/includes/classes/QuickpayApi.php');
	$api= new QuickpayApi();
	
	if (!defined('MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY')) {
    define('MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY', MODULE_PAYMENT_QUICKPAY_ADVANCED_APIKEY);
}
	$api->setOptions(MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY);


?>