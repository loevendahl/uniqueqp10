<?php
 include(DIR_FS_CATALOG.DIR_WS_CLASSES.'QuickpayApi.php');
 //ini_set("display_errors","on");
//error_reporting(E_ALL);
/*
  quickpay_advanced.php, v1.1 - 2011-06-17

   osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
 */

class quickpay_advanced {

    var $code, $title, $description, $enabled, $creditcardgroup, $num_groups;

// class constructor
    function quickpay_advanced() {
        global $order,$cardlock;

        $this->code = 'quickpay_advanced';
        $this->title = MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_TITLE;
        $this->public_title = MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_PUBLIC_TITLE;
        $this->description = MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_QUICKPAY_ADVANCED_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_QUICKPAY_ADVANCED_STATUS == 'True') ? true : false);
        $this->creditcardgroup = array();
	    $this->email_footer = ($cardlock == "ibill" || $cardlock == "viabill" ? DENUNCIATION : '');
		
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF PAYMENT GROUPS NEEDED
        $this->num_groups = 5;

        if ((int) MODULE_PAYMENT_QUICKPAY_ADVANCED_PREPARE_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_QUICKPAY_ADVANCED_PREPARE_ORDER_STATUS_ID;
        }

        if (is_object($order))
            $this->update_status;

 
        // Store online payment options in local variable
        for ($i = 1; $i <= $this->num_groups; $i++) {
            if (defined('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) && constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) != '') {
              /*  if (!isset($this->creditcardgroup[constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i . '_FEE')])) {
                  $this->creditcardgroup[constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i . '_FEE')] = array();
                }*/
                $payment_options = preg_split('[\,\;]', constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i));
                foreach ($payment_options as $option) {
                   $msg .= $option;
               //     $this->creditcardgroup[constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i . '_FEE')][] = $option;
                }
           
		   
            }
			
        }
//V10       
           if($_POST['quickpayIT'] == "go" && !isset($_SESSION['qlink'])) { 
			$this->form_action_url = 'https://payment.quickpay.net/';
		   }else{
            $this->form_action_url = tep_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL');
		   }
   
    }

