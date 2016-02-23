<?php

/*

  $Id: orders.php,v 1.112 2003/06/29 22:50:52 hpdl Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

*/



  require('includes/application_top.php');

// quickpay added start

require('quickpay10/application_top_quickpay.php');

// quickpay added end



  require(DIR_WS_CLASSES . 'currencies.php');

  $currencies = new currencies();



// ************** SHOPEON.COM TRACKTRACE ADDED BEGIN ***********************

  include(DIR_FS_CATALOG . 'includes/classes/shopeon_tracktrace.php');

  include(DIR_FS_CATALOG_LANGUAGES . $language . '/shopeon_tracktrace.php');

  $shopeon_tracktrace = new ShopeonTrackTrace();

// ************** SHOPEON.COM TRACKTRACE ADDED END *************************



  $orders_statuses = array();

  $orders_status_array = array();

  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "'");

  while ($orders_status = tep_db_fetch_array($orders_status_query)) {

    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],

                               'text' => $orders_status['orders_status_name']);

    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];

  }



  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');



// quickpay added start

include('quickpay10/orders_actions.php');

// quickpay added end

  

  if (tep_not_null($action)) {

    switch ($action) {



      case 'update_order':

        $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

        $status = tep_db_prepare_input($HTTP_POST_VARS['status']);

        $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);

// ************** SHOPEON.COM TRACKTRACE ADDED BEGIN ***********************

        $valid_track_num = $shopeon_tracktrace->validateInput();

// ************** SHOPEON.COM TRACKTRACE ADDED END *************************



        $order_updated = false;

        $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");

        $check_status = tep_db_fetch_array($check_status_query);



// ************** SHOPEON.COM TRACKTRACE CHANGED BEGIN ***********************

        if ( ($check_status['orders_status'] != $status) || tep_not_null($comments) || $valid_track_num) {

// ************** SHOPEON.COM TRACKTRACE CHANGED END *************************

          tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$oID . "'");



          $customer_notified = '0';

          if (isset($HTTP_POST_VARS['notify']) && ($HTTP_POST_VARS['notify'] == 'on')) {

            $notify_comments = '';

            if (isset($HTTP_POST_VARS['notify_comments']) && ($HTTP_POST_VARS['notify_comments'] == 'on')) {

              $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";

            }

// ************** SHOPEON.COM TRACKTRACE ADDED BEGIN ***********************

            $notify_comments .= $shopeon_tracktrace->addEmailTracking();

// ************** SHOPEON.COM TRACKTRACE ADDED END *************************

            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);



            tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_NAME, STORE_EMAIL_ADDRESS);



            $customer_notified = '1';

          }



          tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$oID . "', '" . tep_db_input($status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments)  . "')");

// ************** SHOPEON.COM TRACKTRACE ADDED BEGIN ***********************

          $shopeon_tracktrace->updateTrackingId((int)$oID);

// ************** SHOPEON.COM TRACKTRACE ADDED END *************************



          $order_updated = true;

        }



        if ($order_updated == true) {

         $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');

        } else {

          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');

        }



        tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));

        break;

      case 'deleteconfirm':

        $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);



        tep_remove_order($oID, $HTTP_POST_VARS['restock']);



        tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action'))));

        break;

    }

  }



  if (($action == 'edit') && isset($HTTP_GET_VARS['oID'])) {

    $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);



    $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");

    $order_exists = true;

    if (!tep_db_num_rows($orders_query)) {

      $order_exists = false;

      $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');

    }

  }



  include(DIR_WS_CLASSES . 'order.php');

?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<script language="javascript" src="includes/general.js"></script>

<!-- quickpay added start //-->

<?php 

include('quickpay10/orders_js.php');

?>

<!-- quickpay added end //-->

</head>

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">

<!-- header //-->

<?php

  require(DIR_WS_INCLUDES . 'header.php');

?>

<!-- header_eof //-->



<!-- body //-->

<table border="0" width="100%" cellspacing="2" cellpadding="2">

  <tr>

    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">

<!-- left_navigation //-->

<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>

<!-- left_navigation_eof //-->

    </table></td>

<!-- body_text //-->



    <td width="100%" valign="top">



      <table border="0" width="100%" cellspacing="0" cellpadding="2">



