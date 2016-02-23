<?php

/*

  $Id: invoice.php,v 6.1 2005/06/05 00:37:30 PopTheTop Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

*/



  require('includes/application_top.php');



  require(DIR_WS_CLASSES . 'currencies.php');

  $currencies = new currencies();



  $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

  $orders_query = tep_db_query("select orders_id, customers_ean_number, customers_reference, cc_cardtype from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");

  $orders = tep_db_fetch_array($orders_query);

  

  include(DIR_WS_CLASSES . 'order.php');

  $order = new order($oID);

  $date = date('M d, Y');



  $customer_data_query = tep_db_query("select entry_company, entry_vat_number, entry_ean_number from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $order->customer['id'] . "'");

  $customer_data = tep_db_fetch_array($customer_data_query);

?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<title><?php echo STORE_NAME; ?> <?php echo INVOICE_TEXT_INVOICE; ?> <?php echo INVOICE_TEXT_NUMBER_SIGN; ?>&nbsp;<?php echo $oID; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<script type="text/javascript" src='includes/admin_comments_popup.js'></script>



</head>

<body margin="0" bgcolor="#FFFFFF">



<!-- body_text //-->



<table border="0" width="780" cellspacing="0" cellpadding="0">

  <tr style="height: 125px;">

    <td>

      

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td style="text-align: left; vertical-align: top; padding: 25px 10px 0px 15px;"><?php echo '<img src="' . INVOICE_IMAGE . '" border="0" alt="' . INVOICE_IMAGE_ALT_TEXT . '">'; ?></td>

          <td style="text-align: right; vertical-align: bottom; padding: 25px 15px 0px 10px;"><b><?php echo STORE_NAME; ?></b><br><?php echo STORE_ADDRESS; ?><br><?php if(STORE_ADDRESS_2 !='') echo STORE_ADDRESS_2 . '<br>'; ?><?php echo STORE_ADDRESS_ZIP . '&nbsp;' . STORE_ADDRESS_CITY; ?><br><?php if(STORE_VAT!='') echo INVOICE_TEXT_VAT . INVOICE_TEXT_COLON . ' ' . STORE_VAT; ?><br><br><b><?php echo INVOICE_TEXT_INVOICE; ?><?php echo INVOICE_TEXT_NUMBER_SIGN; ?><?php echo INVOICE_TEXT_COLON; ?><?php echo $oID; ?></b></td>

        </tr>

      </table>

      

    </td>

  </tr>

  <tr>

    <td style="height: 40px; vertical-align: top;">

    

      <table width="100%" border="0" cellspacing="0" cellpadding="2">

        <tr>

          <td width="10%"><hr size="2"></td>

          <td align="center"><h2><?php echo INVOICE_TEXT_INVOICE; ?></h2></td>

          <td width="100%"><hr size="2"></td>

        </tr>

      </table>

    

    </td>

  </tr>

  <tr>

    <td style="height: 125px; vertical-align: top; text-align: center;">

    

      <table width="90%" border="0" cellspacing="0" cellpadding="2">

        <tr>

		  <td style="vertical-align: top;">

          

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td align="left" valign="top"><h3><?php echo ENTRY_SOLD_TO; ?></h3></td>

              </tr>

              <tr>

                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>&nbsp;&nbsp;&nbsp;&nbsp;'); ?></td>

              </tr>

<?php

  if ($order->customer['vat_number'] != '') {

?>

              <tr>

                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ENTRY_VAT_NUMBER . ': ' . $order->customer['vat_number']; ?></td>

              </tr>

<?php

  }

?>

            </table>

      

          </td>

          <td><?php echo tep_draw_separator('pixel_trans.gif', '50', '10'); ?></td>

          <td style="vertical-align: top;">

    

            <table width="100%" border="0" cellpadding="0" cellspacing="0">

              <tr>

                <td align="left" valign="top"><h3><?php echo ENTRY_SHIP_TO; ?></h3></td>

              </tr> 

              <tr>

                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>&nbsp;&nbsp;&nbsp;&nbsp;'); ?></td>

              </tr>

            </table>



          </td>

        </tr>

      </table>

    

    </td>

  </tr>

		<tr>

		  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '100'); ?></td>

		</tr>

  <tr>

    <td style="height: 100%; vertical-align: top; text-align: center;">

	

      <table width="95%" border="0" cellpadding="0" cellspacing="0">

	    <tr>

	  	<td style="text-align: center;">

  

		  <table width="95%" border="0" cellpadding="0" cellspacing="0">

			<tr>

			  <td width="50%" valign="top">

			

				<table width="100%" border="0" cellpadding="0" cellspacing="0">

				  <tr>

					<td><?php echo INVOICE_TEXT_ORDER . INVOICE_TEXT_NUMBER_SIGN . INVOICE_TEXT_COLON . ' ' . tep_db_input($oID); ?></td>

				  </tr>

				  <tr>

					<td><?php echo INVOICE_TEXT_DATE_OF_ORDER . INVOICE_TEXT_COLON . ' ' . tep_date_short($order->info['date_purchased']); ?></td>

				  </tr>

				  <tr>

				    <td><?php echo INVOICE_PRINT_DATE . INVOICE_TEXT_COLON . strftime(DATE_FORMAT_SHORT); ?></td>

		          </tr>

				</table>

			

			  </td>

			  <td width="50%" align="right" valign="top">

					

				<table border="0" cellpadding="0" cellspacing="0">

	<?php

	  if ($orders['customers_ean_number'] != '') {

	?>

				  <tr>

					<td><?php echo ENTRY_EAN_NUMBER . ': ' . $orders['customers_ean_number']; ?></td>

				  </tr>

	<?php

	  }

	  if ($orders['customers_reference'] != '') {

	?>

				  <tr>

					<td><?php echo YOUR_REFERENCE . ' ' . $orders['customers_reference']; ?></td>

				  </tr>

	<?php

	  }

	?>

				  <tr>

	<?php
