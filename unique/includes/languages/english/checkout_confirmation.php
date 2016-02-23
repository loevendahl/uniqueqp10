<?php
/*
  $Id: checkout_confirmation.php,v 1.24 2003/02/06 17:38:16 thomasamoulton Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Confirmation');

define('HEADING_TITLE', 'Order Confirmation');

define('HEADING_DELIVERY_ADDRESS', 'Delivery Address');
define('HEADING_SHIPPING_METHOD', 'Shipping Method');
define('HEADING_PRODUCTS', 'Products');
define('HEADING_PRODUCTS_QTY', 'Quantity');
define('HEADING_PRODUCTS_NAME', 'Name');
define('HEADING_PRODUCTS_PRICE', 'Total');
define('HEADING_TAX', 'Tax');
define('HEADING_TOTAL', 'Total');
define('HEADING_BILLING_INFORMATION', 'Billing Information');
define('HEADING_BILLING_ADDRESS', 'Billing Address');
define('HEADING_PAYMENT_METHOD', 'Payment Method');
define('HEADING_PAYMENT_INFORMATION', 'Payment Information');
define('HEADING_ORDER_COMMENTS', 'Comments About Your Order');

define('TEXT_EDIT', 'Edit');
// QuickPay added start
define('HEADING_RETURN_POLICY', 'Conditions of Use');
define('TEXT_VIEW', 'Read now');
define('TEXT_RETURN_POLICY', 'This order is made under the authority of the danish law of customers agreement ("Dørsalgs-loven"), which means you have the option to return all products to ' . STORE_NAME . ' within 14 days.<br><br>If you return your order, we return all the money your paid, except the freight to and from ' . STORE_NAME . '.<br><br>When shopping at ' . STORE_NAME . ', using our Internetshop, you must accept that a final buying agreement will not be made before an employee from the company have processed your order. ' . STORE_NAME . ' reserves its right to cancel an order, due to soldout products, wrong pricing, products not available, risk of credit card fraud or in other cases.');
define('ACCEPT_CONDITIONS', 'I have read the <a href="popup_terms.php"><u>conditions of use</u></a> and I agree to them:');
define('CONDITION_AGREEMENT_ERROR', "Please read our conditions of use and agree to them. If you do not do so, your order can not be processed.");
// QuickPay added end
define('TABLE_HEADING_REFERENCE', 'Deres reference:');

//BOF osc_Giftwrap
define('HEADING_GIFTWRAP_METHOD', 'GiftWrap Method');
define('HEADING_GIFTWRAP_CARD', 'Include GiftCard');
define('TEXT_GIFTWRAP_CARD', 'GiftCard Included');
define('HEADING_GIFTWRAP_MESSAGE', 'GiftCard Message');
define('TEXT_GIFTWRAP_NO_MESSAGE', 'No Message Entered');
//EOF osc_Giftwrap
?>