// class methods

    function update_status() {
        global $order, $quickpay_fee, $HTTP_POST_VARS, $qp_card;

        if (($this->enabled == true) && ((int) MODULE_PAYMENT_QUICKPAY_ZONE > 0)) {
            $check_flag = false;
            $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_QUICKPAY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
            while ($check = tep_db_fetch_array($check_query)) {
                if ($check['zone_id'] < 1) {
                    $check_flag = true;
                    break;
                } elseif ($check['zone_id'] == $order->billing['zone_id']) {
                    $check_flag = true;
                    break;
                }
            }

            if ($check_flag == false) {
                $this->enabled = false;
            }
        }

        if (!tep_session_is_registered('qp_card'))
            tep_session_register('qp_card');
        if (isset($_POST['qp_card']))
            $qp_card = $_POST['qp_card'];
 
 if (!tep_session_is_registered('cart_QuickPay_ID'))
            tep_session_register('cart_QuickPay_ID');
        if (isset($_GET['cart_QuickPay_ID']))
            $qp_card = $_GET['cart_QuickPay_ID'];
			

        if (!tep_session_is_registered('quickpay_fee')) {
            tep_session_register('quickpay_fee');
        }
    }

    function javascript_validation() {


      $js = '  if (payment_value == "' . $this->code . '") {' . "\n" .
                '     var qp_card_value = null;' . "\n" .
                '      if (document.checkout_payment.qp_card.length) {' . "\n" .
                '        for (var i=0; i<document.checkout_payment.qp_card.length; i++) {' . "\n" .
                '          if (document.checkout_payment.qp_card[i].checked) {' . "\n" .
                '            qp_card_value = document.checkout_payment.qp_card[i].value;' . "\n" .
                '          }' . "\n" .
                '        }' . "\n" .
                '      } else if (document.checkout_payment.qp_card.checked) {' . "\n" .
                '        qp_card_value = document.checkout_payment.qp_card.value;' . "\n" .
                '      } else if (document.checkout_payment.qp_card.value) {' . "\n" .
                '        qp_card_value = document.checkout_payment.qp_card.value;' . "\n" .
                '        document.checkout_payment.qp_card.checked=true;' . "\n" .
                '      }' . "\n" .
                '    if (qp_card_value == null) {' . "\n" .
                '      error_message = error_message + "' . MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_SELECT_CARD . '";' . "\n" .
                '      error = 1;' . "\n" .
                '    }' . "\n" .
				' if (document.checkout_payment.cardlock.value == null) {' . "\n" .
                '      error_message = error_message + "' . MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_SELECT_CARD . '";' . "\n" .
                '      error = 1;' . "\n" .
                '    }' . "\n" .
                '  }' . "\n";
        return $js;
		
		
		
    }

 function selection() {
        global $order, $currencies, $qp_card,$cardlock;
	    $qty_groups = 0;
		//$fees =array();
		
       
	   
	    for ($i = 1; $i <= $this->num_groups; $i++) {
            if (constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) == '') {
                continue;
            }
		/*	if (constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i. '_FEE') == '') {
                continue;
            }else{
			$fees[$i] = constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i . '_FEE');
			}*/
            $qty_groups++;
        }

 if($qty_groups>1) {
	 $selection = array('id' => $this->code,
         'module' => $this->title. tep_draw_hidden_field('cardlock', $cardlock ));
	// $selection['module'] .= tep_draw_hidden_field('qp_card', (isset($fees[1])) ? $fees[1] : '0');
	 
	 }
		
		       $selection['fields'] = array();
               $msg = '';
			   $optscount=0;
	 for ($i = 1; $i <= $this->num_groups; $i++) {
               $options_text = '';
      if (defined('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) && constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) != '') {
                $payment_options = preg_split('[\,\;]', constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i));
			    foreach ($payment_options as $option) {
        $cost = (MODULE_PAYMENT_QUICKPAY_ADVANCED_AUTOFEE == "No" || $option == 'viabill' ? "0" : "1");   
			  if($option=="creditcard"){
			  $optscount++;
				  //You can extend the following cards-array and upload corresponding titled images to images/icons
				  $cards= array('dankort','visa','american-express','jcb','mastercard');
				      foreach ($cards as $optionc) {
			 				$iconc ="";
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".png") ? DIR_WS_ICONS.$optionc.".png": $iconc);
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".jpg") ? DIR_WS_ICONS.$optionc.".jpg": $iconc);
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".gif") ? DIR_WS_ICONS.$optionc.".gif": $iconc);   
			//define payment icon width
			   $w= 35;
			   $h= 22;
			   $space = 5;		   
				$msg .= '<img src="'.$iconc.'" title="'.$optionc.'" width="'.$w.'" height="'.$h.'"  style="position:relative;border:0px;float:left;margin:'.$space.'px; " />';   
				  // $msg .= tep_image($iconc,$optionc,$w,$h,'style="position:relative;border:0px;float:left;margin:'.$space.'px;" ');
					 
					 
					  }
					  $options_text=$msg;
			 
				
				   // $cost = $this->calculate_order_fee($order->info['total'], $fees[$i]);	

				
 if($qty_groups==1){
		 
			 $selection = array('id' => $this->code,
         'module' => '<table width="100%" border="0">
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectQuickPayRowEffect(this, ' . ($optscount-1) . ',\''.$option.'\')">
                        <td class="main" style="height:22px;vertical-align:middle;">' .$options_text.($cost !=0 ? '</td><td class="main" style="height:22px;vertical-align:middle;"> (+ '.MODULE_PAYMENT_QUICKPAY_ADVANCED_FEELOCKINFO.')' :'').'
                            </td>
                    </tr></table>'.tep_draw_hidden_field('cardlock', $option));
		 
		 
	 }else{
				
					$selection['fields'][] = array('title' => '<table width="100%" border="0">
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectQuickPayRowEffect(this, ' . ($optscount-1) . ',\''.$option.'\')">
                        <td class="main" style="height:22px;vertical-align:middle;">' . $options_text.($cost !=0 ? '</td><td style="height:22px;vertical-align:middle;">(+ '.MODULE_PAYMENT_QUICKPAY_ADVANCED_FEELOCKINFO.')' :'').'
                            </td>
                    </tr></table>',
                    'field' => tep_draw_radio_field('qp_card', '', ($option==$cardlock ? true : false), ' onClick="setQuickPay(); document.checkout_payment.cardlock.value = \''.$option.'\';" '));

	 }//end qty=1
			 
			  }
			  
			  if($option != "creditcard"){
				  //upload images to images/icons corresponding to your chosen cardlock groups in your payment module settings
				  //OPTIONAL image if different from cardlogo, add _payment to filename
			
			  $selectedopts = explode(",",$option);	
				$icon ="";
				foreach($selectedopts as $option){
				$optscount++;
				
$icon = (file_exists(DIR_WS_ICONS.$option.".png") ? DIR_WS_ICONS.$option.".png": $icon);
$icon = (file_exists(DIR_WS_ICONS.$option.".jpg") ? DIR_WS_ICONS.$option.".jpg": $icon);
$icon = (file_exists(DIR_WS_ICONS.$option.".gif") ? DIR_WS_ICONS.$option.".gif": $icon);   
$icon = (file_exists(DIR_WS_ICONS.$option."_payment.png") ? DIR_WS_ICONS.$option."_payment.png": $icon);
$icon = (file_exists(DIR_WS_ICONS.$option."_payment.jpg") ? DIR_WS_ICONS.$option."_payment.jpg": $icon);
$icon = (file_exists(DIR_WS_ICONS.$option."_payment.gif") ? DIR_WS_ICONS.$option."_payment.gif": $icon); 				   
		$space = 5;
		//define payment icon width
		if(strstr($icon, "_payment")){
			$w=120;
			$h= 27;
			if(strstr($icon, "3d")){
				$w=60;
			}
			
		}else{
			   $w= 35;
			   $h= 22;
			   
			
		}
		
		 //$cost = $this->calculate_order_fee($order->info['total'], $fees[$i]);

		 $options_text = '<table><tr><td> <img src="'.$icon.'" title="'.$this->get_payment_options_name($option).'" width="'.$w.'" height="'.$h.'"  style="position:relative;border:0px;float:left;margin:'.$space.'px; " /></td><td style="height: 27px;white-space:nowrap;vertical-align:middle;font-size: 18px;font-color:#666;" >'.$this->get_payment_options_name($option).'</td></tr></table>';
				
				   	
			
		 if($qty_groups==1){
		 
		 $selection = array('id' => $this->code,
         'module' => '<table width="100%" border="0">
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectQuickPayRowEffect(this, ' . ($optscount-1) . ',\''.$option.'\')">
                        <td class="main" style="height: 27px;white-space:nowrap;vertical-align:middle;font-size: 18px;font-color:#666;">' .$options_text.($cost !=0 ? '</td><td style="height:22px;vertical-align:middle;"> (+ '.MODULE_PAYMENT_QUICKPAY_ADVANCED_FEELOCKINFO.')' :'').'
                            </td>
                    </tr></table>'.tep_draw_hidden_field('cardlock', $option).tep_draw_hidden_field('qp_card', (isset($fees[1])) ? $fees[1] : '0'));
		 
		 
	 }else{	
					$selection['fields'][] = array('title' => '<table width="100%" border="0">
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectQuickPayRowEffect(this, ' . ($optscount-1) . ',\''.$option.'\')">
                        <td class="main" style="height: 27px;white-space:nowrap;vertical-align:middle;font-size: 18px;font-color:#666;">' . $options_text.($cost !=0 ? '</td><td style="height:22px;vertical-align:middle;"> (+ '.MODULE_PAYMENT_QUICKPAY_ADVANCED_FEELOCKINFO.')' :'').'
                            </td>
                    </tr></table>',
                    'field' => 
					tep_draw_radio_field('qp_card', '', ($option==$cardlock ? true : false), ' onClick="setQuickPay();document.checkout_payment.cardlock.value = \''.$option.'\';" '));
				
	 }//end qty
				
				}
           
					}
				
				
				
				}
		    }
			
       
	                  
	   
	   
	   
	   
	    }
			
	
	

    
   
            $js_function = '
        <script language="javascript"><!-- 
     
		  function setQuickPay() {
			
			  
          	var radioLength = document.checkout_payment.payment.length;
          	for(var i = 0; i < radioLength; i++) {
				
          		document.checkout_payment.payment[i].checked = false;
          		if(document.checkout_payment.payment[i].value == "quickpay_advanced") {
				
          			document.checkout_payment.payment[i].checked = true;
					
          		}
          	}
          }
          function selectQuickPayRowEffect(object, buttonSelect, option) {
            if (!selected) {
              if (document.getElementById) {
                selected = document.getElementById("defaultSelected");
              } else {
                selected = document.all["defaultSelected"];
              }
            }
         
            if (selected) selected.className = "moduleRow";
            object.className = "moduleRowSelected";
            selected = object;
            document.checkout_payment.cardlock.value = option;
		    document.checkout_payment.qp_card.checked = false;
              if (document.checkout_payment.qp_card[0]) {
              document.checkout_payment.qp_card[buttonSelect].checked=true;
            } else {
              document.checkout_payment.qp_card.checked=true;
            }
            setQuickPay();
          }
        //--></script>
        ';
            $selection['module'] .= $js_function;
      
    
        return $selection;
    }


    function pre_confirmation_check() {
        global $cartID, $cart;

        if (empty($cart->cartID)) {
            $cartID = $cart->cartID = $cart->generate_cart_id();
        }

        if (!tep_session_is_registered('cartID')) {
            tep_session_register('cartID');
        }
        $this->get_order_fee();
    }

    function confirmation($addorder=false) {
        global $cartID, $cart_QuickPay_ID, $customer_id, $languages_id, $order, $order_total_modules;
$order_id = substr($cart_QuickPay_ID, strpos($cart_QuickPay_ID, '-') + 1);
//do not create preparing order id before payment confirmation is chosen by customer
if($_POST['callquickpay'] == "go" && !$order_id) {


  
// write new pro forma order if payment link is not created
//if(!isset($_SESSION['qlink'])){
                $order_totals = array();
                if (is_array($order_total_modules->modules)) {
                    reset($order_total_modules->modules);
                    while (list(, $value) = each($order_total_modules->modules)) {
                        $class = substr($value, 0, strrpos($value, '.'));
                        if ($GLOBALS[$class]->enabled) {
                            for ($i = 0, $n = sizeof($GLOBALS[$class]->output); $i < $n; $i++) {
                                if (tep_not_null($GLOBALS[$class]->output[$i]['title']) && tep_not_null($GLOBALS[$class]->output[$i]['text'])) {
                                    $order_totals[] = array('code' => $GLOBALS[$class]->code,
                                        'title' => $GLOBALS[$class]->output[$i]['title'],
                                        'text' => $GLOBALS[$class]->output[$i]['text'],
                                        'value' => $GLOBALS[$class]->output[$i]['value'],
                                        'sort_order' => $GLOBALS[$class]->sort_order);
                                }
                            }
                        }
                    }
                }

                $sql_data_array = array('customers_id' => $customer_id,
                    'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
                    'customers_company' => $order->customer['company'],
                    'customers_street_address' => $order->customer['street_address'],
                    'customers_suburb' => $order->customer['suburb'],
                    'customers_city' => $order->customer['city'],
                    'customers_postcode' => $order->customer['postcode'],
                    'customers_state' => $order->customer['state'],
                    'customers_country' => $order->customer['country']['title'],
                    'customers_telephone' => $order->customer['telephone'],
                    'customers_email_address' => $order->customer['email_address'],
                    'customers_address_format_id' => $order->customer['format_id'],
                    'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
                    'delivery_company' => $order->delivery['company'],
                    'delivery_street_address' => $order->delivery['street_address'],
                    'delivery_suburb' => $order->delivery['suburb'],
                    'delivery_city' => $order->delivery['city'],
                    'delivery_postcode' => $order->delivery['postcode'],
                    'delivery_state' => $order->delivery['state'],
                    'delivery_country' => $order->delivery['country']['title'],
                    'delivery_address_format_id' => $order->delivery['format_id'],
                    'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
                    'billing_company' => $order->billing['company'],
                    'billing_street_address' => $order->billing['street_address'],
                    'billing_suburb' => $order->billing['suburb'],
                    'billing_city' => $order->billing['city'],
                    'billing_postcode' => $order->billing['postcode'],
                    'billing_state' => $order->billing['state'],
                    'billing_country' => $order->billing['country']['title'],
                    'billing_address_format_id' => $order->billing['format_id'],
                    'payment_method' => $order->info['payment_method'],
                    'cc_type' => $order->info['cc_type'],
                    'cc_owner' => $order->info['cc_owner'],
                    'cc_number' => $order->info['cc_number'],
                    'cc_expires' => $order->info['cc_expires'],
					'cc_cardhash' => '',
                    'date_purchased' => 'now()',
                    'orders_status' => $order->info['order_status'],
                    'currency' => $order->info['currency'],
                    'currency_value' => $order->info['currency_value']);

	 tep_db_perform(TABLE_ORDERS, $sql_data_array);

                $insert_id = tep_db_insert_id();
			
			
                for ($i = 0, $n = sizeof($order_totals); $i < $n; $i++) {
                    $sql_data_array = array('orders_id' => $insert_id,
                        'title' => $order_totals[$i]['title'],
                        'text' => $order_totals[$i]['text'],
                        'value' => $order_totals[$i]['value'],
                        'class' => $order_totals[$i]['code'],
                        'sort_order' => $order_totals[$i]['sort_order']);

	 tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

   
                }

// checkout_process section
// this section is taken from checkout_process.php
// update of stock data is done in checkout_process
// adapt if you have done adoptions there
// 
// the data of the order-obj is depending if it was created from the cart or
// by a given order-id
// therefore the product data needs to be written in the cart context
// 
// 




                for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
                    /*
                     * do not update stock - until order is confirmed
                     * will be done in checkout_process                   
                     */
                    $sql_data_array = array('orders_id' => $insert_id,
                        'products_id' => tep_get_prid($order->products[$i]['id']),
                        'products_model' => $order->products[$i]['model'],
                        'products_name' => $order->products[$i]['name'],
                        'products_price' => $order->products[$i]['price'],
                        'final_price' => $order->products[$i]['final_price'],
                        'products_tax' => $order->products[$i]['tax'],
                        'products_quantity' => $order->products[$i]['qty']);
                    tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
                    $order_products_id = tep_db_insert_id();

//------insert customer choosen option to order--------
                    $attributes_exist = '0';
                    $products_ordered_attributes = '';
                    if (isset($order->products[$i]['attributes'])) {
                        $attributes_exist = '1';
                        for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
                            if (DOWNLOAD_ENABLED == 'true') {
                                $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename 
                               from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa 
                               left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                on pa.products_attributes_id=pad.products_attributes_id
                               where pa.products_id = '" . $order->products[$i]['id'] . "' 
                                and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' 
                                and pa.options_id = popt.products_options_id 
                                and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' 
                                and pa.options_values_id = poval.products_options_values_id 
                                and popt.language_id = '" . $languages_id . "' 
                                and poval.language_id = '" . $languages_id . "'";
                                $attributes = tep_db_query($attributes_query);
                            } else {
                                $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
                            }
                            $attributes_values = tep_db_fetch_array($attributes);

                            $sql_data_array = array('orders_id' => $insert_id,
                                'orders_products_id' => $order_products_id,
                                'products_options' => $attributes_values['products_options_name'],
                                'products_options_values' => $attributes_values['products_options_values_name'],
                                'options_values_price' => $attributes_values['options_values_price'],
                                'price_prefix' => $attributes_values['price_prefix']);
                            tep_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

                            if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
                                $sql_data_array = array('orders_id' => $insert_id,
                                    'orders_products_id' => $order_products_id,
                                    'orders_products_filename' => $attributes_values['products_attributes_filename'],
                                    'download_maxdays' => $attributes_values['products_attributes_maxdays'],
                                    'download_count' => $attributes_values['products_attributes_maxcount']);
                                tep_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
                            }
                            $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
                        }
                    }

                }