<?php

  if (($action == 'edit') && ($order_exists == true)) {

    $order = new order($oID);

?>



      <tr>

      <td width="100%">



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

        <tr>

<!-- BOF PWA and Order Maker -->

        <td class="pageHeading"><?php echo '<a href="' . tep_href_link(FILENAME_CREATE_ORDER) . '"> Opret ny ordre </a>' . (($order->customer['id']==0)? ' <b> - Ikke registreret kunde</b>':''); ?></td>

<!-- EOF PWA and Order Maker -->

        <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>

<td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS_EDIT, 'oID=' . $_GET['oID']) . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a> '; ?></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">

          <tr>

            <td colspan="3"><?php echo tep_draw_separator(); ?></td>

          </tr>

          <tr>

            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">

              <tr>

                <td class="main" valign="top"><b><?php echo ORDER_ID; ?></b></td>

                <td class="main"><?php echo $oID; ?></td>

              </tr>

              <tr>

                <td class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>

                <td class="main"><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>'); ?></td>

              </tr>

              <tr>

                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>

              </tr>

              <tr>

                <td class="main"><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b></td>

                <td class="main"><?php echo $order->customer['telephone']; ?></td>

              </tr>

              <tr>

                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>

                <td class="main"><?php echo '<a href="mailto:' . $order->customer['email_address'] . '"><u>' . $order->customer['email_address'] . '</u></a>'; ?></td>

              </tr>

            </table></td>

            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">

              <tr>

                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>

                <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>'); ?></td>

              </tr>

            </table></td>

            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">

              <tr>

                <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>

                <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, '', '<br>'); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

      </tr>

      <tr>

        <td><table border="0" cellspacing="0" cellpadding="2">

          <tr>

            <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>

            <td class="main"><?php echo $order->info['payment_method']; ?></td>

          </tr>

<?php

// quickpay added start

include('quickpay10/orders_gui_admin.php');                                        

// quickpay added end

    if (tep_not_null($order->info['cc_type']) || tep_not_null($order->info['cc_owner']) || tep_not_null($order->info['cc_number'])) {

?>

          <tr>

            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

          </tr>

          <tr>

            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>

            <td class="main"><?php echo $order->info['cc_type']; ?></td>

          </tr>

          <tr>

            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>

            <td class="main"><?php echo $order->info['cc_owner']; ?></td>

          </tr>

          <tr>

            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>

            <td class="main"><?php echo $order->info['cc_number']; ?></td>

          </tr>

          <tr>

            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>

            <td class="main"><?php echo $order->info['cc_expires']; ?></td>

          </tr>

<?php

    }

?>

        </table></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

          <tr class="dataTableHeadingRow">

            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>

            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>

            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>

            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>

            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>

            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>

            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>

          </tr>

<?php

    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

      echo '          <tr class="dataTableRow">' . "\n" .

           '            <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .

           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['name'];



      if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {

        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {

          echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];

          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';

          echo '</i></small></nobr>';

        }

      }



      echo '            </td>' . "\n" .

           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n" .

           '            <td class="dataTableContent" align="right" valign="top">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .

           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .

           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true), true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .

           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .

           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";

      echo '          </tr>' . "\n";

    }

?>

          <tr>

            <td align="right" colspan="8"><table border="0" cellspacing="0" cellpadding="2">

<?php

    for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {

      echo '              <tr>' . "\n" .

           '                <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .

           '                <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .

           '              </tr>' . "\n";

    }

?>

            </table></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

      </tr>

      <tr>

        <td class="main"><table border="1" cellspacing="0" cellpadding="5">

          <tr>

            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>

            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>

            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>

            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>

          </tr>

<?php

// ************** SHOPEON.COM TRACKTRACE CHANGED BEGIN ***********************

    $orders_history_query = tep_db_query("select orders_status_id, date_added, customer_notified, comments, orders_status_history_id from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . tep_db_input($oID) . "' order by date_added");

// ************** SHOPEON.COM TRACKTRACE CHANGED END *************************

    if (tep_db_num_rows($orders_history_query)) {

      while ($orders_history = tep_db_fetch_array($orders_history_query)) {

        echo '          <tr>' . "\n" .

             '            <td class="smallText" align="center">' . tep_datetime_short($orders_history['date_added']) . '</td>' . "\n" .

             '            <td class="smallText" align="center">';

        if ($orders_history['customer_notified'] == '1') {

          echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";

        } else {

          echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";

        }

        echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n" .

// ************** SHOPEON.COM TRACKTRACE CHANGED BEGIN ***********************

             '            <td class="smallText">' . nl2br(tep_db_output($orders_history['comments'])) . $shopeon_tracktrace->showTrackingInfo($orders_history['orders_status_history_id']) . '&nbsp;</td>' . "\n" .

// ************** SHOPEON.COM TRACKTRACE CHANGED END *************************

             '          </tr>' . "\n";

      }

    } else {

        echo '          <tr>' . "\n" .

             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .

             '          </tr>' . "\n";

    }

?>

        </table></td>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '25'); ?></td>

      </tr>

      </tr>

