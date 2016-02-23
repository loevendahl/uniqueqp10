<?php

/*

  $Id: orders.php,v 1.25 2003/06/20 00:28:44 hpdl Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2002 osCommerce



  Released under the GNU General Public License

*/



define('HEADING_TITLE', 'Orders');

define('HEADING_TITLE_SEARCH_CUSTOMER', 'Search for customer: ');

define('HEADING_TITLE_SEARCH_ORDER_ID', 'Search for order ID:');

define('HEADING_TITLE_SEARCH_ORDER_STATUS', 'Show orders with status:');



define('TABLE_HEADING_COMMENTS', 'Comments');

define('TABLE_HEADING_CUSTOMERS', 'Customers');

define('TABLE_HEADING_ORDER_TOTAL', 'Order Total');

define('TABLE_HEADING_DATE_PURCHASED', 'Date Purchased');

define('TABLE_HEADING_STATUS', 'Status');

define('TABLE_HEADING_ACTION', 'Action');

define('TABLE_HEADING_QUANTITY', 'Qty.');

define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');

define('TABLE_HEADING_PRODUCTS', 'Products');

define('TABLE_HEADING_TAX', 'Tax');

define('TABLE_HEADING_TOTAL', 'Total');

define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Price (ex)');

define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Price (inc)');

define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (ex)');

define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total (inc)');



define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Customer Notified');

define('TABLE_HEADING_DATE_ADDED', 'Date Added');



define('ENTRY_CUSTOMER', 'Customer:');

define('ENTRY_SOLD_TO', 'SOLD TO:');

define('ENTRY_DELIVERY_TO', 'Delivery To:');

define('ENTRY_SHIP_TO', 'SHIP TO:');

define('ENTRY_SHIPPING_ADDRESS', 'Shipping Address:');

define('ENTRY_BILLING_ADDRESS', 'Billing Address:');

define('ENTRY_PAYMENT_METHOD', 'Payment Method:');

define('ENTRY_CREDIT_CARD_TYPE', 'Credit Card Type:');

define('ENTRY_CREDIT_CARD_OWNER', 'Credit Card Owner:');

define('ENTRY_CREDIT_CARD_NUMBER', 'Credit Card Number:');

define('ENTRY_CREDIT_CARD_EXPIRES', 'Credit Card Expires:');

define('ENTRY_SUB_TOTAL', 'Sub-Total:');

define('ENTRY_TAX', 'Tax:');

define('ENTRY_SHIPPING', 'Shipping:');

define('ENTRY_TOTAL', 'Total:');

define('ENTRY_DATE_PURCHASED', 'Date Purchased:');

define('ENTRY_STATUS', 'Status:');

define('ENTRY_DATE_LAST_UPDATED', 'Date Last Updated:');

define('ENTRY_NOTIFY_CUSTOMER', 'Notify Customer:');

define('ENTRY_NOTIFY_COMMENTS', 'Append Comments:');

define('ENTRY_PRINTABLE', 'Print Invoice');



define('TEXT_INFO_HEADING_DELETE_ORDER', 'Delete Order');

define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this order?');

define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Restock product quantity');

define('TEXT_DATE_ORDER_CREATED', 'Date Created:');

define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Last Modified:');

define('TEXT_INFO_PAYMENT_METHOD', 'Payment Method:');



define('TEXT_ALL_ORDERS', 'All Orders');

define('TEXT_NO_ORDER_HISTORY', 'No Order History Available');



define('EMAIL_SEPARATOR', '------------------------------------------------------');

define('EMAIL_TEXT_SUBJECT', 'Order Update');

define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');

define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');

define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');

define('EMAIL_TEXT_STATUS_UPDATE', 'Your order has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n");

define('EMAIL_TEXT_COMMENTS_UPDATE', 'The comments for your order are' . "\n\n%s\n\n");



define('ERROR_ORDER_DOES_NOT_EXIST', 'Error: Order does not exist.');

define('SUCCESS_ORDER_UPDATED', 'Success: Order has been successfully updated.');

define('WARNING_ORDER_NOT_UPDATED', 'Warning: Nothing to change. The order was not updated.');

// QuickPay added start
define('ENTRY_QUICKPAY_TRANSACTION', 'QuickPay balance:');
define('ENTRY_QUICKPAY_CARDHASH', 'Transaction type:');
define('IMAGE_TRANSACTION_CAPTURE_INFO', 'Capture transaction');
define('IMAGE_TRANSACTION_REVERSE_INFO', 'Cancel payment');
define('IMAGE_TRANSACTION_CREDIT_INFO', 'Credit payment');
define('IMAGE_TRANSACTION_TIME_INFO_GREEN', 'Capture possible wihtin PBS-guaranteed period');
define('IMAGE_TRANSACTION_TIME_INFO_YELLOW', 'Last day of PBS-guaranteed capture');
define('IMAGE_TRANSACTION_TIME_INFO_RED', 'Last day of PBS-guaranteed capture passedd');
define('INFO_QUICKPAY_CAPTURED', 'Payment is captured');
define('INFO_QUICKPAY_CREDITED', 'Amount is credited');
define('INFO_QUICKPAY_REVERSED', 'Payment is cancelled');
define('ENTRY_QUICKPAY_TRANSACTION_ID', 'Transaction-id:');
define('CONFIRM_REVERSE', 'Do you want to cancel this payment?');
define('CONFIRM_CAPTURE', 'Warning: Transaction amount is not identical to order amount. Do you want to capture the payment?');
define('CONFIRM_CREDIT', 'Do you want to credit the customer this amout?');
define('PENDING_STATUS', 'Awaiting aquirer approval.');
// QuickPay added end

// ### BEGIN ORDER MAKER ###

define('TABLE_HEADING_EDIT_ORDERS', 'To modify the order');

define('TEXT_IMAGE_CREATE','Create Order');

define('TEXT_INFO_CUSTOMER_SERVICE_ID','Entered by:');

// ### END ORDER MAKER ###

define('ORDER_ID', 'Ordernumber:');

define('TABLE_HEADING_ORDER_ID', 'Ordernum.');

//BOF osc_Giftwrap

define('TABLE_HEADING_GIFTWRAP', 'Gift Wrap: ');

define('TEXT_GIFTWRAP_TRUE', 'Yes');

define('TEXT_GIFTWRAP_FALSE', 'No Giftwrap');



define('TABLE_HEADING_GIFTCARD', 'Gift Card: ');

define('TEXT_GIFTCARD_TRUE', 'Yes');

define('TEXT_GIFTCARD_FALSE', 'No Gift Card');



define('TABLE_HEADING_GIFTMESSAGE', 'Gift Message: ');

define('TEXT_GIFTMESSAGE_FALSE', 'No Gift Card Message');

//EOF osc_Giftwrap

?>