/// end checkout_process section
                $cart_QuickPay_ID = $cartID . '-' . $insert_id;
                tep_session_register('cart_QuickPay_ID');

   
//end if($_POST['quickpayIT'] == "go") {
}
if($this->email_footer !='' && $addorder==false){
        return array('title' => $this->email_footer);
    }else{return false;}
  //}	
	}

    function process_button() {
		        global $shipvars, $_POST, $customer_id, $order, $currencies, $currency, $languages_id, $language, $cart_QuickPay_ID, $order_total_modules;
        /*
         * collect all post fields and attach as hiddenfieds to button
         */


        $process_button_string = '';
		$process_fields ='';
        $process_parameters = array();

        $qp_merchant_id = MODULE_PAYMENT_QUICKPAY_ADVANCED_MERCHANTID;
		$qp_aggreement_id = MODULE_PAYMENT_QUICKPAY_ADVANCED_AGGREEMENTID;


// TODO: dynamic language switching instead of hardcoded mapping
        $qp_language = "da";
        switch ($language) {
            case "english": $qp_language = "en";
                break;
            case "swedish": $qp_language = "se";
                break;
            case "norwegian": $qp_language = "no";
                break;
            case "german": $qp_language = "de";
                break;
            case "french": $qp_language = "fr";
                break;
        }
         $qp_branding_id = "";

	     $qp_subscription = (MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION == "Normal" ? "" : "1");
		 $qp_cardtypelock = $_POST['cardlock'];
		 $qp_autofee = (MODULE_PAYMENT_QUICKPAY_ADVANCED_AUTOFEE == "No" || $qp_cardtypelock == 'viabill' ? "0" : "1");
         $qp_description = "Merchant ".$qp_merchant_id." ".(MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION == "Normal" ? "Authorize" : "Subscription");
		 $order_id = substr($cart_QuickPay_ID, strpos($cart_QuickPay_ID, '-') + 1);
         $qp_order_id = $qp_aggreement_id."_".sprintf('%04d', $order_id);
// Calculate the total order amount for the order (the same way as in checkout_process.php)
        $qp_order_amount = 100 * $currencies->calculate($order->info['total'], true, $order->info['currency'], $order->info['currency_value'], '.', '');
        $qp_currency_code = $order->info['currency'];
        $qp_continueurl = tep_href_link(FILENAME_CHECKOUT_PROCESS, 'cart_QuickPay_ID='.$cart_QuickPay_ID, 'SSL');
        $qp_cancelurl = tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=' . $this->code, 'SSL');
        $qp_callbackurl = tep_href_link('callback10.php','oid='.$order_id,'SSL');
        $qp_autocapture = (MODULE_PAYMENT_QUICKPAY_ADVANCED_AUTOCAPTURE == "No" ? "0" : "1");
		$qp_version ="v10";
        $qp_apikey = MODULE_PAYMENT_QUICKPAY_ADVANCED_APIKEY;

			$qp_product_id = "P03";
			$qp_category = MODULE_PAYMENT_QUICKPAY_ADVANCED_PAII_CAT;
			$qp_reference_title = $qp_order_id;
			$qp_vat_amount = ($order->info['tax'] ? $order->info['tax'] : "0.00");

  //custom vars
	   $varsvalues = array('variables[customers_id]' => $customer_id,
                    'variables[customers_name]' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
                   'variables[customers_company]' => $order->customer['company'],
                    'variables[customers_street_address]' => $order->customer['street_address'],
                   'variables[customers_suburb]' => $order->customer['suburb'],
                    'variables[customers_city]' => $order->customer['city'],
                    'variables[customers_postcode]' => $order->customer['postcode'],
                   'variables[customers_state]' => $order->customer['state'],
                    'variables[customers_country]' => $order->customer['country']['title'],
                    'variables[customers_telephone]' => $order->customer['telephone'],
                    'variables[customers_email_address]' => $order->customer['email_address'],
                    'variables[delivery_name]' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
                    'variables[delivery_company]' => $order->delivery['company'],
                    'variables[delivery_street_address]' => $order->delivery['street_address'],
                    'variables[delivery_suburb]' => $order->delivery['suburb'],
                    'variables[delivery_city]' => $order->delivery['city'],
                    'variables[delivery_postcode]' => $order->delivery['postcode'],
                   'variables[delivery_state]' => $order->delivery['state'],
                    'variables[delivery_country]' => $order->delivery['country']['title'],
                    'variables[delivery_address_format_id]' => $order->delivery['format_id'],
                    'variables[billing_name]' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
                    'variables[billing_company]' => $order->billing['company'],
                    'variables[billing_street_address]' => $order->billing['street_address'],
                    'variables[billing_suburb]' => $order->billing['suburb'],
                    'variables[billing_city]' => $order->billing['city'],
                    'variables[billing_postcode]' => $order->billing['postcode'],
                   'variables[billing_state]' => $order->billing['state'],
                    'variables[billing_country]' => $order->billing['country']['title']);



                for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
    
                    $order_products_id = tep_get_prid($order->products[$i]['id']);

//------insert customer choosen option to order--------
                    $attributes_exist = '0';
                    $products_ordered_attributes = '';
                    if (isset($order->products[$i]['attributes'])) {
                        $attributes_exist = '1';
                        for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
                            if (DOWNLOAD_ENABLED == 'true') {
                                $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename 
                               from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa 
                               left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                on pa.products_attributes_id=pad.products_attributes_id
                               where pa.products_id = '" . $order->products[$i]['id'] . "' 
                                and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' 
                                and pa.options_id = popt.products_options_id 
                                and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' 
                                and pa.options_values_id = poval.products_options_values_id 
                                and popt.language_id = '" . $languages_id . "' 
                                and poval.language_id = '" . $languages_id . "'";
                                $attributes = tep_db_query($attributes_query);
                            } else {
                                $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
                            }
                            $attributes_values = tep_db_fetch_array($attributes);
                            

                            if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
   
                               
                            }
                            $products_ordered_attributes .= "(" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'].") ";
                        }
                    }
