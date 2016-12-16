<?php
/*
  quickpay.php

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2008 Jakob Høy Biegel

  Released under the GNU General Public License
*/
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_TITLE', 'QuickPay: Online Payment');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_PUBLIC_TITLE', 'QuickPay: Online Payment');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_DESCRIPTION', 'QuickPay Advanced Online payment');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_EMAIL_FOOTER', 'Payment is now reserved. The payment has the following transaction-number: %s.' . "\n" . 'When the order is handled, the amount is transferetd to ' . STORE_NAME); 
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_FEEINFO', '(Fee is added in payment window)');
define('MODULE_PAYMENT_QUICKPAY_ADVANCED_FEELOCKINFO', ' fee');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_SELECT_CARD', '* Select what kind of payment type you want to use for your online payment\n');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_WAIT', 'Please wait a moment. Payment page is prepared...');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_ERROR', 'Unable to process online payment');


// Transaction errors  
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_MERCHANT_UNKNOWN', 'Unknown Merchant Number');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CARDNO_NOT_VALID', 'Invalid card number');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CVC_NOT_VALID', 'Invalid control digits');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_ORDERID', 'Invalid or missing OrderId');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_TRANSACTION_DECLINED', 'Transaction was not approved');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_WRONG_NUMBER_FORMAT', 'Invalid format of amount');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_ILLEGAL_TRANSACTION', 'Invalid transaction');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_TRANSACTION_EXPIRED', 'Transactionen time out');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_NO_ANSWER', 'No reply');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_SYSTEM_FAILURE', 'System error');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CARD_EXPIRED', 'Card has expired');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_COMMUNICATION_FAILURE', 'Communication error');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_INTERNAL_FAILURE', 'Internal error');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CARD_NOT_REGISTERED', 'Not in the system');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_RETRY_FAILURE', 'Unable to process transaction twice');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_UNKNOWN', 'Error in the typed text');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CANCELLED', 'Transaction was cancelled') ;
  
