<?php
/*
  $Id: invoice.php,v 6.1 2005/06/05 18:17:59 PopTheTop Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

//// START Edit the following defines to your liking ////

// Footing
define('INVOICE_TEXT_THANK_YOU', 'Tak fordi du handlede hos'); // Printed at the bottom of your invoices
define('STORE_URL_ADDRESS', HTTP_SERVER); // Your web address Printed at the bottom of your invoices

// Image Info
define('INVOICE_IMAGE', HTTP_SERVER . '/mediafiles/images/invoice_logo.gif'); //Change this to match your logo image and foler it is in
define('INVOICE_IMAGE_WIDTH', '770'); // Change this to your logo's width
define('INVOICE_IMAGE_HEIGHT', '105'); // Change this to your logo's height

// Product Table Info Headings
define('TABLE_HEADING_PRODUCTS_MODEL', 'Varenummer'); // Change this to "Model #" or leave it as "SKU #"

//// END Editing the above defines to your liking ////

// Misc Invoice Info
define('INVOICE_TEXT_NUMBER_SIGN', 'nummer');
define('INVOICE_TEXT_DASH', '-');
define('INVOICE_TEXT_COLON', ': ');

define('INVOICE_TEXT_INVOICE', 'Faktura');
define('INVOICE_TEXT_CONFIRMATION', 'Bekræftelse');
define('INVOICE_TEXT_ORDER', 'Ordre');
define('INVOICE_TEXT_DATE_OF_ORDER', 'Bestillingsdato');
define('INVOICE_TEXT_VAT', 'CVR-nummer');
define('INVOICE_PRINT_DATE', 'Udskrevet den');
define('YOUR_REFERENCE', 'Deres reference:');
define('ENTRY_PAYMENT_CC_NUMBER', 'Betalingskort:');

// Customer Info
define('ENTRY_SOLD_TO', 'Faktureringsadresse:');
define('ENTRY_SHIP_TO', 'Leveringsadresse:');
define('ENTRY_PAYMENT_METHOD', 'Betalingsmetode:');

// Product Table Info Headings
define('TABLE_HEADING_PRODUCTS', 'Produkter');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Pris (excl.)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Pris)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (excl.)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total');
define('TABLE_HEADING_TAX', 'Moms');
define('TABLE_HEADING_UNIT_PRICE', 'Enhedspris');
define('TABLE_HEADING_TOTAL', 'Total');

// Order Total Details Info
define('ENTRY_SUB_TOTAL', 'Varekøb i alt:');
define('ENTRY_SHIPPING', 'Forsendelse:');
define('ENTRY_TAX', 'Moms:');
define('ENTRY_TOTAL', 'I alt:');

//Order Comments
define('TABLE_HEADING_COMMENTS', 'Bemærkning(er):');
define('TABLE_HEADING_DATE_ADDED', 'Tilføjet');
define('TABLE_HEADING_COMMENT_LEFT', 'Der er bemærkninger');
define('INVOICE_TEXT_NO_COMMENT', 'Der er ingen bemærkninger til denne ordre');
define('INVOICE_IMAGE_ALT_TEXT', 'Klik for at besøge ' . STORE_NAME . 's hjemmeside'); // Change this to your logo's ALT text or leave blank

//Bank transfer
define('TEXT_BANK_TRANSFER', 'Hvis du har valgt at betale via bankoverførsel, bedes ovenstående beløb overført til vores konto i');
define('TEXT_BANK_REGISTRATION', 'registreringsnummer:');
define('TEXT_BANK_ACCOUNT', 'kontonummer:');

// Download
define('HEADING_DOWNLOAD', 'Download information');
define('CLICK_HERE_TO_DOWNLOAD', 'Klik her for at downlode ');
define('TABLE_HEADING_DOWNLOAD_DATE', 'Sidste frist for download: ');
define('TABLE_HEADING_DOWNLOAD_COUNT', ' downloads tilbage');

//Quickpay changed
define('DENUNCIATION', 'Ordren betales med ViaBill. Det skyldige beløb kan alene betales med frigørende virkning til ViaBill, som fremsender særskilt opkrævning. Betaling kan ikke ske ved modregning af krav, der udspringer af andre retsforhold');
//Quickpay changed end
?>