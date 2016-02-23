<?php

/*

  $Id: information.php,v 1.6 2003/02/10 22:31:00 hpdl Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

*/

?>

<!-- information //-->

          <?php

$useragent = $_SERVER['HTTP_USER_AGENT'];

	if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {

    	?>

		<tr>

    	<td class="infoBoxContainer"> <?php

		}

else {



if (LAYOUT_COLUMN_LEFT_SHOW == "Ja")

	{

	$WIDTH = LAYOUT_COLUMN_LEFT_WIDTH;

	}

else {

	$WIDTH = LAYOUT_COLUMN_RIGHT_WIDTH;

	} 

?>

          <tr>

<td class="infoBoxContainer" width="<?php echo $WIDTH; ?>"> <?php

} ?>

<?php

  // Add-on - Information Pages Unlimited

  require_once(DIR_WS_FUNCTIONS . 'information.php');



  $info_box_contents = array();

  $info_box_contents[] = array('text' => BOX_HEADING_INFORMATION);



  new infoBoxHeading($info_box_contents, true, false);
//quickpay added start
			   
			   //display accepted payments. Use option creditcard (=all creditcards) OR specified cardtype locks
			    $msg = '';
			   //define payment icon width
			   $w= 35;
			   $h= 22;
			   $space = 2;
			        for ($i = 1; $i <= 5; $i++) {
            if (constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) == '') {
                continue;
            }
		
            $qty_groups++;
        }
	  for ($i = 1; $i <= 5; $i++) {
      if (defined('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) && constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i) != '') {
                $payment_options = preg_split('[\,\;]', constant('MODULE_PAYMENT_QUICKPAY_ADVANCED_GROUP' . $i));
                foreach ($payment_options as $option) {
              if($option=="creditcard"){
				  //You can extend the following cards-array and upload corresponding titled images to images/icons
				  $cards= array('dankort','visa','american-express','jcb','maestro','mastercard');
				      foreach ($cards as $optionc) {
			 				$iconc ="";
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".png") ? DIR_WS_ICONS.$optionc.".png": $iconc);
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".jpg") ? DIR_WS_ICONS.$optionc.".jpg": $iconc);
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".gif") ? DIR_WS_ICONS.$optionc.".gif": $iconc);   
				   
				   		$msg .= '<img src="'.$iconc.'" title="'.$optionc.'" width="'.$w.'" height="'.$h.'"  style="position:relative;border:0px;float:left;margin:'.$space.'px; " />';
				  // $msg .= tep_image($iconc,$optionc,$w,$h,'style="position:relative;border:0px;float:left;margin:'.$space.'px; " ');
					  }
			  }
			                if($option=="3d-creditcard"){
				  //You can extend the following cards-array and upload corresponding titled images to images/icons
				  $cards= array('3d-visa','3d-jcb','3d-maestro','3d-mastercard');
				      foreach ($cards as $optionc) {
			 				$iconc ="";
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".png") ? DIR_WS_ICONS.$optionc.".png": $iconc);
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".jpg") ? DIR_WS_ICONS.$optionc.".jpg": $iconc);
$iconc = (file_exists(DIR_WS_ICONS.$optionc.".gif") ? DIR_WS_ICONS.$optionc.".gif": $iconc);   
				   
				   		$msg .= '<img src="'.$iconc.'" title="'.$optionc.'" width="'.$w.'" height="'.$h.'"  style="position:relative;border:0px;float:left;margin:'.$space.'px; " />';				   

					  }
			  }



			  
			  if($option != "creditcard" && $option != "3d-creditcard"){
				  //upload images to images/icons corresponding to your chosen cardlock groups in your payment module settings
			 
			
			  $selectedopts = explode(",",$option);	
				foreach($selectedopts as $option){
				$icon ="";
$icon = (file_exists(DIR_WS_ICONS.$option.".png") ? DIR_WS_ICONS.$option.".png": $icon);
$icon = (file_exists(DIR_WS_ICONS.$option.".jpg") ? DIR_WS_ICONS.$option.".jpg": $icon);
$icon = (file_exists(DIR_WS_ICONS.$option.".gif") ? DIR_WS_ICONS.$option.".gif": $icon);   
$icon = (file_exists(DIR_WS_ICONS.$option."_payment.png") && $qty_groups == 1? DIR_WS_ICONS.$option."_payment.png": $icon); 				   
				   		//define payment icon width
		if(strstr($icon, "_payment")){
			$w=120;
			$h= 27;
			$space=9;
		}else{
			   $w= 35;
			   $h= 22;
			   $space=2;
			
		}
		$msg .= '<img src="'.$icon.'" title="'.str_replace("iBill","ViaBill",$option).'" width="'.$w.'" height="'.$h.'"  style="position:relative;border:0px;float:left;margin:'.$space.'px; " />';
				 //  $msg .= tep_image($icon,str_replace("iBill","ViaBill",$option),$w,$h,' style="position:relative;border:0px;float:left;margin:'.$space.'px; " ');
				
			  }
				
				}
				}
		   
		    }
			
        }
	
			  
			
	 //quickpay added end	


  $info_box_contents = array();

  $info_box_contents[] = array('text' =>  tep_information_show_category(1) .

                                         '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . BOX_INFORMATION_CONTACT . '</a>'
										 //quickpay added start	
										 .'<br><br>'.$msg
										 //quickpay added end

  );



  new infoBox($info_box_contents);

?>

            </td>

          </tr>

<!-- information_eof //-->