// Name of credit cards options (3D Secure)
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_JCB_3D_TEXT', 'JCB 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MAESTRO_3D_TEXT', 'Maestro 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MAESTRO_DK_3D_TEXT', 'Maestro 3D-Secure (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_3D_TEXT', 'MasterCard 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DK_3D_TEXT', 'Mastercard 3D-Secure (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_3D_TEXT', 'Visa 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DK_3D_TEXT', 'Visa 3D-Secure (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_3D_TEXT', 'Visa Electron 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_DK_3D_TEXT', 'Visa Electron 3D-Secure (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DEBET_3D_TEXT', 'Visacard debet 3D-secure ');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DEBET_DK_3D_TEXT', 'Visacard debet 3D-secure (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_CREDITCARD_3D_TEXT', 'Creditcards 3D-secure');

// Name of credit cards options 
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_AMEX_TEXT', 'American Express');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_AMEX_DK_TEXT', 'American Express (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DANKORT_TEXT', 'Dankort');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DANSKE_DK_TEXT', 'Danske Netbank');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DINERS_TEXT', 'Diners Club');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DINERS_DK_TEXT', 'Diners Club (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_EDANKORT_TEXT', 'eDankort');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_JCB_TEXT', 'JCB');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_TEXT', 'Mastercard');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DK_TEXT', 'Mastercard (Danish)');
 define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DEBET_TEXT', 'Mastercard debet');
 define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DEBET_DK_TEXT', 'Mastercard debet(Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_NORDEA_DK_TEXT', 'Nordea Netbank');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_TEXT', 'Visa');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DK_TEXT', 'Visa (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_TEXT', 'Visa Electron');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_DK_TEXT', 'Visa Electron (Danish)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_FBG1886_TEXT', 'Forbrugsforeningen af 1886');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_CREDITCARD_TEXT', 'Creditcards');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_PAYPAL_TEXT', 'Paypal');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_SOFORT_TEXT', 'Sofort');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_IBILL_TEXT', 'ViaBill payment');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_IBILL_DESCRIPTION', 'Buy now - pay when you wish');
 // define('MODULE_PAYMENT_QUICKPAY_ADVANCED_PAII_TEXT', 'Paii mobile payment');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MOBILEPAY_TEXT', 'Mobilepay payment');
  
  
  //Quickpay added
  //Install
    define('MODULE_ADMIN_LABEL_ENABLE', 'Aktivér Quickpay online betaling');
	define('MODULE_ADMIN_TEXT_ENABLE', 'Vil du anvende denne betalingsmetode?<br>');
	 define('MODULE_ADMIN_LABEL_SORT', 'Visning rækkefølge');
	define('MODULE_ADMIN_TEXT_SORT', 'Angiv rækkefølge for visning. Laveste vises først<br>');
	define('MODULE_ADMIN_LABEL_ZONE', 'Betaling zone');
	define('MODULE_ADMIN_TEXT_ZONE', 'Hvis en zone er valgt, anvend kun denne betalingsmetode i den valgte zone.<br>');
	define('MODULE_ADMIN_LABEL_MERCHANT', 'Quickpay Merchant ID');
	define('MODULE_ADMIN_TEXT_MERCHANT', 'Som angivet i <a href="https://manage.quickpay.net" target="_blank">Manager</a> -> Settings -> integration -> Merchant ID<br>');
	define('MODULE_ADMIN_LABEL_USERAPIKEY', 'API bruger key');
	define('MODULE_ADMIN_TEXT_USERAPIKEY', 'Som angivet i <a href="https://manage.quickpay.net" target="_blank">Manager</a> -> Settings -> integration -> API user key<br>');
	define('MODULE_ADMIN_LABEL_USERAGREEMENT', 'API aftale ID');
	define('MODULE_ADMIN_TEXT_USERAGREEMENT', 'Som angivet i <a href="https://manage.quickpay.net" target="_blank">Manager</a> -> Settings -> integration -> API User Agreement ID<br>');
	define('MODULE_ADMIN_LABEL_GROUP','Gruppe betalingsmuligheder ');
	define('MODULE_ADMIN_TEXT_GROUP','Kommasepareret Quickpay betalingsmuligheder inkluderet i gruppen. max. 255 tegn (<a href=\'http://tech.quickpay.net/appendixes/payment-methods\' target=\'_blank\'><u>Vis tilgængelige muligheder</u></a>)<br>F.eks: creditcard ELLER viabill ELLER dankort&sbquo;danske-dk<br>');
	  define('MODULE_ADMIN_LABEL_PREPARING', 'Sæt forberedende ordre status');
	define('MODULE_ADMIN_TEXT_PREPARING', 'Sæt status for forberedende ordrer oprettet med denne betalingsmetode til denne værdi.<br>');
	  define('MODULE_ADMIN_LABEL_PENDING', 'Sæt modtaget ordre status');
	define('MODULE_ADMIN_TEXT_PENDING', 'Sæt status for modtaget ordrer oprettet med denne betalingsmetode til denne værdi.<br>');
	  define('MODULE_ADMIN_LABEL_REJECTED', 'Sæt afvist ordre status');
	define('MODULE_ADMIN_TEXT_REJECTED', 'Sæt status for afviste ordrer oprettet med denne betalingsmetode til denne værdi.<br>');
	define('MODULE_ADMIN_LABEL_SUBSCRIPTION', 'Abonnement');
	define('MODULE_ADMIN_TEXT_SUBSCRIPTION', 'Sæt abonnement betaling som standard( Normal er enkelt betaling)');
	define('MODULE_ADMIN_LABEL_AUTOFEE', 'Betalingsgebyr');
	define('MODULE_ADMIN_TEXT_AUTOFEE', 'Skal kunde betale indløsergebyret for transaktioner?<br>Indstil gebyrer i <a href=\"https://manage.quickpay.net/\" target=\"_blank\"><u>Quickpay manager</u></a>');
	define('MODULE_ADMIN_LABEL_AUTOCAPTURE', 'Auto capture');
	define('MODULE_ADMIN_TEXT_AUTOCAPTURE', 'Anvend auto capture?');
	//end quickpay added
?>