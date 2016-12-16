<?php
/*
  quickpay.php

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2008 Jakob H�y Biegel

  Released under the GNU General Public License
*/
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_TITLE', 'Quickpay: Online betaling');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_PUBLIC_TITLE', 'Quickpay: Online betaling');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_DESCRIPTION', 'Betalingen overf�res online ');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_EMAIL_FOOTER', 'Betalingen er nu reserveret hos PBS. Din online betaling har f�et transaktions-id: %s.' . "\n" . 'N�r ordren ekspederes bliver bel�bet overf�rt til ' . STORE_NAME); 

  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_SELECT_CARD', '* V�lg hvilken m�de du vil benytte til online betaling\n');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_WAIT', 'Vent venligst et �jeblik. Betalingsside forberedes...');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_ERROR', 'Online betaling kunne ikke gennemf�res');
define('MODULE_PAYMENT_QUICKPAY_ADVANCED_FEEINFO', '(evt. gebyr tilf�jes ved betaling)');
define('MODULE_PAYMENT_QUICKPAY_ADVANCED_FEELOCKINFO', ' evt. gebyr');
// Transaction errors  
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_MERCHANT_UNKNOWN', 'Ukendt Merchant Nr');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CARDNO_NOT_VALID', 'Ugyldigt kortnummer');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CVC_NOT_VALID', 'Ugyldige kontrolcifre');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_ORDERID', 'OrderID ugyldigt eller mangler');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_TRANSACTION_DECLINED', 'Transaktionen blev afbrudt');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_WRONG_NUMBER_FORMAT', 'Bel�bet blev angivet i et forkert format');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_ILLEGAL_TRANSACTION', 'Ugyldig transaktion');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_TRANSACTION_EXPIRED', 'Transaktionen er udl�bet');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_NO_ANSWER', 'Intet svar');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_SYSTEM_FAILURE', 'Systemfejl');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CARD_EXPIRED', 'Kortet er udl�bet');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_COMMUNICATION_FAILURE', 'Kommunikationsfejl');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_INTERNAL_FAILURE', 'Intern fejl');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CARD_NOT_REGISTERED', 'Kunden ikke oprettet i systemet');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_RETRY_FAILURE', 'Kan ikke betale samme transaktion flere gange');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_UNKNOWN', 'Fejl i indtastede oplysninger');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CANCELLED', 'Transaktionen blev afbrudt') ;
  
