<?php
/*
  $Id: currencies.php,v 1.16 2003/06/05 23:16:46 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

////
// Class to handle currencies
// TABLES: currencies
  class currencies {
    var $currencies;

// class constructor
    function currencies() {
      $this->currencies = array();
      $currencies_query = tep_db_query("select code, title, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, value from " . TABLE_CURRENCIES);
      while ($currencies = tep_db_fetch_array($currencies_query)) {
        $this->currencies[$currencies['code']] = array('title' => $currencies['title'],
                                                       'symbol_left' => $currencies['symbol_left'],
                                                       'symbol_right' => $currencies['symbol_right'],
                                                       'decimal_point' => $currencies['decimal_point'],
                                                       'thousands_point' => $currencies['thousands_point'],
                                                       'decimal_places' => $currencies['decimal_places'],
                                                       'value' => $currencies['value']);
      }
    }

// class methods
    function format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
// Start Prices for Logged-In Users Only v5
		if ( defined( STORE_SHOW_GUESTS_PRICES ) && ( STORE_SHOW_GUESTS_PRICES == 'true' ) && (! tep_session_is_registered('customer_id') ) ) {
          return TEXT_LOG_IN_TO_SEE_PRICE;
		}
// End Prices for Logged-In Users Only v5
      global $currency;

      if (empty($currency_type)) $currency_type = $currency;

      if ($calculate_currency_value == true) {
        $rate = (tep_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        $format_string = $this->currencies[$currency_type]['symbol_left'] . '&nbsp;' . number_format(tep_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . '&nbsp;' . $this->currencies[$currency_type]['symbol_right'];
      } else {
        $format_string = $this->currencies[$currency_type]['symbol_left'] . '&nbsp;' . number_format(tep_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . '&nbsp;' . $this->currencies[$currency_type]['symbol_right'];
      }

// BOF: WebMakers.com Added: Down for Maintenance
      if (DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') {
        $format_string= '';
      }
// BOF: WebMakers.com Added: Down for Maintenance

        return $format_string;
    }
    
// QuickPay changed start
// compatibility with rc2
    
    function calculate_price($products_price, $products_tax, $quantity = 1) {
      global $currency;

      return tep_round(tep_add_tax($products_price, $products_tax), $this->currencies[$currency]['decimal_places']) * $quantity;
    }
// QuickPay changed end

// QuickPay added start
    function calculate($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '', $currency_decimal_point = '', $currency_thousands_point = '@') {
      global $currency;

      if (empty($currency_type)) $currency_type = $currency;
      if (empty($currency_decimal_point)) $currency_decimal_point = $this->currencies[$currency_type]['decimal_point'];
      if ($currency_thousands_point == '@') $currency_thousands_point = $this->currencies[$currency_type]['thousands_point'];
      
      $number_display = $number; 
      if ($calculate_currency_value) {
          $rate = (tep_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
          $number_display = $number * $rate;
      }
      return number_format($number_display, $this->currencies[$currency_type]['decimal_places'], $currency_decimal_point, $currency_thousands_point); 
    }
// QuickPay added end
    function is_set($code) {
      if (isset($this->currencies[$code]) && tep_not_null($this->currencies[$code])) {
        return true;
      } else {
        return false;
      }
    }

    function get_value($code) {
      return $this->currencies[$code]['value'];
    }

    function get_decimal_places($code) {
      return $this->currencies[$code]['decimal_places'];
    }

    function display_price($products_price, $products_tax, $quantity = 1) {
      return $this->format($this->calculate_price($products_price, $products_tax, $quantity));
    }
  }
?>
