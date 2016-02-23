<?php
/*
  $Id: order.php,v 1.33 2003/06/09 22:25:35 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  class order {
    var $info, $totals, $products, $customer, $delivery, $content_type;

    function order($order_id = '') {
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();

      if (tep_not_null($order_id)) {
        $this->query($order_id);
      } else {
        link_post_variable('cc_type'); 
        link_post_variable('cc_owner'); 
        link_post_variable('cc_number'); 
        link_post_variable('cc_expires'); 
        link_post_variable('comments'); 
        $this->cart();
      }
    }

    function query($order_id) {
      global $languages_id;

      $order_id = tep_db_prepare_input($order_id);
// quickpay changed start
      $order_query = tep_db_query("select customers_id, customers_name, customers_company, customers_vat_number, customers_ean_number, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_vat_number, delivery_ean_number, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_vat_number, billing_ean_number, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, giftMessage, giftCard, currency, currency_value, date_purchased, orders_status, last_modified, cc_transactionid from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
// quickpay changed end
      $order = tep_db_fetch_array($order_query);

      $totals_query = tep_db_query("select title, text from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' order by sort_order");
      while ($totals = tep_db_fetch_array($totals_query)) {
        $this->totals[] = array('title' => $totals['title'],
                                'text' => $totals['text']);
      }

      $order_total_query = tep_db_query("select text from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_total'");
      $order_total = tep_db_fetch_array($order_total_query);

      $shipping_method_query = tep_db_query("select title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_shipping'");
      $shipping_method = tep_db_fetch_array($shipping_method_query);

      //BOF osc_Giftwrap
      $giftwrap_method_query = tep_db_query("select title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_giftwrap'");
      $giftwrap_method = tep_db_fetch_array($giftwrap_method_query);
      //EOF osc_Giftwrap

      $order_status_query = tep_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . $order['orders_status'] . "' and language_id = '" . (int)$languages_id . "'");
      $order_status = tep_db_fetch_array($order_status_query);

      $this->info = array('currency' => $order['currency'],
                          'currency_value' => $order['currency_value'],
                          'payment_method' => $order['payment_method'],
                          'cc_type' => $order['cc_type'],
                          'cc_owner' => $order['cc_owner'],
                          'cc_number' => $order['cc_number'],
                          'cc_expires' => $order['cc_expires'],
                          'date_purchased' => $order['date_purchased'],
                          'orders_status' => $order_status['orders_status_name'],
                          'last_modified' => $order['last_modified'],
                          'total' => strip_tags($order_total['text']),
                           //BOF osc_Giftwrap
                          'giftMethod' => ((substr($giftwrap_method['title'], -1) == ':') ? substr(strip_tags($giftwrap_method['title']), 0, -1) : strip_tags($giftwrap_method['title'])),
                          'giftCard' => $order['giftCard'],
                          'giftMessage' => $order['giftMessage'],
                          //EOF osc_Giftwrap
// quickpay added start
                          'cc_transactionid' => $order['cc_transactionid'],
// quickpay added end
                          'shipping_method' => ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title'])));

      $this->customer = array('id' => $order['customers_id'],
                              'name' => $order['customers_name'],
                              'company' => $order['customers_company'],
                              'vat_number' => $order['customers_vat_number'],
                              'ean_number' => $order['customers_ean_number'],
                              'street_address' => $order['customers_street_address'],
                              'suburb' => $order['customers_suburb'],
                              'city' => $order['customers_city'],
                              'postcode' => $order['customers_postcode'],
                              'state' => $order['customers_state'],
                              'country' => array('title' => $order['customers_country']),
                              'format_id' => $order['customers_address_format_id'],
                              'telephone' => $order['customers_telephone'],
                              'email_address' => $order['customers_email_address']);

      $this->delivery = array('name' => $order['delivery_name'],
                              'company' => $order['delivery_company'],
                              'vat_number' => $order['delivery_vat_number'],
                              'ean_number' => $order['delivery_ean_number'],
                              'street_address' => $order['delivery_street_address'],
                              'suburb' => $order['delivery_suburb'],
                              'city' => $order['delivery_city'],
                              'postcode' => $order['delivery_postcode'],
                              'state' => $order['delivery_state'],
                              'country' => array('title' => $order['delivery_country']),
                              'format_id' => $order['delivery_address_format_id']);

      if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
        $this->delivery = false;
      }

      $this->billing = array('name' => $order['billing_name'],
                             'company' => $order['billing_company'],
                             'vat_number' => $order['billing_vat_number'],
                             'ean_number' => $order['billing_ean_number'],
                             'street_address' => $order['billing_street_address'],
                             'suburb' => $order['billing_suburb'],
                             'city' => $order['billing_city'],
                             'postcode' => $order['billing_postcode'],
                             'state' => $order['billing_state'],
                             'country' => array('title' => $order['billing_country']),
                             'format_id' => $order['billing_address_format_id']);

      $index = 0;
      $orders_products_query = tep_db_query("select orders_products_id, products_id, products_name, products_model, products_price, products_tax, products_quantity, final_price from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
      while ($orders_products = tep_db_fetch_array($orders_products_query)) {
        $this->products[$index] = array('qty' => $orders_products['products_quantity'],
	                                'id' => $orders_products['products_id'],
                                        'name' => $orders_products['products_name'],
                                        'model' => $orders_products['products_model'],
                                        'tax' => $orders_products['products_tax'],
                                        'price' => $orders_products['products_price'],
                                        'final_price' => $orders_products['final_price']);

        $subindex = 0;
        $attributes_query = tep_db_query("select products_options, products_options_values, options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$order_id . "' and orders_products_id = '" . (int)$orders_products['orders_products_id'] . "'");
        if (tep_db_num_rows($attributes_query)) {
          while ($attributes = tep_db_fetch_array($attributes_query)) {
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
                                                                     'value' => $attributes['products_options_values'],
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }

        $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

        $index++;
      }
    }

    function cart() {
      // BOF osc_Giftwrap added , $giftwrap,$giftwrap_info, $giftwrap_message,$giftwrap_card
      /* global $HTTP_POST_VARS, $customer_id, $sendto, $billto, $cart, $languages_id, $currency, $currencies, $shipping, $payment, $comments, $reference; */
      global $customer_id, $sendto, $billto, $cart, $languages_id, $currency, $currencies, $shipping,$payment, $comments, $reference, $customer_default_address_id, $giftwrap_info, $giftwrap_message, $giftwrap_method, $giftwrap_card;
      // EOF osc_Giftwrap
	  
      $this->content_type = $cart->get_content_type();
      