<!-- BOF osc_Giftwrap -->

      <tr>

        <td class="main"><strong><?php echo TABLE_HEADING_GIFTWRAP; ?></strong><?php echo ($order->giftwrap['giftMethod']) ? (TEXT_GIFTWRAP_TRUE) : (TEXT_GIFTWRAP_FALSE); ?></td>

      </tr>

      <tr>

        <td class="main"><strong><?php echo TABLE_HEADING_GIFTCARD; ?></strong><?php echo ($order->giftwrap['giftCard']) ? (TEXT_GIFTCARD_TRUE) : (TEXT_GIFTCARD_FALSE); ?></td>

      </tr>

      <tr>

        <td class="main"><strong><?php echo TABLE_HEADING_GIFTMESSAGE; ?></strong><?php echo ($order->giftwrap['giftMessage']) ? ($order->giftwrap['giftMessage']) : (TEXT_GIFTMESSAGE_FALSE); ?></td>

      </tr>

<!-- EOF osc_Giftwrap -->	  

      <tr>

        <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>

      </tr>

      <tr><?php echo tep_draw_form('status', FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=update_order'); ?>

        <td class="main"><?php echo tep_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

      </tr>

<!-- ************** SHOPEON.COM TRACKTRACE ADDED BEGIN *********************** -->

      <?php $shopeon_tracktrace->showTrackingForm(); ?>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

      </tr>

<!-- ************** SHOPEON.COM TRACKTRACE ADDED END *********************** -->

      <tr>

        <td><table border="0" cellspacing="0" cellpadding="2">

          <tr>

            <td><table border="0" cellspacing="0" cellpadding="2">

              <tr>

                <td class="main"><b><?php echo ENTRY_STATUS; ?></b> <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>

              </tr>

              <tr>

                <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', true); ?></td>

                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo tep_draw_checkbox_field('notify_comments', '', true); ?></td>

              </tr>

            </table></td>

            <td valign="top"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>

          </tr>

        </table></td>

      </form></tr>

      <tr>

        <td colspan="2" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS_EDIT, 'oID=' . $_GET['oID']) . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a> '; ?></td>

      </tr>

<?php

  } else {

?>

      <tr>

        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

<!-- BOF Order Maker -->

            <td class="pageHeading"><?php echo HEADING_TITLE . '<a href="' . tep_href_link(FILENAME_CREATE_ORDER) . '"><br>Opret ny ordre</a>'; ?></td>

            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>

<!-- EOF Order Maker -->

            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">

<?php

// #### HURL CUSTOMER ORDER SEARCH ####

// create the text box and form for the customer search

?>

          <tr><?php echo tep_draw_form('customer_search', FILENAME_ORDERS, '', 'get'); ?>

            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH_CUSTOMER . tep_draw_input_field('custName', '', 'size="26"') . tep_draw_hidden_field('action', 'cust_search'); ?></td>

            </form>

		  </tr>

<?php

// #### EOF HURL CUSTOMER ORDER SEARCH ####

?>              <tr>

			  <?php echo tep_draw_form('orders', FILENAME_ORDERS, '', 'get'); ?>

                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH_ORDER_ID . ' ' . tep_draw_input_field('oID', '', 'size="26"') . tep_draw_hidden_field('action', 'edit'); ?></td>

              <?php echo tep_hide_session_id(); ?></form></tr>

              <tr><?php echo tep_draw_form('status', FILENAME_ORDERS, '', 'get'); ?>

                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH_ORDER_STATUS . ' ' . tep_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), '', 'onChange="this.form.submit();"style="width:178px;"'); ?></td>

              <?php echo tep_hide_session_id(); ?></form></tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr class="dataTableHeadingRow">

                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ORDER_ID; ?></td>

                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>

                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>

                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>

                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>

                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>

              </tr>

<?php

//--------------------------------------    

// #### HURL CUSTOMER ORDER SEARCH ####

// ### PRECONDITION: need order details based upon a customers first name and or last name

// ### POSTCONDITION: check for the get var custName -- new to this contrib

