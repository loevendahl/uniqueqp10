README for Quickpay Payment module protocol 10



Please contact kl@blkom.dk for questions, comments, feature requests and professional support.


ACKNOWLEDGEMENT
The Quickpay Standard Payment module was developed by Jakob Høy Biegel. This Module is in parts based
on the code of the Quickpay Standard Module.

Quickpay advanced payment module BETA 2 is developed by Cord Focke Rosted, mailbeez.com

Upgrades of Quickpay advanced payment module BETA 2 to Quickpay Advanced Payment module protocol 6,7 and 10 are made by Kim Løvendahl, kl@blkom.dk 2012/15.


IMPORTANT:
Using this module you acknowledge, that the Author can not be made responsible for any kind of damages, 
errors or problems caused by wrong or correct implementation of this module.


REQUIREMENTS:
You must have the following:
- Oscommerce 2.3 based webshop (might also work with version 2.2, but is not testet...)
- QuickPay Payment manager login (get it here: https://manage.quickpay.net).
- Credit card aquirer agreement. Could be Clearhaus, Nets and/or others. Must be set active in the Quickpay v10 manager.
- PHP version 5
- The php-extension Curl must be installed on your webserver and access to quickpay.net allowed by your web hosting provider (normally this is allowed) in order to use the module.

  
  
  
  
  
  
CONFIGURATION NOTES

You can access all necessary settings in the "integration" menu in your version 10 Quickpay manager (https://manage.quickpay.net)



INSTALL INSTRUCTIONS:


#####################################################################################
STEP 0
BACKUP BACKUP BACKUP BACKUP BACKUP and lastly BACKUP

IMPORTANT: Remove previous installations of Quickpay payment module and order total module. If any. This is NOT an upgrade.
For previous users of Quickpay v7: Fees are replaced by the setting of autofee or not in shop admin.
You can manage fees in the v10 Quickpay manager, where you will find extensive help and examples.

#####################################################################################
STEP 1

	*** no need for changes to the DB , everything is handled by installation script***


#####################################################################################
STEP 2

new files:
copy these files and folders to your webshop


	
	callback10.php
	includes/modules/payment/quickpay_advanced.php
    includes/languages/danish/modules/payment/quickpay_advanced.php	
	includes/languages/english/modules/payment/quickpay_advanced.php
	mediafiles/images/icons/
	kontrolpanel/quickpay10/application_top_quickpay.php
	kontrolpanel/quickpay10/orders_actions.php
	kontrolpanel/quickpay10/orders_gui_admin.php
	kontrolpanel/quickpay10/orders_js.php
	kontrolpanel/quickpay10/quickpay10.php
	kontrolpanel/images/
	includes/classes/QPConnectorCurl.php
	includes/classes/QPConnectorFactory.php
	includes/classes/QPConnectorInterface.php
	includes/classes/QuickpayApi.php
	

#####################################################################################
STEP 3 

modified files:
make sure your apply all modifications - marked with "quickpay..."

	checkout_process.php
	checkout_confirmation.php
	
	kontrolpanel/orders.php
	kontrolpanel/invoice.php
	kontrolpanel/modules.php
	kontrolpanel/includes/classes/order.php
	kontrolpanel/includes/classes/currencies.php
	kontrolpanel/includes/languages/danish/orders.php
	kontrolpanel/includes/languages/danish/invoice.php
	
	kontrolpanel/includes/languages/english/orders.php
	kontrolpanel/includes/languages/english/invoice.php
	includes/classes/order.php
	includes/classes/currencies.php
	includes/languages/danish.php
    includes/languages/english.php
    includes/boxes/information.php (adds payment icons)




#####################################################################################
  
#####################################################################################
STEP 4

Go into the Shop Administration->Modules->Payment.
If you have earlier versions of Quickpay installed, note any settings of cardlocks and remove the module.
Quickpay version 10 is not an upgrade and no Quickpay related settings from earlier versions are relevant.
New necessary settings can be found in the new manager application at https://manage.quickpay.net. under the section "integration"

install the module "Quickpay: Online Payment".


#####################################################################################
STEP 5

You can manage the online payment transaction from within the Quickpay manager or in your webshop Administration->Orders  

Test cards:

Visa
1000000000000008
Mastercard
1000010000000007
dankort
1000020000000006