// PWA BOF
if ($customer_id == 0) {
      global $pwa_array_customer, $pwa_array_address, $pwa_array_shipping;

      // customers address
      $country_query = tep_db_query("select c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, z.zone_name from " . TABLE_COUNTRIES . " c left join " . TABLE_ZONES . " z on z.zone_id = '" . intval($pwa_array_address['entry_zone_id']) . "' where countries_id = '" . intval($pwa_array_address['entry_country_id']) . "'");
      $country = tep_db_fetch_array($country_query);
      $address = array_merge($country,
                 array('customers_firstname' => $pwa_array_customer['customers_firstname'],
                       'customers_lastname'  => $pwa_array_customer['customers_lastname'],
                           'entry_firstname' => $pwa_array_customer['customers_firstname'],
                           'entry_lastname'  => $pwa_array_customer['customers_lastname'],
                       'customers_telephone' => $pwa_array_customer['customers_telephone'],
                   'customers_email_address' => $pwa_array_customer['customers_email_address'],
                             'entry_company' => (isset($pwa_array_address['entry_company'])? $pwa_array_address['entry_company']:''),
                          'entry_vat_number' => (isset($pwa_array_address['entry_vat_number'])? $pwa_array_address['entry_vat_number']:''),
                          'entry_ean_number' => (isset($pwa_array_address['entry_ean_number'])? $pwa_array_address['entry_ean_number']:''),
                      'entry_street_address' => $pwa_array_address['entry_street_address'],
                              'entry_suburb' => $pwa_array_address['entry_suburb'],
                            'entry_postcode' => $pwa_array_address['entry_postcode'],
                                'entry_city' => $pwa_array_address['entry_city'],
                             'entry_zone_id' => $pwa_array_address['entry_zone_id'],
                              'countries_id' => $pwa_array_address['entry_country_id'],
                          'entry_country_id' => $pwa_array_address['entry_country_id'],
                               'entry_state' => $pwa_array_address['entry_state']));

      $customer_address = $billing_address = $address;

      if (isset($pwa_array_shipping) && is_array($pwa_array_shipping) && count($pwa_array_shipping)) {
        // separately shipping address
        $country_query = tep_db_query("select c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, z.zone_name from " . TABLE_COUNTRIES . " c left join " . TABLE_ZONES . " z on z.zone_id = '" . intval($pwa_array_shipping['entry_zone_id']) . "' where countries_id = '" . intval($pwa_array_shipping['entry_country_id']) . "'");
        $country = tep_db_fetch_array($country_query);
        $shipping_address = array_merge($country,
                 array('customers_firstname' => $pwa_array_shipping['entry_firstname'],
                       'customers_lastname'  => $pwa_array_shipping['entry_lastname'],
                           'entry_firstname' => $pwa_array_shipping['entry_firstname'],
                           'entry_lastname'  => $pwa_array_shipping['entry_lastname'],
                       'customers_telephone' => $pwa_array_customer['customers_telephone'],
                   'customers_email_address' => $pwa_array_customer['customers_email_address'],
                             'entry_company' => (isset($pwa_array_shipping['entry_company'])? $pwa_array_shipping['entry_company']:''),
                          'entry_vat_number' => (isset($pwa_array_shipping['entry_vat_number'])? $pwa_array_shipping['entry_vat_number']:''),
                          'entry_ean_number' => (isset($pwa_array_shipping['entry_ean_number'])? $pwa_array_shipping['entry_ean_number']:''),
                      'entry_street_address' => $pwa_array_shipping['entry_street_address'],
                              'entry_suburb' => $pwa_array_shipping['entry_suburb'],
                            'entry_postcode' => $pwa_array_shipping['entry_postcode'],
                                'entry_city' => $pwa_array_shipping['entry_city'],
                             'entry_zone_id' => $pwa_array_shipping['entry_zone_id'],
                              'countries_id' => $pwa_array_shipping['entry_country_id'],
                          'entry_country_id' => $pwa_array_shipping['entry_country_id'],
                               'entry_state' => $pwa_array_shipping['entry_state']));

      } else {
        // non separately shipping address
        $shipping_address = $address;
      }
      $tax_address = array('entry_country_id' => $shipping_address['entry_country_id'], 'entry_zone_id' => $shipping_address['entry_zone_id']);

      // address label #0
      $this->pwa_label_customer =
                         array('firstname' => $customer_address['customers_firstname'],
                               'lastname'  => $customer_address['customers_lastname'],
                                 'company' => $customer_address['entry_company'],
                              'vat_number' => $customer_address['entry_vat_number'],
                              'ean_number' => $customer_address['entry_ean_number'],
                          'street_address' => $customer_address['entry_street_address'],
                                  'suburb' => $customer_address['entry_suburb'],
                                    'city' => $customer_address['entry_city'],
                                'postcode' => $customer_address['entry_postcode'],
                                   'state' => $customer_address['entry_state'],
                                 'zone_id' => $customer_address['entry_zone_id'],
                              'country_id' => $customer_address['entry_country_id']);
      // address label #1
      $this->pwa_label_shipping =
                         array('firstname' => $shipping_address['customers_firstname'],
                               'lastname'  => $shipping_address['customers_lastname'],
                                 'company' => $shipping_address['entry_company'],
                              'vat_number' => $shipping_address['entry_vat_number'],
                              'ean_number' => $shipping_address['entry_ean_number'],
                          'street_address' => $shipping_address['entry_street_address'],
                                  'suburb' => $shipping_address['entry_suburb'],
                                    'city' => $shipping_address['entry_city'],
                                'postcode' => $shipping_address['entry_postcode'],
                                   'state' => $shipping_address['entry_state'],
                                 'zone_id' => $shipping_address['entry_zone_id'],
                              'country_id' => $shipping_address['entry_country_id']);
} else {
// PWA EOF      

      $customer_address_query = tep_db_query("select c.customers_firstname, c.customers_lastname, c.customers_telephone, c.customers_email_address, ab.entry_company, ab.entry_vat_number, ab.entry_ean_number, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, co.countries_id, co.countries_name, co.countries_iso_code_2, co.countries_iso_code_3, co.address_format_id, ab.entry_state from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id) where c.customers_id = '" . (int)$customer_id . "' and ab.customers_id = '" . (int)$customer_id . "' and c.customers_default_address_id = ab.address_book_id");
      $customer_address = tep_db_fetch_array($customer_address_query);

      $shipping_address_query = tep_db_query("select ab.entry_firstname, ab.entry_lastname, ab.entry_company, ab.entry_vat_number, ab.entry_ean_number, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . (int)$customer_id . "' and ab.address_book_id = '" . (int)$sendto . "'");
      $shipping_address = tep_db_fetch_array($shipping_address_query);
      
      $billing_address_query = tep_db_query("select ab.entry_firstname, ab.entry_lastname, ab.entry_company, ab.entry_vat_number, ab.entry_ean_number, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . (int)$customer_id . "' and ab.address_book_id = '" . (int)$billto . "'");
      $billing_address = tep_db_fetch_array($billing_address_query);

      $tax_address_query = tep_db_query("select ab.entry_country_id, ab.entry_zone_id from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = '" . (int)$customer_id . "' and ab.address_book_id = '" . (int)(($this->content_type == 'virtual' || 'virtual_weight') ? $sendto : $billto) . "'"); // Edited for CCGV
      $tax_address = tep_db_fetch_array($tax_address_query);
      
// PWA BOF
}  
// PWA EOF

      $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
                          'currency' => $currency,
                          'currency_value' => $currencies->currencies[$currency]['value'],
                          'payment_method' => $payment,
                          'cc_type' => (isset($HTTP_POST_VARS['cc_type']) ? $HTTP_POST_VARS['cc_type'] : ''),
                          'cc_owner' => (isset($HTTP_POST_VARS['cc_owner']) ? $HTTP_POST_VARS['cc_owner'] : ''),
                          'cc_number' => (isset($HTTP_POST_VARS['cc_number_nh-dns']) ? $HTTP_POST_VARS['cc_number_nh-dns'] : ''),
                          'cc_expires' => (isset($HTTP_POST_VARS['cc_expires']) ? $HTTP_POST_VARS['cc_expires'] : ''),
                          'shipping_method' => $shipping['title'],
                          'shipping_cost' => $shipping['cost'],
                          'subtotal' => 0,
                          'tax' => 0,
                          'tax_groups' => array(),
                           // BOF osc_Giftwrap
                          'giftwrap_method' => $giftwrap_info['title'],
                          'giftwrap_cost' => $giftwrap_info['cost'],
                          'giftwrap_message' => $giftwrap_message,
                          'giftwrap_card' => $giftwrap_card,
                          // EOF osc_Giftwrap
// quickpay added start
                          'cc_transactionid' => (isset($GLOBALS['cc_transactionid']) ? $GLOBALS['cc_transactionid'] : ''),
// quickpay added end
                          'comments' => (tep_session_is_registered('comments') && !empty($comments) ? $comments : ''),
                          'reference' => (tep_session_is_registered('reference') && !empty($reference) ? $reference : ''));

      if (isset($GLOBALS[$payment]) && is_object($GLOBALS[$payment])) {
        if (isset($GLOBALS[$payment]->public_title)) {
          $this->info['payment_method'] = $GLOBALS[$payment]->public_title;
        } else {
          $this->info['payment_method'] = $GLOBALS[$payment]->title;
        }

        if ( isset($GLOBALS[$payment]->order_status) && is_numeric($GLOBALS[$payment]->order_status) && ($GLOBALS[$payment]->order_status > 0) ) {
          $this->info['order_status'] = $GLOBALS[$payment]->order_status;
        }
      }

      $this->customer = array('firstname' => $customer_address['customers_firstname'],
                              'lastname' => $customer_address['customers_lastname'],
                              'company' => $customer_address['entry_company'],
                              'vat_number' => $customer_address['entry_vat_number'],
                              'ean_number' => $customer_address['entry_ean_number'],
                              'street_address' => $customer_address['entry_street_address'],
                              'suburb' => $customer_address['entry_suburb'],
                              'city' => $customer_address['entry_city'],
                              'postcode' => $customer_address['entry_postcode'],
                              'state' => ((tep_not_null($customer_address['entry_state'])) ? $customer_address['entry_state'] : $customer_address['zone_name']),
                              'zone_id' => $customer_address['entry_zone_id'],
                              'country' => array('id' => $customer_address['countries_id'], 'title' => $customer_address['countries_name'], 'iso_code_2' => $customer_address['countries_iso_code_2'], 'iso_code_3' => $customer_address['countries_iso_code_3']),
                              'format_id' => $customer_address['address_format_id'],
                              'telephone' => $customer_address['customers_telephone'],
                              'email_address' => $customer_address['customers_email_address']);

      $this->delivery = array('firstname' => $shipping_address['entry_firstname'],
                              'lastname' => $shipping_address['entry_lastname'],
                              'company' => $shipping_address['entry_company'],
                              'vat_number' => $shipping_address['entry_vat_number'],
                              'ean_number' => $shipping_address['entry_ean_number'],
                              'street_address' => $shipping_address['entry_street_address'],
                              'suburb' => $shipping_address['entry_suburb'],
                              'city' => $shipping_address['entry_city'],
                              'postcode' => $shipping_address['entry_postcode'],
                              'state' => ((tep_not_null($shipping_address['entry_state'])) ? $shipping_address['entry_state'] : $shipping_address['zone_name']),
                              'zone_id' => $shipping_address['entry_zone_id'],
                              'country' => array('id' => $shipping_address['countries_id'], 'title' => $shipping_address['countries_name'], 'iso_code_2' => $shipping_address['countries_iso_code_2'], 'iso_code_3' => $shipping_address['countries_iso_code_3']),
                              'country_id' => $shipping_address['entry_country_id'],
                              'format_id' => $shipping_address['address_format_id']);

      $this->billing = array('firstname' => $billing_address['entry_firstname'],
                             'lastname' => $billing_address['entry_lastname'],
                             'company' => $billing_address['entry_company'],
                             'vat_number' => $billing_address['entry_vat_number'],
                             'ean_number' => $billing_address['entry_ean_number'],
                             'street_address' => $billing_address['entry_street_address'],
                             'suburb' => $billing_address['entry_suburb'],
                             'city' => $billing_address['entry_city'],
                             'postcode' => $billing_address['entry_postcode'],
                             'state' => ((tep_not_null($billing_address['entry_state'])) ? $billing_address['entry_state'] : $billing_address['zone_name']),
                             'zone_id' => $billing_address['entry_zone_id'],
                             'country' => array('id' => $billing_address['countries_id'], 'title' => $billing_address['countries_name'], 'iso_code_2' => $billing_address['countries_iso_code_2'], 'iso_code_3' => $billing_address['countries_iso_code_3']),
                             'country_id' => $billing_address['entry_country_id'],
                             'format_id' => $billing_address['address_format_id']);

      $index = 0;
      $products = $cart->get_products();
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {
        $this->products[$index] = array('qty' => $products[$i]['quantity'],
                                        'name' => $products[$i]['name'],
                                        'model' => $products[$i]['model'],
                                        'tax' => tep_get_tax_rate($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                                        'tax_description' => tep_get_tax_description($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                                        'price' => $products[$i]['price'],
                                        'final_price' => $products[$i]['price'] + $cart->attributes_price($products[$i]['id']),
                                        'weight' => $products[$i]['weight'],
                                        'id' => $products[$i]['id']);

        if ($products[$i]['attributes']) {
          $subindex = 0;
          reset($products[$i]['attributes']);
          while (list($option, $value) = each($products[$i]['attributes'])) {
//++++ QT Pro: Begin Changed code
            $attributes_query = tep_db_query("select popt.products_options_name, popt.products_options_track_stock, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . (int)$products[$i]['id'] . "' and pa.options_id = '" . (int)$option . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$value . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . (int)$languages_id . "' and poval.language_id = '" . (int)$languages_id . "'");
//++++ QT Pro: End Changed Code
            $attributes = tep_db_fetch_array($attributes_query);
//++++ QT Pro: Begin Changed code
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options_name'],
                                                                     'value' => $attributes['products_options_values_name'],
                                                                     'option_id' => $option,
                                                                     'value_id' => $value,
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price'],
                                                                     'track_stock' => $attributes['products_options_track_stock']);
//++++ QT Pro: End Changed Code
            $subindex++;
          }
        }

        $shown_price = $currencies->calculate_price($this->products[$index]['final_price'], $this->products[$index]['tax'], $this->products[$index]['qty']);
        $this->info['subtotal'] += $shown_price;

        $products_tax = $this->products[$index]['tax'];
        $products_tax_description = $this->products[$index]['tax_description'];
        if (DISPLAY_PRICE_WITH_TAX == 'true') {
          $this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          if (isset($this->info['tax_groups']["$products_tax_description"])) {
            $this->info['tax_groups']["$products_tax_description"] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          } else {
            $this->info['tax_groups']["$products_tax_description"] = $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          }
        } else {
          $this->info['tax'] += ($products_tax / 100) * $shown_price;
          if (isset($this->info['tax_groups']["$products_tax_description"])) {
            $this->info['tax_groups']["$products_tax_description"] += ($products_tax / 100) * $shown_price;
          } else {
            $this->info['tax_groups']["$products_tax_description"] = ($products_tax / 100) * $shown_price;
          }
        }

        $index++;
      }

      if (DISPLAY_PRICE_WITH_TAX == 'true') {
        // BOF osc_Giftwrap
        $this->info['total'] = $this->info['subtotal'] + $this->info['shipping_cost'] + $this->info['giftwrap_cost'];
        // BOF osc_Giftwrap
      } else {
        // BOF osc_Giftwrap
        $this->info['total'] = $this->info['subtotal'] + $this->info['tax'] + $this->info['shipping_cost'] + $this->info['giftwrap_cost'];
        // BOF osc_Giftwrap
      }
    }
  }
?>
