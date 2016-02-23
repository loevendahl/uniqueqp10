<?php

/*

  $Id: checkout_confirmation.php,v 1.139 2003/06/11 17:34:53 hpdl Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

*/



  require('includes/application_top.php');



// if the customer is not logged on, redirect them to the login page

  if (!tep_session_is_registered('customer_id')) {

    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));

    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));

  }



// if there is nothing in the customers cart, redirect them to the shopping cart page

  if ($cart->count_contents() < 1) {

    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));

  }



// avoid hack attempts during the checkout procedure by checking the internal cartID

  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {

    if ($cart->cartID != $cartID) {

      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

    }

  }



// if no shipping method has been selected, redirect the customer to the shipping method selection page

  if (!tep_session_is_registered('shipping')) {

    tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, 'error_message=' . urlencode(ERROR_NO_SHIPPING_MODULE_SELECTED), 'SSL'));

  }



  if (!tep_session_is_registered('payment')) tep_session_register('payment');

  if (isset($HTTP_POST_VARS['payment'])) $payment = $HTTP_POST_VARS['payment'];



//Quickpay added

  if (!tep_session_is_registered('cardlock')) tep_session_register('cardlock');

  if (isset($_POST['cardlock'])) $cardlock = $_POST['cardlock'];

//Quickpay added end



  if (!tep_session_is_registered('comments')) tep_session_register('comments');

  if (tep_not_null($HTTP_POST_VARS['comments'])) {

    $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);

  }



    if (!tep_session_is_registered('reference')) tep_session_register('reference');

    if (tep_not_null($HTTP_POST_VARS['reference'])) {

      $reference = tep_db_prepare_input($HTTP_POST_VARS['reference']);

    }

	

// load the selected payment module

  require(DIR_WS_CLASSES . 'payment.php');

  if ($credit_covers) $payment=''; // CCGV

  $payment_modules = new payment($payment);

  require(DIR_WS_CLASSES . 'order_total.php'); // CCGV



  require(DIR_WS_CLASSES . 'order.php');

  $order = new order;

  

// if no shipping method has been selected, redirect the customer to the shipping method selection page

  if ((!$shipping)&&($order->content_type!='virtual')&&($order->content_type!='virtual_weight')){

    tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, 'error_message=' . urlencode(ERROR_NO_SHIPPING_MODULE_SELECTED), 'SSL'));

  }

  

  $payment_modules->update_status();

  $order_total_modules = new order_total;// CCGV

  $order_total_modules->collect_posts();// CCGV

  $order_total_modules->collect_posts();// CCGV

  $order_total_modules->pre_confirmation_check();//  CCGV



// Line edited for CCGV

//  if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {

// if ( (is_array($payment_modules->modules)) && (sizeof($payment_modules->modules) > 1) && (!is_object($$payment)) && (!$credit_covers) ) {

  if ( ($payment_modules->selected_module != $payment) || ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {



    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));

 



 }



  if (is_array($payment_modules->modules)) {

    $payment_modules->pre_confirmation_check();

  }







// load the selected shipping module

  require(DIR_WS_CLASSES . 'shipping.php');

  $shipping_modules = new shipping($shipping);



//Lines below repositioned for CCGV

//  require(DIR_WS_CLASSES . 'order_total.php');

//  $order_total_modules = new order_total;

//  $order_total_modules->process();



//BOF osc_Giftwrap

// load the selcted giftwrap module

  //require(DIR_WS_CLASSES . "gift.php");

  //$giftwrap_modules = new gift($giftwrap);

//EOF osc_Giftwrap



// Stock Check

  $any_out_of_stock = false;

  if (STOCK_CHECK == 'true') {

//++++ QT Pro: Begin Changed code

    $check_stock='';

    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

      if (isset($order->products[$i]['attributes']) && is_array($order->products[$i]['attributes'])) {

        $attributes=array();

        foreach ($order->products[$i]['attributes'] as $attribute) {

          $attributes[$attribute['option_id']]=$attribute['value_id'];

        }

        $check_stock[$i] = tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty'], $attributes);

      } else {

        $check_stock[$i] = tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty']);

      }

      if ($check_stock[$i]) {

        $any_out_of_stock = true;

      }

//++++ QT Pro: End Changed Code

    }

    // Out of Stock

    if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {

      tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));

    }

  }



  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_CONFIRMATION);



  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

  $breadcrumb->add(NAVBAR_TITLE_2);