//quickpay changed start
		if ($order->info['cc_type']=="iBill" || $order->info['cc_type']=="viaBill"){

	?>				  

					<td valign="top"><?php echo ENTRY_PAYMENT_METHOD; ?> <?php echo $orders['cc_cardtype'].'<br>'.nl2br(DENUNCIATION); ?></td>

	<?php

	  } else {

	?>				  	

					<td valign="top"><?php echo ENTRY_PAYMENT_METHOD; ?> <?php echo $order->info['payment_method']; ?></td>

	<?php

	  }
//quickpay changed end
	?>				  

                  </tr>

				</table>

				

			  </td>

			</tr>

		  </table>



		</td>

		</tr>

		<tr>

		<td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

		</tr>

		<tr>

		<td> 

		  

		  <table border="0" width="100%" cellspacing="0" cellpadding="2">

			<tr class="dataTableHeadingRow">

              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>

			  <td class="dataTableHeadingContent" colspan="2" align="left"><?php echo TABLE_HEADING_PRODUCTS; ?></td>

			  <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>

			  <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>

			</tr>

	<?php

	   for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {

		   echo '        <tr class="dataTableRow">' . "\n" .

                '        <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n" .

			    '        <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .

			    '        <td class="dataTableContent" valign="top" align="left">' . $order->products[$i]['name'];



		  if (isset($order->products[$i]['attributes']) && (($k = sizeof($order->products[$i]['attributes'])) > 0)) {

			for ($j = 0; $j < $k; $j++) {

			  echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];

			  if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';

			  echo '</i></small></nobr>';

			}

		  }



          echo '          </td>' . "\n" .

			   '          <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .

			   '          <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";

		  echo '        </tr>' . "\n";

	   }

	?>

			<tr>

			  <td align="right" colspan="5">

			  

				<table border="0" cellspacing="0" cellpadding="0">

	<?php

	  for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {

		echo '              <tr>' . "\n" .

			 '                <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .

			 '                <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .

			 '              </tr>' . "\n";

	  }

	?>

				</table>

			

			  </td>

			</tr>

		  </table>

		  

		</td>

		</tr>

		<tr>

		  <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '50'); ?></td>

		</tr>

        <tr>

          <td align="center">

    

			<table width="95%" border="0" cellpadding="0" cellspacing="0">

