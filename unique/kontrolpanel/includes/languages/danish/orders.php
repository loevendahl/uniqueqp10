<?php

/*

  $Id: orders.php,v 1.25 2003/06/20 00:28:44 hpdl Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2002 osCommerce



  Released under the GNU General Public License

*/



define('HEADING_TITLE', 'Ordre');

define('HEADING_TITLE_SEARCH_CUSTOMER', 'Søg efter kunde: ');

define('HEADING_TITLE_SEARCH_ORDER_ID', 'Søg efter ordre ID:');

define('HEADING_TITLE_SEARCH_ORDER_STATUS', 'Vis ordre med status:');



define('TABLE_HEADING_COMMENTS', 'Kommentar');

define('TABLE_HEADING_CUSTOMERS', 'Kunde');

define('TABLE_HEADING_ORDER_TOTAL', 'Total');

define('TABLE_HEADING_DATE_PURCHASED', 'Bestillingsdato');

define('TABLE_HEADING_STATUS', 'Status');

define('TABLE_HEADING_ACTION', '');

define('TABLE_HEADING_QUANTITY', 'Antal.');

define('TABLE_HEADING_PRODUCTS_MODEL', 'Varenummer');

define('TABLE_HEADING_PRODUCTS', 'Produkter');

define('TABLE_HEADING_TAX', 'Moms');

define('TABLE_HEADING_TOTAL', 'Total');

define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Pris (ekskl.)');

define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Price (inkl.)');

define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (ekskl.)');

define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total (inkl.)');



define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Kunden underrettet');

define('TABLE_HEADING_DATE_ADDED', 'Tilføjet');



define('ENTRY_CUSTOMER', 'Kunde:');

define('ENTRY_SOLD_TO', 'Solgt til:');

define('ENTRY_DELIVERY_TO', 'Leveres til:');

define('ENTRY_SHIP_TO', 'Sendes til:');

define('ENTRY_SHIPPING_ADDRESS', 'Leveringsadresse:');

define('ENTRY_BILLING_ADDRESS', 'Faktureringsadresse:');

define('ENTRY_PAYMENT_METHOD', 'Betalingsmåde:');

define('ENTRY_CREDIT_CARD_TYPE', 'Korttype:');

define('ENTRY_CREDIT_CARD_OWNER', 'Kortejer:');

define('ENTRY_CREDIT_CARD_NUMBER', 'Kortnummer:');

define('ENTRY_CREDIT_CARD_EXPIRES', 'Udløbsdato:');

define('ENTRY_SUB_TOTAL', 'Sub-total:');

define('ENTRY_TAX', 'Moms:');

define('ENTRY_SHIPPING', 'Fragt:');

define('ENTRY_TOTAL', 'Total:');

define('ENTRY_DATE_PURCHASED', 'Bestillingsdato:');

define('ENTRY_STATUS', 'Status:');

define('ENTRY_DATE_LAST_UPDATED', 'Sidst opdateret:');

define('ENTRY_NOTIFY_CUSTOMER', 'Underret kunde:');

define('ENTRY_NOTIFY_COMMENTS', 'Tilføj kommentar(er) til underretning:');

define('ENTRY_PRINTABLE', 'Udskriv faktura');



define('TEXT_INFO_HEADING_DELETE_ORDER', 'Slet ordre');

define('TEXT_INFO_DELETE_INTRO', 'Er du sikker på, at du ønsker at slette denne ordre?');

define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Tiløj varene til lagerbeholdning igen');

define('TEXT_DATE_ORDER_CREATED', 'Oprettet:');

define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Sidst redigeret:');

define('TEXT_INFO_PAYMENT_METHOD', 'Betalingsmåde:');



define('TEXT_ALL_ORDERS', 'Alle ordrer');

define('TEXT_NO_ORDER_HISTORY', 'Ingen tilgængelig ordrehistorik');



define('EMAIL_SEPARATOR', '--------------------------------------------------------------------');

