<?php
/*
  $Id: checkout_confirmation.php,v 1.24 2003/02/06 17:38:16 thomasamoulton Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Bestilling');
define('NAVBAR_TITLE_2', 'Godkend ordre');

define('HEADING_TITLE', 'Godkend ordre');

define('HEADING_DELIVERY_ADDRESS', 'Leveringsadresse');
define('HEADING_SHIPPING_METHOD', 'Forsendelsesmåde');
define('HEADING_PRODUCTS', 'Produkter');
define('HEADING_PRODUCTS_QTY', 'Antal');
define('HEADING_PRODUCTS_NAME', 'Navn');
define('HEADING_PRODUCTS_PRICE', 'I alt');

define('HEADING_TAX', 'Moms');
define('HEADING_TOTAL', 'Total');
define('HEADING_BILLING_INFORMATION', 'Betalingsmetode:');
define('HEADING_BILLING_ADDRESS', 'Faktureringsadresse:');
define('HEADING_PAYMENT_METHOD', 'Betalingsmåde:');
define('HEADING_PAYMENT_INFORMATION', 'Betalingsinformation:');
define('HEADING_ORDER_COMMENTS', 'Kommentarer til din ordre:');

define('TEXT_EDIT', 'Ret');
// QuickPay added start
define('HEADING_RETURN_POLICY', 'Handelsbetingelser');
define('TEXT_VIEW', 'Klik her');
define('TEXT_RETURN_POLICY', 'Denne ordre er omfattet af Lov om forbrugeraftaler ("Dørsalgs-loven"), hvilket betyder, at du har 14 dages returret på alle varer.<br><br>Hvis du fortryder dit køb hos ' . STORE_NAME . ' kan du altid sende dine varer retur.<br><br>Ved returnering refunderes alle dine penge inkl. fragt, dog skal du slev betale returfragt.');
define('ACCEPT_CONDITIONS', '<b>Jeg har læst og accepterer <a href="popup_terms.php" target="_blank">betingelserne: </a></b>');
define('CONDITION_AGREEMENT_ERROR', 'For at fuldføre din bestilling, skal du først godkende salgs- og leveringsbetingelserne. Det gør du ved at markere feltet nederst på siden.\n\nKan du ikke acceptere betingelserne i deres helhed, kan handlen desværre ikke gennemføres.');
// QuickPay added end

define('HEADING_ORDER_REFERENCE', 'Deres reference:');

//BOF osc_Giftwrap
define('HEADING_GIFTWRAP_METHOD', 'Indpakning');
define('HEADING_GIFTWRAP_CARD', 'Til og fra kort');
define('TEXT_GIFTWRAP_CARD', 'Tilvalgt');
define('HEADING_GIFTWRAP_MESSAGE', 'Besked på til og fra kort');
define('TEXT_GIFTWRAP_NO_MESSAGE', '<b>OBS:</b> Der er ikke indtastet en besked');
//EOF osc_Giftwrap
?>