// if exists create an sql query based upon the customer name

// passed from said get var

//-------------------------------------

if(isset($HTTP_GET_VARS['custName'])){

	$custName = $HTTP_GET_VARS['custName'];

	$orders_query_raw = "select o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_name like '%".$custName."%' and ot.orders_id = o.orders_id and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' order by orders_id DESC";

}else{

	if (isset($HTTP_GET_VARS['cID'])) {

	      $cID = tep_db_prepare_input($HTTP_GET_VARS['cID']);

	      $orders_query_raw = "select o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$cID . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' order by orders_id DESC";

	    } elseif (isset($HTTP_GET_VARS['status']) && is_numeric($HTTP_GET_VARS['status']) && ($HTTP_GET_VARS['status'] > 0)) {

	      $status = tep_db_prepare_input($HTTP_GET_VARS['status']);

	      $orders_query_raw = "select o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.orders_status_id = '" . (int)$status . "' and ot.class = 'ot_total' order by o.orders_id DESC";

	    } else {

	      $orders_query_raw = "select o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' order by o.orders_id DESC";

	    }

}

// #### HURL CUSTOMER ORDER SEARCH ####



    $orders_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $orders_query_raw, $orders_query_numrows);

    $orders_query = tep_db_query($orders_query_raw);

    while ($orders = tep_db_fetch_array($orders_query)) {



// PWA BOF

    if ($orders['customers_id']==0) $orders['customers_name'] = '<b>!!</b> ' . $orders['customers_name'];

// PWA EOF



    if ((!isset($HTTP_GET_VARS['oID']) || (isset($HTTP_GET_VARS['oID']) && ($HTTP_GET_VARS['oID'] == $orders['orders_id']))) && !isset($oInfo)) {

        $oInfo = new objectInfo($orders);

      }



      if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {

        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '\'">' . "\n";

      } else {

        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '\'">' . "\n";

      }

?>

                <td class="dataTableContent" align="left"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . $orders['orders_id'] . '</a>'; ?></td>

                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $orders['customers_name']; ?></td>

                <td class="dataTableContent" align="right"><?php echo strip_tags($orders['order_total']); ?></td>

                <td class="dataTableContent" align="center"><?php echo tep_datetime_short($orders['date_purchased']); ?></td>

                <td class="dataTableContent" align="right"><?php echo $orders['orders_status_name']; ?></td>

                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>

              </tr>

<?php

    }

?>

              <tr>

                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">

                  <tr>

                    <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>

                    <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'oID', 'action'))); ?></td>

                  </tr>

                </table></td>

              </tr>

            </table></td>

<?php

  $heading = array();

  $contents = array();



  switch ($action) {

    case 'delete':

      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDER . '</b>');



      $contents = array('form' => tep_draw_form('orders', FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm'));

      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br><br><b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');

      $contents[] = array('text' => '<br>' . tep_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);

      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');

      break;

    default:

      if (isset($oInfo) && is_object($oInfo)) {

        $heading[] = array('text' => '<b>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . tep_datetime_short($oInfo->date_purchased) . '</b>');



		$contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '">' . tep_image_button('button_details.gif', IMAGE_DETAILS) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');

		// BOF Order Maker

		$contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>');

		$contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS_EDIT, 'oID=' . $oInfo->orders_id) . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_CREATE_ORDER) . '">' . tep_image_button('button_create_order.gif', IMAGE_CREATE_ORDER) . '</a>');

		// EOF Order Maker

		$contents[] = array('text' => '<br>' . TEXT_DATE_ORDER_CREATED . ' ' . tep_date_short($oInfo->date_purchased));

        if (tep_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . tep_date_short($oInfo->last_modified));

        $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENT_METHOD . ' '  . $oInfo->payment_method);

       // ### BEGIN ORDER MAKER ###

       $contents[] = array('text' => '<br>' . TEXT_INFO_CUSTOMER_SERVICE_ID . ' '  . $oInfo->customer_service_id);

       // ### END ORDER MAKER ###

      }

      break;

  }



  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {

    echo '            <td width="25%" valign="top">' . "\n";



    $box = new box;

    echo $box->infoBox($heading, $contents);



    echo '            </td>' . "\n";

  }

?>

          </tr>

        </table></td>

      </tr>

<?php

  }

?>

    </table></td>

<!-- body_text_eof //-->

  </tr>

</table>

<!-- body_eof //-->



<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->

<br>

</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