define('EMAIL_TEXT_SUBJECT', 'Din bestilling hos ' . STORE_NAME);

define('EMAIL_TEXT_ORDER_NUMBER', 'Ordrenummer:');

define('EMAIL_TEXT_INVOICE_URL', 'Detaljeret faktura:');

define('EMAIL_TEXT_DATE_ORDERED', 'Bestillingsdato:');

define('EMAIL_TEXT_STATUS_UPDATE', 'Status for din ordre er ændret til:' . "\n\n" . '%s' . "\n\n" . 'Hvis du har spørgsmål, er du velkommen til at kontakte os ved at besvare denne e-mail.' . "\n");

define('EMAIL_TEXT_COMMENTS_UPDATE', 'Der er følgende kommentar(er) til din ordre' . "\n\n%s\n\n");



define('ERROR_ORDER_DOES_NOT_EXIST', 'FEJL: Ordren findes ikke!');

define('SUCCESS_ORDER_UPDATED', 'Gennemført: Ordren er blevet opdateret.');

define('WARNING_ORDER_NOT_UPDATED', 'ADVARSEL: Der er ingen ændringer, ordren er IKKE blevet opdateret.');

// QuickPay added start
define('ENTRY_QUICKPAY_TRANSACTION', 'QuickPay transaktion:');
define('ENTRY_QUICKPAY_CARDHASH', 'Type:');
define('IMAGE_TRANSACTION_CAPTURE_INFO', 'Gennemfør betaling');
define('IMAGE_TRANSACTION_REVERSE_INFO', 'Annulér betaling');
define('IMAGE_TRANSACTION_CREDIT_INFO', 'Krediter betaling');
define('IMAGE_TRANSACTION_TIME_INFO_GREEN', 'Kan stadig hæves inden for PBS-garanteret periode');
define('IMAGE_TRANSACTION_TIME_INFO_YELLOW', 'Sidste dag for PBS-garanteret hævning');
define('IMAGE_TRANSACTION_TIME_INFO_RED', 'Sidste dag for PBS-garanteret hævning er overskredet');
define('INFO_QUICKPAY_CAPTURED', 'Betalingen er gennemført');
define('INFO_QUICKPAY_CREDITED', 'Beløbet er krediteret');
define('INFO_QUICKPAY_REVERSED', 'Betalingen er annulleret');
define('ENTRY_QUICKPAY_TRANSACTION_ID', 'Transaktions-id:');
define('CONFIRM_REVERSE', 'Vil du annullere denne betaling?');
define('CONFIRM_CAPTURE', 'Advarsel: Transaktionsbeløb er ikke identisk med ordrens total. Vil du gennemføre betalingen?');
define('CONFIRM_CREDIT', 'Vil du kreditere kunden dette beløb?');
define('PENDING_STATUS', 'Afventer indløser godkendelse.');
// QuickPay added end### BEGIN ORDER MAKER ###

define('TABLE_HEADING_EDIT_ORDERS', 'For at redigere ordren');

define('TEXT_IMAGE_CREATE','Opret ordre');

define('TEXT_INFO_CUSTOMER_SERVICE_ID','Oprettet af:');

// ### END ORDER MAKER ###

define('ORDER_ID', 'Ordrenummer:');

define('TABLE_HEADING_ORDER_ID', 'Ordrenr.');

//BOF osc_Giftwrap

define('TABLE_HEADING_GIFTWRAP', 'Indpakning: ');

define('TEXT_GIFTWRAP_TRUE', 'Ja');

define('TEXT_GIFTWRAP_FALSE', 'Nej');



define('TABLE_HEADING_GIFTCARD', 'Til og fra kort: ');

define('TEXT_GIFTCARD_TRUE', 'Ja');

define('TEXT_GIFTCARD_FALSE', 'Nej');



define('TABLE_HEADING_GIFTMESSAGE', 'Tekst på til og fra kort: ');

define('TEXT_GIFTMESSAGE_FALSE', 'Ingen');

//EOF osc_Giftwrap

?>