// Name of credit cards options (3D Secure)
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_JCB_3D_TEXT', 'JCB 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MAESTRO_3D_TEXT', 'Maestro 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MAESTRO_DK_3D_TEXT', 'Maestro 3D-Secure (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_3D_TEXT', 'MasterCard 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DK_3D_TEXT', 'Mastercard 3D-Secure (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_3D_TEXT', 'Visa 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DK_3D_TEXT', 'Visa 3D-Secure (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_3D_TEXT', 'Visa Electron 3D-Secure');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_DK_3D_TEXT', 'Visa Electron 3D-Secure (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DEBET_3D_TEXT', 'Visa debet 3D-secure ');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DEBET_DK_3D_TEXT', 'Visa debet 3D-secure (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_CREDITCARD_3D_TEXT', 'Kreditkort 3D-secure');

// Name of credit cards options 
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_AMERICAN_EXPRESS_TEXT', 'American Express');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_AMERICAN_EXPRESS_DK_TEXT', 'American Express (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DANKORT_TEXT', 'Dankort');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DANSKE_DK_TEXT', 'Danske Netbank');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DINERS_TEXT', 'Diners Club');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_DINERS_DK_TEXT', 'Diners Club (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_EDANKORT_TEXT', 'eDankort');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_JCB_TEXT', 'JCB');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_TEXT', 'Mastercard');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DK_TEXT', 'Mastercard (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DEBET_TEXT', 'Mastercard debet');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DEBET_DK_TEXT', 'Mastercard debet(Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_NORDEA_DK_TEXT', 'Nordea Netbank');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_TEXT', 'Visa');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DK_TEXT', 'Visa (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_TEXT', 'Visa Electron');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_DK_TEXT', 'Visa Electron (Dansk)');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_FBG1886_TEXT', 'Forbrugsforeningen af 1886');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_CREDITCARD_TEXT', 'Kreditkort');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_PAYPAL_TEXT', 'Paypal');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_SOFORT_TEXT', 'Sofort');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_IBILL_TEXT', 'ViaBill betaling');
  define('MODULE_PAYMENT_QUICKPAY_ADVANCED_IBILL_DESCRIPTION', 'K�b nu - betal, n�r du vil');
 // define('MODULE_PAYMENT_QUICKPAY_ADVANCED_PAII_TEXT', 'Paii mobil betaling');
    define('MODULE_PAYMENT_QUICKPAY_ADVANCED_MOBILEPAY_TEXT', 'Mobilepay betaling');
	
	
	//Install
    define('MODULE_ADMIN_LABEL_ENABLE', 'Aktiv�r Quickpay online betaling');
	define('MODULE_ADMIN_TEXT_ENABLE', 'Vil du anvende denne betalingsmetode?<br>');
	 define('MODULE_ADMIN_LABEL_SORT', 'Visning r�kkef�lge');
	define('MODULE_ADMIN_TEXT_SORT', 'Angiv r�kkef�lge for visning. Laveste vises f�rst<br>');
	define('MODULE_ADMIN_LABEL_ZONE', 'Betaling zone');
	define('MODULE_ADMIN_TEXT_ZONE', 'Hvis en zone er valgt, anvend kun denne betalingsmetode i den valgte zone.<br>');
	define('MODULE_ADMIN_LABEL_MERCHANT', 'Quickpay Merchant ID');
	define('MODULE_ADMIN_TEXT_MERCHANT', 'Som angivet i <a href="https://manage.quickpay.net" target="_blank">Manager</a> -> Settings -> integration -> Merchant ID<br>');
	define('MODULE_ADMIN_LABEL_USERAPIKEY', 'API bruger key');
	define('MODULE_ADMIN_TEXT_USERAPIKEY', 'Som angivet i <a href="https://manage.quickpay.net" target="_blank">Manager</a> -> Settings -> integration -> API user key<br>');
	define('MODULE_ADMIN_LABEL_USERAGREEMENT', 'API aftale ID');
	define('MODULE_ADMIN_TEXT_USERAGREEMENT', 'Som angivet i <a href="https://manage.quickpay.net" target="_blank">Manager</a> -> Settings -> integration -> API User Agreement ID<br>');
	define('MODULE_ADMIN_LABEL_GROUP','Gruppe betalingsmuligheder ');
	define('MODULE_ADMIN_TEXT_GROUP','Kommasepareret Quickpay betalingsmuligheder inkluderet i gruppen. max. 255 tegn (<a href=\'http://tech.quickpay.net/appendixes/payment-methods\' target=\'_blank\'><u>Vis tilg�ngelige muligheder</u></a>)<br>F.eks: creditcard ELLER viabill ELLER dankort&sbquo;danske-dk<br>');
	  define('MODULE_ADMIN_LABEL_PREPARING', 'S�t forberedende ordre status');
	define('MODULE_ADMIN_TEXT_PREPARING', 'S�t status for forberedende ordrer oprettet med denne betalingsmetode til denne v�rdi.<br>');
	  define('MODULE_ADMIN_LABEL_PENDING', 'S�t modtaget ordre status');
	define('MODULE_ADMIN_TEXT_PENDING', 'S�t status for modtaget ordrer oprettet med denne betalingsmetode til denne v�rdi.<br>');
	  define('MODULE_ADMIN_LABEL_REJECTED', 'S�t afvist ordre status');
	define('MODULE_ADMIN_TEXT_REJECTED', 'S�t status for afviste ordrer oprettet med denne betalingsmetode til denne v�rdi.<br>');
	define('MODULE_ADMIN_LABEL_SUBSCRIPTION', 'Abonnement');
	define('MODULE_ADMIN_TEXT_SUBSCRIPTION', 'S�t abonnement betaling som standard( Normal er enkelt betaling)');
	define('MODULE_ADMIN_LABEL_AUTOFEE', 'Betalingsgebyr');
	define('MODULE_ADMIN_TEXT_AUTOFEE', 'Skal kunde betale indl�sergebyret for transaktioner?<br>Indstil gebyrer i <a href=\"https://manage.quickpay.net/\" target=\"_blank\"><u>Quickpay manager</u></a>');
	define('MODULE_ADMIN_LABEL_AUTOCAPTURE', 'Auto capture');
	define('MODULE_ADMIN_TEXT_AUTOCAPTURE', 'Anvend auto capture?');
	

?>