//------insert customer choosen option eof ----
             
                      $total_weight += ( $order->products[$i]['qty'] * $order->products[$i]['weight']);
                      $total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
                      $total_cost += $total_products_price;

                      $products_ordered[] = $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "-";

                }
				$ps="";
		       while (list ($key, $value) = each($products_ordered)) {
		  $ps .= $value;
        }
		
        //$varsvalues["variables[products]"] = html_entity_decode($ps);
		$varsvalues["variables[shopsystem]"] = "Unique Free";
  

//end custom vars

// register fields to hand over

		$process_parameters = array(
					'agreement_id'                 => $qp_aggreement_id,
					'amount'                       => $qp_order_amount,
					'autocapture'                  => $qp_autocapture,
					'autofee'                      => $qp_autofee,
					//'branding_id'                  => $qp_branding_id,
					'callbackurl'                  => $qp_callbackurl,
					'cancelurl'                    => $qp_cancelurl,
					'continueurl'                  => $qp_continueurl,
					'currency'                     => $qp_currency_code,
					'description'                  => $qp_description,
					'google_analytics_client_id'   => $qp_google_analytics_client_id,
					'google_analytics_tracking_id' => $analytics_tracking_id,
					'language'                     => $qp_language,
					'merchant_id'                  => $qp_merchant_id,
					'order_id'                     => $qp_order_id,
					'payment_methods'              => $qp_cardtypelock,
					'product_id'                   => $qp_product_id,
					'category'                     => $qp_category,
					'reference_title'              => $qp_reference_title,
					'vat_amount'                   => $qp_vat_amount,
					'subscription'                 => $qp_subscription,
					'version'                      => 'v10'
						);
 
 //avoid null values