?>



<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>

<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">

<link rel="stylesheet" type="text/css" href="stylesheet.css">

<meta name="robots" content="noindex, nofollow">

<?php

// QuickPay added start

// Must agree to terms

 ?>
 <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>
 $( document ).ready( function(){

$('input[name="agree"]').click(function(){
	if($(this).val() == 'true'){
		$(this).val('false');
		  
	  }else{
		     $(this).val('true');

	  }
	
	
});

$( "form[name='checkout_confirmation']" ).submit(function( event ) {
 // alert( "Handler for .submit() called." );
 	  if($('input[name="agree"]').val() == 'true'){
	    $('input[type="image"]').remove();
		$(this).submit();
		
		  
	  }else{
		     alert('<?php echo CONDITION_AGREEMENT_ERROR; ?>');

	  }
 
 
  event.preventDefault();
});

 });




</script>

<?php // Must agree to Terms end 

// QuickPay added end

?>

</head>



<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">



<!-- header //-->

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<!-- header_eof //-->



<!-- body //-->

    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="pageBody">

    <tr>



<?php

// added by GrafikStudiet

  if (LAYOUT_COLUMN_LEFT_SHOW == 'Ja') {

?>



    <td width="<?php echo LAYOUT_COLUMN_LEFT_WIDTH; ?>" valign="top" class="columnLeft">



      <table border="0" width="<?php echo LAYOUT_COLUMN_LEFT_WIDTH; ?>" cellspacing="0" cellpadding="0">



<!-- left_navigation //-->

<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>

<!-- left_navigation_eof //-->



      </table>



    </td>



<?php

  }

?>



<!-- body_text //-->



    <td width="100%" valign="top" class="columnCenter">



      <table border="0" width="100%" cellspacing="0" cellpadding="0" class="pageContents">

      <tr>

      <td class="pageContents">



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

        <tr>

        <td>



          <table border="0" width="100%" cellspacing="0" cellpadding="0" class="pageHeading">

          <tr>

          <td class="pageHeading"><h1><?php echo HEADING_TITLE; ?></h1></td>



<?php

// added by GrafikStudiet

  if (LAYOUT_SHOW_PAGE_HEADING_ICON == 'Ja') {

?>



          <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_confirmation.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>



<?php

  }

?>



          </tr>

          <tr>

          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>

          </tr>

          </table>



        </td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

        </tr>

        <tr>

        <td>



<?php

// start på statusbar

?>

          <table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

          <td width="20%">



            <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

            <td width="50%" align="right"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>

            <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>

            </tr>

            </table>



          </td>

          <td width="20%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>

          <td width="20%">



            <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

            <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>

            <td><?php echo tep_image(DIR_WS_IMAGES . 'checkout_bullet.gif'); ?></td>

            <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>

            </tr>

            </table>



          </td>

<?php

// QuickPay added start

if (strncmp($payment, 'quickpay', 8) == 0) { ?>

          <td width="20%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>

<?php }

// QuickPay added end

?>

          <td width="20%">



            <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

            <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>

            <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>

            </tr>

            </table>



          </td>

          </tr>

          <tr>

          <td align="center" width="20%" class="checkoutBarFrom"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '" class="checkoutBarFrom">' . CHECKOUT_BAR_DELIVERY . '</a>'; ?></td>

          <td align="center" width="20%" class="checkoutBarFrom"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '" class="checkoutBarFrom">' . CHECKOUT_BAR_PAYMENT . '</a>'; ?></td>

          <td align="center" width="20%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>



<?php

// QuickPay added start

if (strncmp($payment, 'quickpay', 8) == 0) { ?>

          <td align="center" width="20%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_ONLINE_PAYMENT; ?></td>

<?php }

// QuickPay added start

?>



          <td align="center" width="20%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_FINISHED; ?></td>

          </tr>

          </table>



<?php

// slut på statusbar

?>



        </td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>

        </tr>

        <tr>

        <td>



          <table border="0" width="90%" cellspacing="0" cellpadding="0">

          <tr>



<!-- Leveringsadresse -->



          <td width="50%" class="mainNoWidth" valign="top">