<?php

			if ($order->info['cc_type']=="iBill" || $order->info['cc_type']=="ViaBill"){

?>

              <tr>

			    <td><?php echo nl2br(DENUNCIATION); ?></td>

			  </tr>

<?php

    }else{

?>

			  <tr>

				<td>

		<?php echo TEXT_BANK_TRANSFER . ' ' . BANK_NAME . ' ' . TEXT_BANK_REGISTRATION . ' ' . BANK_REGISTRATION_NUMBER . ' ' .TEXT_BANK_ACCOUNT . ' ' . BANK_ACCOUNT_NUMBER; ?>

				</td>

		      </tr>

			  <tr>

			    <td>

<!-- ORDER COMMENTS CODE STARTS HERE //-->

<div id="comments_open" style="position: relative;">

<?php 

    $orders_status_history_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . tep_db_input($oID) . "' and customer_notified='1' order by date_added");

    if (tep_db_num_rows($orders_status_history_query)) {

      $has_comments = false;

     echo '      <br><br>';

     echo '      <table width="100%" border="0" cellpadding="0" cellspacing="0">';

     echo '      <tr>';

     echo '      <td>';

     echo '             <table width="100%" border="0" cellpadding="0" cellspacing="0">';

     echo '                 <tr>';

     echo '                     <td align="center">';

     echo '                     <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main">';

     echo '                         <tr>';

     echo '                             <td width="100%">&nbsp;<h3>' . TABLE_HEADING_COMMENTS . '</h3></td>';

     echo '                         </tr>';



     while ($orders_comments = tep_db_fetch_array($orders_status_history_query)) {

         if (tep_not_null($orders_comments['comments'])) {

          $has_comments = true; // Not Null = Has Comments

          if (tep_not_null($orders_comments['comments'])) {

           $sInfo = new objectInfo($orders_comments);

           echo '                       <tr>';

           echo '                           <td align="center" width="95%">';

           echo '                           <table width="100%" border="0" cellpadding="0" cellspacing="0">';

           echo '                               <tr>';

           echo '                                 <td width="95%" class="smallText">';

           echo '                                   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main">';

           echo '                                      <tr>';

           echo '                                           <td width="100px" align="left" valign="top"><br>' . tep_date_short($sInfo->date_added) . '<br><br></td>';

           echo '                                           <td align="left"><br>' . nl2br(tep_db_output($orders_comments['comments'])) . '<br><br></td>';

           echo '                                      </tr>';

           echo '                                      <tr>';

           echo '                                           <td colspan="2">' . tep_draw_separator('pixel_silver.gif', '100%', '1') . '</td>';

           echo '                                      </tr>';

           echo '                                    </table>';

           echo '                                 </td>';

           echo '                              </tr>';

           echo '                           </table>';

           echo '                           </td>';

           echo '                       </tr>';

          }

       }

     }

     if ($has_comments == false) {

         echo '           <tr>';

         echo '            <td align="center" width="95%">';

         echo '            <table width="95%" border="0" cellpadding="0" cellspacing="0">';

         echo '             <tr>';

         echo '              <td width="95%" class="smallText">';

         echo '              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main">';

         echo '               <tr>';

         echo '                <td width="100%" align="left" valign="top" class="smallText">' . INVOICE_TEXT_NO_COMMENT . '</td>';

         echo '               </tr>';

         echo '              </table>';

         echo '              </td>';

         echo '             </tr>';

         echo '            </table>';

         echo '            </td>';

         echo '           </tr>';

     }

      echo '                        <tr>';

      echo '                            <td>' . tep_draw_separator('pixel_trans.gif', '1', '7') . '</td>';

      echo '                        </tr>';

      echo '                    </table>';

      echo '                    </td>';

      echo '                </tr>';

      echo '            </table>';

      echo '            </td>';

      echo '        </tr>';

      echo '      </table>';

    }

?>

<!-- ORDER COMMENTS CODE ENDS HERE //-->

                </td>

		      </tr>

<?php			  

	}

?>

			</table>

      

          </td>

        </tr>

      </table>

    </td>

  </tr>



  <tr>

  <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '50'); ?></td>

  </tr>  

  <tr>

    <td><CENTER><span class="smallText"><FONT FACE="Verdana"><strong><?php echo INVOICE_TEXT_THANK_YOU; ?> <?php echo STORE_NAME; ?><BR><?php echo STORE_URL_ADDRESS; ?></strong></font></span></CENTER></td>

  </tr>

</table>

<!-- body_text_eof //-->

</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