//$varsvalues = array_walk($varsvalues, create_function('&$str', '$str = "\"$str\"";'));
 
//$process_parameters = array_merge($process_parameters,$varsvalues);


	//	mail("kl@blkom.dk","post_var",json_encode($HTTP_POST_VARS)."\n". json_encode($_SESSION)."\n". json_encode($order))."\n". json_encode($shipping);
	
		
if($_POST['callquickpay'] == "go") {

	    $apiorder= new QuickpayApi();
	$apiorder->setOptions(MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY);
	//set status request mode
	$mode = (MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION == "Normal" ? "" : "1");
	  	//been here before?
	    $exists = $this->get_quickpay_order_status($order_id, $mode);
	 
    $qid = $exists["qid"];
	//set to create/update mode
	$apiorder->mode = (MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION == "Normal" ? "payments/" : "subscriptions/");
	  if($exists["qid"] == null){

      //create new quickpay order	
      $storder = $apiorder->createorder($qp_order_id, $qp_currency_code, $process_parameters);
   
	  $qid = $storder["id"];

      }else{
       $qid = $exists["qid"];
       }
			
		$storder = $apiorder->link($qid, $process_parameters);	
		$url = $storder['url'];


			$process_button_string .= "<script>
     
 window.location.replace('".$storder['url']."');
  </script>"; 


				
	
}
	
	
	
	$process_button_string .=  "<input type='hidden' value='go' name='callquickpay' />". "\n".
            	"<input type='hidden' value='" . $_POST['cardlock'] . "' name='cardlock' />"
				. "\n";	
				
				foreach($_POST as $key=>$value){
				$process_button_string .= "<input type='hidden' value='".$value."' name='".$key."' />". "\n";
				
			}

      return $process_button_string;

     
		
    }

    function before_process() {


// called in FILENAME_CHECKOUT_PROCESS
// check if order is approved by callback

        global $customer_id, $order, $order_id, $order_totals, $order_total_modules, $sendto, $billto, $languages_id, $payment, $currencies, $cart, $cart_QuickPay_ID;
   

        $order_id = substr($cart_QuickPay_ID, strpos($cart_QuickPay_ID, '-') + 1);
    
       $order_status_approved_id = (MODULE_PAYMENT_QUICKPAY_ADVANCED_ORDER_STATUS_ID > 0 ? (int) MODULE_PAYMENT_QUICKPAY_ADVANCED_ORDER_STATUS_ID : (int) DEFAULT_ORDERS_STATUS_ID);

	$mode = (MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION == "Normal" ? "" : "1");
 $checkorderid = $this->get_quickpay_order_status($order_id, $mode);
 if($checkorderid["oid"] != $order_id){
	  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=' . $this->code, 'SSL'));
	 
 }

	    // adopt order status of order object to "real" status
        $order->info['order_status'] = $order_status_approved_id;

        //for debugging with FireBug / FirePHP
        global $firephp;
        if (isset($firephp)) {
            $firephp->log($order_id, 'order_id');
        }

        // everything is fine... continue
		

		
		
    }

    function after_process() {
		tep_session_unregister('cardlock');
        tep_session_unregister('order_id');
        tep_session_unregister('quickpay_fee');
        tep_session_unregister('qp_card');
        tep_session_unregister('cart_QuickPay_ID');
	    tep_session_unregister('qlink');
    }

    function get_error() {
	
		
		global $cart_QuickPay_ID, $order, $currencies;
        $order_id = substr($cart_QuickPay_ID, strpos($cart_QuickPay_ID, '-') + 1);;

			$error_desc = MODULE_PAYMENT_QUICKPAY_ADVANCED_ERROR_CANCELLED;
        $error = array('title' => MODULE_PAYMENT_QUICKPAY_ADVANCED_TEXT_ERROR,
            'error' => $error_desc);


//avoid order number already used: create a payment link if payment window was aborted
//for some reason
if(!$_SESSION["qlink"])	{
  try {

			$apiorder= new QuickpayApi();
	$apiorder->setOptions(MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY);
	//$api->mode = 'payments?currency='.$qp_currency_code.'&order_id='.
$qp_order_id = MODULE_PAYMENT_QUICKPAY_ADVANCED_AGGREEMENTID."_".sprintf('%04d', $order_id);
$mode = (MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION == "Normal" ? "" : "1");
$exists = $this->get_quickpay_order_status($order_id, $mode);

if($exists["qid"] == null){

//create new quickpay order	
$storder = $apiorder->createorder($qp_order_id, $order->info['currency']);
$qid = $storder["id"];
	
}else{
$qid = $exists["qid"];
}
//create or update link
$process_parameters = array(
"amount" => 100 * $currencies->calculate($order->info['total'], true, $order->info['currency'], $order->info['currency_value'], '.', ''),
"currency" => $order->info['currency']
);

$storder = $apiorder->link($qid, $process_parameters);
$_SESSION['qlink'] = $storder['url'];

  
  } catch (Exception $e) {
   $err .= 'QuickPay Status: ';
		  	// An error occured with the status request
    $err .= 'Problem: ' . $this->json_message_front($e->getMessage()) ;
		 //  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=' . $this->code, 'SSL'));
   $error['error'] = $error['error'].' - '.$err;
 
  }
  }  
        return $error;
	
    }

    function output_error() {
        return false;
    }

    function check() {
        if (!isset($this->_check)) {
            $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_QUICKPAY_ADVANCED_STATUS'");
            $this->_check = tep_db_num_rows($check_query);
        }
        return $this->_check;
    }

    function install() {
        // add field to order table if not already there

        $cc_query = tep_db_query("describe " . TABLE_ORDERS . " cc_transactionid");
        if (tep_db_num_rows($cc_query) == 0) {
            tep_db_query("ALTER TABLE " . TABLE_ORDERS . " ADD cc_transactionid VARCHAR( 64 ) NULL default 'NULL'");
        }
       $cc_query = tep_db_query("describe " . TABLE_ORDERS . " cc_cardhash");
        if (tep_db_num_rows($cc_query) == 0) {
            tep_db_query("ALTER TABLE " . TABLE_ORDERS . " ADD cc_cardhash VARCHAR( 64 ) NULL default 'NULL'");
        }
 $cc_query = tep_db_query("describe " . TABLE_ORDERS . " cc_cardtype");
        if (tep_db_num_rows($cc_query) == 0) {
            tep_db_query("ALTER TABLE " . TABLE_ORDERS . " ADD cc_cardtype VARCHAR( 64 ) NULL default 'NULL'");
        }
		tep_db_query("ALTER TABLE  " . TABLE_ORDERS . " CHANGE  cc_expires  cc_expires VARCHAR( 8 )  NULL DEFAULT NULL");
		
	
       // new status for quickpay prepare orders
        $check_query = tep_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Quickpay [preparing]' limit 1");

        if (tep_db_num_rows($check_query) < 1) {
            $status_query = tep_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
            $status = tep_db_fetch_array($status_query);

            $status_id = $status['status_id'] + 1;

            $languages = tep_get_languages();

            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                tep_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_id . "', '" . $languages[$i]['id'] . "', 'Quickpay [preparing]')");
            }

            // compatibility ms2.2 
            $flags_query = tep_db_query("describe " . TABLE_ORDERS_STATUS . " public_flag");
            if (tep_db_num_rows($flags_query) == 1) {
                tep_db_query("update " . TABLE_ORDERS_STATUS . " set public_flag = 0 and downloads_flag = 0 where orders_status_id = '" . $status_id . "'");
            }
        } else {
            $check = tep_db_fetch_array($check_query);

            $status_id = $check['orders_status_id'];
        }


        // new status for quickpay rejected orders
        $check_query = tep_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Quickpay [rejected]' limit 1");

        if (tep_db_num_rows($check_query) < 1) {
            $status_query = tep_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
            $status = tep_db_fetch_array($status_query);

            $status_rejected_id = $status['status_id'] + 1;

            $languages = tep_get_languages();

            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                tep_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_rejected_id . "', '" . $languages[$i]['id'] . "', 'Quickpay [rejected]')");
            }

            // compatibility ms2.2 
            $flags_query = tep_db_query("describe " . TABLE_ORDERS_STATUS . " public_flag");
            if (tep_db_num_rows($flags_query) == 1) {
                tep_db_query("update " . TABLE_ORDERS_STATUS . " set public_flag = 0 and downloads_flag = 0 where orders_status_id = '" . $status_rejected_id . "'");
            }
        } else {
            $check = tep_db_fetch_array($check_query);

            $status_rejected_id = $check['orders_status_id'];
        }
        
		// new status for quickpay pending orders
        $check_query = tep_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Pending [Quickpay approved]' limit 1");

        if (tep_db_num_rows($check_query) < 1) {
            $status_query = tep_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
            $status = tep_db_fetch_array($status_query);

            $status_pending_id = $status['status_id'] + 1;

            $languages = tep_get_languages();

            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                tep_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_pending_id . "', '" . $languages[$i]['id'] . "', 'Pending [Quickpay approved]')");
            }

            // compatibility ms2.2 
            $flags_query = tep_db_query("describe " . TABLE_ORDERS_STATUS . " public_flag");
            if (tep_db_num_rows($flags_query) == 1) {
                tep_db_query("update " . TABLE_ORDERS_STATUS . " set public_flag = 0 and downloads_flag = 0 where orders_status_id = '" . $status_pending_id . "'");
            }
        } else {
            $check = tep_db_fetch_array($check_query);

            $status_pending_id = $check['orders_status_id'];
        }
		
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('".MODULE_ADMIN_LABEL_ENABLE."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_STATUS', 'False', '".MODULE_ADMIN_TEXT_ENABLE."', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
  //      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Gateway', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_MODE', 'Test gateway', 'Choose Gateway mode:<br><b>Test gateway:</b> Sets gateway in testmode.<br><b>Quickpay:</b> Sets gateway in production mode', '6', '3', 'tep_cfg_select_option(array(\'Quickpay\', \'Test gateway\'), ', now())");


        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('".MODULE_ADMIN_LABEL_ZONE."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_ZONE', '0', '".MODULE_ADMIN_TEXT_ZONE."', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
       
	    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('".MODULE_ADMIN_LABEL_MERCHANT."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_MERCHANTID', '', '".MODULE_ADMIN_TEXT_MERCHANT."', '6', '6', now())"); 
		
	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('".MODULE_ADMIN_LABEL_USERAGREEMENT."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_AGGREEMENTID', '', '".MODULE_ADMIN_TEXT_USERAGREEMENT."', '6', '6', now())");


//		 tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Set Private key for your Quickpay Payment Gateway', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_PRIVATEKEY', '', 'Enter your Private key.', '6', '6', now())");
		 tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('".MODULE_ADMIN_LABEL_USERAPIKEY."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY', '', '".MODULE_ADMIN_TEXT_USERAPIKEY."', '6', '6', now())");
		
tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('".MODULE_ADMIN_LABEL_SUBSCRIPTION."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION', 'Normal', '".MODULE_ADMIN_TEXT_SUBSCRIPTION."', '6', '0', 'tep_cfg_select_option(array(\'Normal\', \'Subscription\'), ',now())");

		
tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('".MODULE_ADMIN_LABEL_AUTOFEE."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_AUTOFEE', 'No', '".MODULE_ADMIN_TEXT_AUTOFEE."', '6', '0', 'tep_cfg_select_option(array(\'Yes\', \'No\'), ',now())");

tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('".MODULE_ADMIN_LABEL_AUTOCAPTURE."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_AUTOCAPTURE', 'No', '".MODULE_ADMIN_TEXT_AUTOCAPTURE."', '6', '0', 'tep_cfg_select_option(array(\'Yes\', \'No\'), ',now())");     
        for ($i = 1; $i <= $this->num_groups; $i++) {
			if($i==1){
				$defaultlock='viabill';
		//		$qp_groupfee = '0:0';
			}else if($i==2){
				$defaultlock='creditcard';
	//			$qp_groupfee = '0:0';
		
			}else{
				$defaultlock='';
		//		$qp_groupfee ='0:0';
			}
           
            $qp_group = (defined('MODULE_PAYMENT_QUICKPAY_GROUP' . $i)) ? constant('MODULE_PAYMENT_QUICKPAY_GROUP' . $i) : $defaultlock;
        //    $qp_groupfee = (defined('MODULE_PAYMENT_QUICKPAY_GROUP' . $i . '_FEE')) ? constant('MODULE_PAYMENT_QUICKPAY_GROUP' . $i . '_FEE') : $qp_groupfee;
      

            tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('".MODULE_ADMIN_LABEL_GROUP. "', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP" . $i . "', '" . $qp_group . "', '" . MODULE_ADMIN_TEXT_GROUP. "', '6', '6', now())");
         //   tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Group " . $i . " Payments fee', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP" . $i . "_FEE', '" . $qp_groupfee . "', 'Fee for Group " . $i . " payments (fixed fee:percentage fee)<br>Example: <b>1.45:0.10</b>', '6', '6', now())");
        }

        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('".MODULE_ADMIN_LABEL_SORT."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_SORT_ORDER', '0', '".MODULE_ADMIN_TEXT_SORT."', '6', '0', now())");


        // new settings
		

					
//tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Paii shop category', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_PAII_CAT','', 'Shop category must be set, if using Paii cardlock (paii), ', '6', '0','tep_cfg_pull_down_paii_list(', now())");

        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('".MODULE_ADMIN_LABEL_PREPARING."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_PREPARE_ORDER_STATUS_ID', '" . $status_id . "', '".MODULE_ADMIN_TEXT_PREPARING."', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
 
 //unique free
 
 $status_pending_id = 1;
 //     
	    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('".MODULE_ADMIN_LABEL_PENDING."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_ORDER_STATUS_ID', '" . $status_pending_id . "', '".MODULE_ADMIN_TEXT_PENDING."', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
       
	    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('".MODULE_ADMIN_LABEL_REJECTED."', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_REJECTED_ORDER_STATUS_ID', '" . $status_rejected_id . "', '".MODULE_ADMIN_TEXT_REJECTED."', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");

    }

    function remove() {
        tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
        $keys = array('MODULE_PAYMENT_QUICKPAY_ADVANCED_STATUS', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_ZONE', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_SORT_ORDER', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_MERCHANTID', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_AGGREEMENTID','MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY','MODULE_PAYMENT_QUICKPAY_ADVANCED_PREPARE_ORDER_STATUS_ID', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_ORDER_STATUS_ID', 'MODULE_PAYMENT_QUICKPAY_ADVANCED_REJECTED_ORDER_STATUS_ID','MODULE_PAYMENT_QUICKPAY_ADVANCED_SUBSCRIPTION','MODULE_PAYMENT_QUICKPAY_ADVANCED_AUTOFEE','MODULE_PAYMENT_QUICKPAY_ADVANCED_AUTOCAPTURE');
		
        for ($i = 1; $i <= $this->num_groups; $i++) {
            $keys[] = 'MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i;
         //   $keys[] = 'MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i . '_FEE';
        }

        return $keys;
    }

//------------- Internal help functions-------------------------
// $order_total parameter must be total amount for current order including tax
// format of $fee parameter: "[fixed fee]:[percentage fee]"
    function calculate_order_fee($order_total, $fee) {
        list($fixed_fee, $percent_fee) = explode(':', $fee);
		
		
        return ((float) $fixed_fee + (float) $order_total * ($percent_fee / 100));
    }

    function get_order_fee() {
        global $_POST, $order, $currencies, $quickpay_fee;
        $quickpay_fee = 0.0;
        if (isset($_POST['qp_card']) && strpos($_POST['qp_card'], ":")) {
            $quickpay_fee = $this->calculate_order_fee($order->info['total'], $_POST['qp_card']);
        }
    }

    function get_payment_options_name($payment_option) {
        switch ($payment_option) {
            case '3d-jcb': return MODULE_PAYMENT_QUICKPAY_ADVANCED_JCB_3D_TEXT;
            case '3d-maestro': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MAESTRO_3D_TEXT;
            case '3d-maestro-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MAESTRO_DK_3D_TEXT;
            case '3d-mastercard': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_3D_TEXT;
            case '3d-mastercard-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_ADVANCED_MASTERCARD_DK_3D_TEXT;
            case '3d-visa': return MODULE_PAYMENT_QUICKPAY_ADVANCED_ADVANCED_VISA_3D_TEXT;
            case '3d-visa-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_ADVANCED_VISA_DK_3D_TEXT;
            case '3d-visa-electron': return MODULE_PAYMENT_QUICKPAY_ADVANCED_ADVANCED_VISA_ELECTRON_3D_TEXT;
            case '3d-visa-electron-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_DK_3D_TEXT;
            case '3d-visa-debet': return MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DEBET_3D_TEXT;
			case '3d-visa-debet-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DEBET_DK_3D_TEXT;
			case '3d-creditcard': return MODULE_PAYMENT_QUICKPAY_ADVANCED_CREDITCARD_3D_TEXT;
            case 'american-express': return MODULE_PAYMENT_QUICKPAY_ADVANCED_AMERICAN_EXPRESS_TEXT;
            case 'american-express-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_AMERICAN_EXPRESS_DK_TEXT;
            case 'dankort': return MODULE_PAYMENT_QUICKPAY_ADVANCED_DANKORT_TEXT;
            case 'danske-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_DANSKE_DK_TEXT;
            case 'diners': return MODULE_PAYMENT_QUICKPAY_ADVANCED_DINERS_TEXT;
            case 'diners-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_DINERS_DK_TEXT;
            case 'edankort': return MODULE_PAYMENT_QUICKPAY_ADVANCED_EDANKORT_TEXT;
            case 'jcb': return MODULE_PAYMENT_QUICKPAY_ADVANCED_JCB_TEXT;
            case 'mastercard': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_TEXT;
            case 'mastercard-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DK_TEXT;
			case 'mastercard-debet': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DEBET_TEXT;
            case 'mastercard-debet-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MASTERCARD_DEBET_DK_TEXT;
            case 'nordea-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_NORDEA_DK_TEXT;
            case 'visa': return MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_TEXT;
            case 'visa-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_DK_TEXT;
            case 'visa-electron': return MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_TEXT;
            case 'visa-electron-dk': return MODULE_PAYMENT_QUICKPAY_ADVANCED_VISA_ELECTRON_DK_TEXT;
		    case 'creditcard': return MODULE_PAYMENT_QUICKPAY_ADVANCED_CREDITCARD_TEXT;
			case 'ibill':  return MODULE_PAYMENT_QUICKPAY_ADVANCED_IBILL_DESCRIPTION;
			case 'viabill':  return MODULE_PAYMENT_QUICKPAY_ADVANCED_IBILL_DESCRIPTION;
            case 'fbg1886': return MODULE_PAYMENT_QUICKPAY_ADVANCED_FBG1886_TEXT;
            case 'paypal': return MODULE_PAYMENT_QUICKPAY_ADVANCED_PAYPAL_TEXT;
            case 'sofort': return MODULE_PAYMENT_QUICKPAY_ADVANCED_SOFORT_TEXT;
            case 'paii': return MODULE_PAYMENT_QUICKPAY_ADVANCED_PAII_TEXT;
			case 'mobilepay': return MODULE_PAYMENT_QUICKPAY_ADVANCED_MOBILEPAY_TEXT;
        }
        return '';
    }
public function sign($params, $api_key) {
    ksort($params);
   $base = implode(" ", $params);
 
   return hash_hmac("sha256", $base, $api_key);
 }
 
private function get_quickpay_order_status($order_id,$mode="") {

	$api= new QuickpayApi();
	

	$api->setOptions(MODULE_PAYMENT_QUICKPAY_ADVANCED_USERAPIKEY);

  try {
	$api->mode = ($mode=="" ? "payments?order_id=" : "subscriptions?order_id=");
	

    // Commit the status request, checking valid transaction id
    $st = $api->status(MODULE_PAYMENT_QUICKPAY_ADVANCED_AGGREEMENTID."_".sprintf('%04d', $order_id));
		$eval = array();
	if($st[0]["id"]){

    $eval["oid"] = str_replace(MODULE_PAYMENT_QUICKPAY_ADVANCED_AGGREEMENTID."_","", $st[0]["order_id"]);
	$eval["qid"] = $st[0]["id"];
	}else{
	$eval["oid"] = null;
	$eval["qid"] = null;	
	}
  
  } catch (Exception $e) {
   $eval = 'QuickPay Status: ';
		  	// An error occured with the status request
          $eval .= 'Problem: ' . $this->json_message_front($e->getMessage()) ;
		 //  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=' . $this->code, 'SSL'));
  }

    return $eval;
  } 

private function json_message_front($input){
	
	$dec = json_decode($input,true);
	
	$message= $dec["message"];

	return $message;
	
	
}
}

$paiioptions = array(
							''	   => '',
							'SC00' => 'Ringetoner, baggrundsbilleder m.v.',
							'SC01' => 'Videoklip og	tv',
							'SC02' => 'Erotik og voksenindhold',
							'SC03' => 'Musik, sange og albums',
							'SC04' => 'Lydb&oslash;ger	og podcasts',
							'SC05' => 'Mobil spil',
							'SC06' => 'Chat	og dating',
							'SC07' => 'Afstemning og konkurrencer',
							'SC08' => 'Mobil betaling',
							'SC09' => 'Nyheder og information',
							'SC10' => 'Donationer',
							'SC11' => 'Telemetri og service sms',
							'SC12' => 'Diverse',
							'SC13' => 'Kiosker & sm&aring; k&oslash;bm&aelig;nd',
							'SC14' => 'Dagligvare, F&oslash;devarer & non-food',
							'SC15' => 'Vin & tobak',
							'SC16' => 'Apoteker	og medikamenter',
							'SC17' => 'T&oslash;j, sko og accessories',
							'SC18' => 'Hus, Have, Bolig og indretning',
							'SC19' => 'B&oslash;ger, papirvare	og kontorartikler',
							'SC20' => 'Elektronik, Computer & software',
							'SC21' => '&Oslash;vrige forbrugsgoder',
							'SC22' => 'Hotel, ophold, restaurant, cafe & v&aelig;rtshuse, Kantiner og catering',
							'SC24' => 'Kommunikation og konnektivitet, ikke via telefonregning',
							'SC25' => 'Kollektiv trafik',
							'SC26' => 'Individuel trafik (Taxik&oslash;rsel)',
							'SC27' => 'Rejse (lufttrafik, rejser, rejser med ophold)',
							'SC28' => 'Kommunikation og konnektivitet, via telefonregning',
							'SC29' => 'Serviceydelser',
							'SC30' => 'Forlystelser og underholdning, ikke digital',
							'SC31' => 'Lotteri- og anden spillevirksomhed',
							'SC32' => 'Interesse- og hobby (Motion, Sport, udendørsaktivitet, foreninger, organisation)',
							'SC33' => 'Personlig pleje (Fris&oslash;r, sk&oslash;nhed, sol og helse)',
							'SC34' => 'Erotik og voksenprodukter(fysiske produkter)',
						);
	$options = '';	
	$paiique = tep_db_query("select configuration_value  from ".TABLE_CONFIGURATION. " WHERE configuration_key  =  'MODULE_PAYMENT_QUICKPAY_ADVANCED_PAII_CAT' ");
    $paiicat_values = tep_db_fetch_array($paiique);
    $selectedcat = $paiicat_values['configuration_value'];

	$option_array=array();	
foreach($paiioptions as $arrid => $val){
	 $option_array[] = array('id' => $arrid,
                              'text' => $val);
	 $selected ='';
	  if ($selectedcat == $arrid) {
        $selected = ' selected="selected"';
      }							
	 $options .= '<option value="'.$arrid.'" '.$selected.' >'.$val.'</option>';
}

  
  function tep_cfg_pull_down_paii_list($option_array) {
	 global $options;
    return "<select name='configuration[MODULE_PAYMENT_QUICKPAY_ADVANCED_PAII_CAT]' />
	".$options."	
	</select>";

  }



?> 