<?php

  if ($sendto != false) {

?>



            <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

<!-- PWA BOF CHANGE-->

            <td class="main">

                <?php 

                echo '<b>' . HEADING_DELIVERY_ADDRESS . '</b>';

                if (preg_match('/gls_(?P<gls_shopid>\d+)/', $shipping['id'], $matches)){

                    echo ' <a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">(<span class="orderEdit">' . TEXT_EDIT . '</span>)</a>';

                } else {

                    echo (($customer_id>0 || (defined('PURCHASE_WITHOUT_ACCOUNT_SEPARATE_SHIPPING') && PURCHASE_WITHOUT_ACCOUNT_SEPARATE_SHIPPING=='yes') )? ' <a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">(<span class="orderEdit">' . TEXT_EDIT . '</span>)</a>':''); 

                }   ?>

            </td>

            </tr>

<!-- PWA EOF -->

            <tr>

            <td class="main">

                <?php 

                if (preg_match('/gls_(?P<gls_shopid>\d+)/', $shipping['id'], $matches)){

                    $delivery_address = 'GLS pakkeshop<br>Shop ID '.$matches['gls_shopid']; // just in case there is no answer from gls website

                    

                    //require(DIR_WS_CLASSES . 'gls_webservice.php');

                    $gls_webservice = new GLSWebservice;

                    $pakkeshop_available = $gls_webservice->searchNearestParcelShops($order->delivery['street_address'], $order->delivery['postcode'], MODULE_SHIPPING_GLS_PAKKESHOP_LIMIT);

                    if ($pakkeshop_available) {

                        $pakkeshop = array();

                        for ($i=0; $i<count($pakkeshop_available); $i++) {

                            reset($pakkeshop);

                            $pakkeshop = array_map("utf8_decode", $pakkeshop_available[$i]); 

                            if ($matches['gls_shopid'] == $pakkeshop['Number']) {

                                $delivery_address = $pakkeshop['CompanyName']. '<br>'.

                                                    $pakkeshop['Streetname2']  . '<br>'.

                                                    $pakkeshop['Streetname'] . '<br>'.

                                                    $pakkeshop['ZipCode'].' '.$pakkeshop['CityName'] . '<br>';

                            }

                        }

                    }

                    echo $delivery_address;

                } else {

                    echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>');

                }   ?>

            </td>

            </tr>

            </table>



<?php

  }

?>



          </td>



<!-- Slut på leveringsadresse -->

<!-- Faktureringsadresse -->



          <td width="50%" clss="mainNoWidth">



            <table border="0" cellspacing="0" cellpadding="0">

            <tr>

<!-- PWA BOF CHANGE -->

            <td class="main"><?php echo '<b>' . HEADING_BILLING_ADDRESS . '</b> <a href="' . (($customer_id==0)?tep_href_link(FILENAME_CREATE_ACCOUNT, 'guest=guest', 'SSL'):tep_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL')) . '">(<span class="orderEdit">' . TEXT_EDIT . '</span>)</a>'; ?></td>

            </tr>

<!-- PWA EOF -->

            <tr>

            <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>'); ?></td>

            </tr>

            </table>



          </td>



<!-- Slut på faktureringsadresse -->



          </tr>

          </table>



        </td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('listseperator.gif', '100%', '1'); ?></td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>

        </tr>

        <tr>

        <td class="main">



          <table border="0" width="100%" cellspacing="1" cellpadding="2">

          <tr>

          <td class="main"><?php echo '<b>' . HEADING_ORDER_REFERENCE . '</b>'; ?></td>

          </tr>

          <tr>

          <td class="main"><?php echo nl2br(tep_output_string_protected($order->info['reference'])) . tep_draw_hidden_field('reference', $order->info['reference']); ?></td>

          </tr>

          </table>



        </td>

        </tr>

        <tr>

        <td>



<!-- produkter -->



          <table border="0" width="100%" cellspacing="0" cellpadding="3">



<?php

  if (sizeof($order->info['tax_groups']) > 1) {

?>



          <tr>

          <td class="main"><?php echo '<b>' . HEADING_PRODUCTS . '</b> <a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">(<span class="orderEdit">' . TEXT_EDIT . '</span>)</a>'; ?></td>

          <td class="smallText" align="right"><b><?php echo HEADING_TAX; ?></b></td>

          <td class="smallText" align="right"><b><?php echo HEADING_TOTAL; ?></b></td>

          </tr>



<?php

  } else {

?>



<!-- Produktliste -->



          <tr>

          <td class="main" colspan="3"><?php echo '<b>' . HEADING_PRODUCTS . '</b> <a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">(<span class="orderEdit">' . TEXT_EDIT . '</span>)</a>'; ?></td>

          </tr>

          <tr>

          <td width="50" align="right" class="infoBoxHeading"><?php echo HEADING_PRODUCTS_QTY; ?></td>

          <td class="infoBoxHeading"><?php echo HEADING_PRODUCTS_NAME; ?></td>

          <td align="right" class="infoBoxHeading"><?php echo HEADING_PRODUCTS_PRICE; ?></td>

          </tr>



<?php

  }



  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

    echo '          <tr>' . "\n" .

         '          <td align="right" width="50" class="mainNoWidth">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .

         '          <td class="main" valign="top">' . $order->products[$i]['name'];



    if (STOCK_CHECK == 'true') {

//++++ QT Pro: Begin Changed code

      echo $check_stock[$i];

//++++ QT Pro: End Changed Code

    }



    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {

      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {

        echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';

      }

    }



    echo '          </td>' . "\n";



    if (sizeof($order->info['tax_groups']) > 1) echo '          <td class="main" valign="top" align="right">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";



    echo '          <td class="main" align="right" valign="top">' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . '</td>' . "\n" .

         '          </tr>' . "\n";

  }

?>

          </table>



        </td>



<!-- Slut på produktliste -->



        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_black.gif', '100%', '1'); ?></td>

        </tr>

        <tr>



<!-- Ordretotal -->



        <td class="main" align="right">



          <table border="0" cellspacing="0" cellpadding="2">



<?php

  if (MODULE_ORDER_TOTAL_INSTALLED) {

    $order_total_modules->process();

    echo $order_total_modules->output();

  }

?>



          </table>



        </td>



<!-- Slut på ordretotal -->



        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('listseperator.gif', '100%', '1'); ?></td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>

        </tr>



<!-- Kommentar -->



<?php

  if (tep_not_null($order->info['comments'])) {

?>

        <tr>

        <td class="main">



          <table border="0" width="100%" cellspacing="1" cellpadding="2">

          <tr>

          <td class="main"><?php echo '<h3>' . HEADING_ORDER_COMMENTS . '</h3> <a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '">(<span class="orderEdit">' . TEXT_EDIT . '</span>)</a>'; ?></td>

          </tr>

          <tr>

          <td class="main"><?php echo nl2br(tep_output_string_protected($order->info['comments'])) . tep_draw_hidden_field('comments', $order->info['comments']); ?></td>

          </tr>

          </table>



        </td>

        </tr>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '50'); ?></td>

        </tr>



<?php

  }

?>



<!-- Slut kommentar -->

<!-- BOF osc_Giftwrap -->

<?php

  //require(DIR_WS_CLASSES . 'gift.php');

  //$giftwrap_modules = new gift;



  if (strlen($order->info['giftwrap_method'])>1) {

?>

          	 <tr>

			   <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

             </tr>

              <tr>

                <td><h3><?php echo HEADING_GIFTWRAP_METHOD; ?></h3></td>

              </tr>

              <tr>

                <td><?php echo $order->info['giftwrap_method']; ?></td>

              </tr>



	<!-- show whether giftcard is selected  -->

	<?php

		if ($order->info['giftwrap_card']){

	?>

              <tr>

                <td><h3><?php echo HEADING_GIFTWRAP_CARD; ?></h3></td>

              </tr>

              <tr>

                <td><?php echo TEXT_GIFTWRAP_CARD ?></td>

              </tr>



              <!-- if giftcard is selected -->

              <tr>

                <td><h3><?php echo HEADING_GIFTWRAP_MESSAGE; ?></h3></td>

              </tr>

              <tr>

                <td><?php echo ($giftwrap_message)?$giftwrap_message:TEXT_GIFTWRAP_NO_MESSAGE; ?></td>

              </tr>

<?php

		}

	}

?>

<!-- EOF osc_Giftwrap -->

<!-- Forsendelsesmåde -->



<?php

    if ($order->info['shipping_method']) {

?>

        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '25'); ?></td>

        </tr>

        <tr>

        <td class="main">



          <table border="0" cellspacing="0" cellpadding="0">

          <tr>

          <td><?php echo '<h3>' . HEADING_SHIPPING_METHOD . '</h3>'; ?></td>

          </tr>

          <tr>

          <td><?php echo $order->info['shipping_method'] . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">(<span class="orderEdit">' . TEXT_EDIT . '</span>)</a>'; ?></td>

          </tr>

          </table>



        </td>

        </tr>

<?php

    }

?>

<!-- Slut på forsendelses måde -->        

        

		<tr>

		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '25'); ?></td>

        </tr>

        <tr>

        <td>



          <table border="0" cellspacing="0" cellpadding="0">

          <tr>

          <td><?php echo '<h3>' . HEADING_PAYMENT_METHOD . '</h3>'; ?></td>

          </tr>

		  <tr>

          <td><?php echo $order->info['payment_method'] . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>

          </tr>

		  </table>

		  

		</td>

        </tr>



<?php

  if (is_array($payment_modules->modules)) {

    if ($confirmation = $payment_modules->confirmation()) {

?>



        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

        </tr>

        <tr>

        <td class="main"><b><?php echo HEADING_PAYMENT_INFORMATION; ?></b></td>

        </tr>

        <tr>

        <td class="main"><?php echo $confirmation['title']; ?></td>

        </tr>



<?php

     for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {

?>



        <tr>

        <td>



          <table border="0" cellspacing="0" cellpadding="2">

          <tr>

          <td class="main"><?php echo $confirmation['fields'][$i]['title']; ?></td>

          <td class="main"><?php echo $confirmation['fields'][$i]['field']; ?></td>

          </tr>

          </table>



       </td>

       </tr>



<?php

      }

    }

  }

?>



        <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '25'); ?></td>

        </tr>

        <td class="main">



          <table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

          <td align="right" class="main">



<?php

// QuickPay changed start

// Must Agree start

?>

          <tr>

          <td class="main"><?php echo '<h3>' . HEADING_RETURN_POLICY . '</h3> <a href="' . tep_href_link('popup_terms.php', '', 'SSL') . '" target="_blank">(<span class="orderEdit">' . TEXT_VIEW . '</span>)</a>'; ?></td>

          </tr>

          <tr>

          <td>



            <table border="0" width="100%" cellspacing="0" cellpadding="0">




            <tr>

            <td><?php echo TEXT_RETURN_POLICY; ?><td>

            </tr>

            <tr>

            <td>



              <table border="0" width="100%" cellspacing="1" cellpadding="2">

              <tr >

              <td class="main" align="left"><?php echo ACCEPT_CONDITIONS; ?>&nbsp;<?php echo tep_draw_checkbox_field('agree','false', false); ?></td>

              </tr>

              </table>



            </td>

            </tr>

            <tr>

            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

            </tr>

            <tr>

            <td align="right">



<?php

  if (isset($$payment->form_action_url)) {

    $form_action_url = $$payment->form_action_url;

  } else {

    $form_action_url = tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');

  }





  echo tep_draw_form('checkout_confirmation', $form_action_url, 'post');



            if (is_array($payment_modules->modules)) {

              echo $payment_modules->process_button();

            }
          
            if (strncmp($payment, 'quickpay', 8) == 0) {
              //echo '<input type="submit" value="'.IMAGE_BUTTON_PBSCC_ORDER.'" >';
           echo tep_image_submit('button_pbscc_order.gif', IMAGE_BUTTON_PBSCC_ORDER);
            
            } else {

              echo tep_image_submit('button_confirm_order.gif', IMAGE_BUTTON_CONFIRM_ORDER);

            }
        echo '</form>' . "\n";
        

// Must Agree end

// QuickPay changed end

?>



            </td>

            </tr>

            </table>



          </td>

          </tr>

          </table>



        </td>

        </tr>

        </table>



      </td>

      </tr>

      </table>



    </td>

<!-- body_text_eof //-->



<?php

// added by GrafikStudiet

  if (LAYOUT_COLUMN_RIGHT_SHOW == 'Ja') {

?>



    <td width="<?php echo LAYOUT_COLUMN_RIGHT_WIDTH; ?>" valign="top" class="columnRight">



      <table border="0" width="<?php echo LAYOUT_COLUMN_RIGHT_WIDTH; ?>" cellspacing="0" cellpadding="0">



<!-- right_navigation //-->

<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>

<!-- right_navigation_eof //-->



      </table>



    </td>



<?php

  }

?>

    </tr>

    </table>

<!-- body_eof //-->



<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->



</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>