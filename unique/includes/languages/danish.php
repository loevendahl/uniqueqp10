<?php
/*
  $Id: english.php,v 1.114 2003/07/09 18:13:39 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'da_DK.ISO_8859-1');

define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'DKK');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="da"');

// charset for web pages and emails
define('CHARSET', 'iso-8859-1');

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_YOU_ARE_HERE', 'Du er her: ');
define('HEADER_TITLE_CREATE_ACCOUNT', 'Opret konto');
define('HEADER_TITLE_MY_ACCOUNT', 'Indstillinger og oversigter');
define('HEADER_TITLE_CART_CONTENTS', 'Vis indkøbskurv');
define('HEADER_TITLE_CHECKOUT', 'Bestil');
define('HEADER_TITLE_TOP', 'Top');
define('HEADER_TITLE_CATALOG', 'Forside');
define('HEADER_TITLE_LOGOFF', 'Log af');
define('HEADER_TITLE_LOGIN', 'Log ind');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'sidevisninger siden');

// text for gender
define('MALE', 'Mand');
define('FEMALE', 'Kvinde');
define('MALE_ADDRESS', 'Hr.');
define('FEMALE_ADDRESS', 'Fru');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Produkter');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Producenter');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Nyheder');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Søg');
define('BOX_SEARCH_TEXT', 'Indtast søgeord<br>eller gå til');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Avanceret søgning');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Tilbud');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Anmeldelser');
define('BOX_REVIEWS_WRITE_REVIEW', 'Skriv en anmeldelse af dette produkt!');
define('BOX_REVIEWS_NO_REVIEWS', 'Der er endnu ikke skrevet nogen anmeldelser af dette produkt');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s af 5 stjerner!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Indkøbskurv');
define('BOX_SHOPPING_CART_EMPTY', 'Indkøbskurven er tom');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Tidligere køb');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Mest populære');
define('BOX_HEADING_BESTSELLERS_IN', 'Mest populære i<br>&nbsp;&nbsp;');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Adviseringer');
define('BOX_NOTIFICATIONS_NOTIFY', 'Underret mig når der er opdateringer til <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Jeg ønsker ikke længere at modtage opdateringer om <b>%s</b>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Producentinfo');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s hjemmeside');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Andre produkter');

// languages box text in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Sprog');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Valuta');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_INFORMATION_ABOUT', 'Om ' . STORE_NAME);
define('BOX_INFORMATION_PRIVACY', 'Fortrolighed');
define('BOX_INFORMATION_PAYMENT', 'Betaling');
define('BOX_INFORMATION_SHIPPING', 'Forsendelse');
define('BOX_INFORMATION_RETURN', 'Returpolitik');
define('BOX_INFORMATION_CONDITIONS', 'Handelsbetingelser');
define('BOX_INFORMATION_CONTACT', 'Kontakt');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Fortæl en ven');
define('BOX_TELL_A_FRIEND_TEXT', 'Fortæl en du kender om dette produkt.');

// Newsletters & subscribers
define('BOX_HEADING_NEWSLETTER', 'Nyhedsbrev');
define('BOX_NEWSLETTERS_SIGNUP', 'Modtag gode tilbud og nyheder på e-mail.');
define('BOX_NEWSLETTERS_CLICK_HERE', 'Klik her for at til- eller afmelde dig nyhedsbrevet');
define('BOX_NEWSLETTERS_REGISTERED_USER', '<i><b>Registreret bruger?</b><br>Klik her!</i>');
define('BOX_NEWSLETTER_TEXT_EMAIL', 'E-mail:');
define('BOX_NEWSLETTERS_TEXT_FIRSTNAME', 'Fornavn:');
define('BOX_NEWSLETTERS_TEXT_LASTNAME', 'Efternavn:');
define('BOX_NEWSLETTERS_SUBMIT', 'Tilmeld');

// Customer Service infobox
define('BOX_CUSTOMER_SERVICE_PHONE_US', 'Har du spørgsmål kan du kontakte os på:');
define('BOX_CUSTOMER_SERVICE_EMAIL_US', 'eller sende en e-mail til:<br>');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Levering');
define('CHECKOUT_BAR_PAYMENT', 'Betaling og fakturering');
define('CHECKOUT_BAR_CONFIRMATION', 'Godkend');
define('CHECKOUT_BAR_FINISHED', 'Færdig!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Vælg venligst');
define('TYPE_BELOW', 'Skriv nedenfor');

// javascript messages
define('JS_ERROR', 'Der opstod en fejl under behandlingen af dine oplysninger.\n\nRet venligst følgende:\n\n');

define('JS_REVIEW_TEXT', '* \'Produktanmeldelser\' skal være på mindst ' . REVIEW_TEXT_MIN_LENGTH . ' tegn.\n');
define('JS_REVIEW_RATING', '* Du skal vurdere det produkt du anmelder.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Vælg venligst en betalingsmetode.\n');

define('JS_ERROR_SUBMITTED', 'Oplysningerne er afsendt! Klik venligst på OK og vent.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Vælg venligst en betalingsmetode.');

define('CATEGORY_COMPANY', 'Firma oplysninger');
define('CATEGORY_PERSONAL', 'Dine oplysninger');
define('CATEGORY_ADDRESS', 'Din adresse');
define('CATEGORY_CONTACT', 'Kontaktinformation');
define('CATEGORY_OPTIONS', 'Nyhedsbrev (valgfrit)');
define('CATEGORY_PASSWORD', 'Dit password');

define('ENTRY_COMPANY', 'Firmanavn:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_VAT_NUMBER', 'CVR-nummer:');
define('ENTRY_EAN_NUMBER', 'EAN-nummer:');
define('ENTRY_VAT_NUMBER_TEXT_2', '');
define('ENTRY_EAN_NUMBER_TEXT_2', '');
define('ENTRY_GENDER', 'Køn:');
define('ENTRY_GENDER_ERROR', 'Du skal angive køn');
define('ENTRY_GENDER_TEXT', '');
define('ENTRY_FIRST_NAME', 'Fornavn:');
define('ENTRY_FIRST_NAME_ERROR', 'Der findes ingen danske navne der er så korte, fornavnet skal være minimum ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' bogstaver.');
define('ENTRY_FIRST_NAME_TEXT', '');
define('ENTRY_LAST_NAME', 'Efternavn:');
define('ENTRY_LAST_NAME_ERROR', 'Dit efternavn skal bestå af mindst ' . ENTRY_LAST_NAME_MIN_LENGTH . ' tegn.');
define('ENTRY_LAST_NAME_TEXT', '');
define('ENTRY_DATE_OF_BIRTH', 'Fødselsdag:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Du skal angive din fødselsdato i følgende formatt: MM/DD/YYYY (f.eks. 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', ' (f.eks. 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail adresse:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Din e-mail er for kort! Den skal bestå af minimum ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' tegn.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Din E-mail adresse ser ikke ud til at være gyldig, kontroler den venligst og foretag de nødvendige ændringer.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Der findes allerede en konto der benytter denne e-mail adresse - Log venligst ind på din konto eller opret en konto med en anden adresse.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '');
define('ENTRY_STREET_ADDRESS', 'Adresse:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Gadenavnet ser ud til at være for kort det skal bestå af mindst ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' tegn.');
define('ENTRY_STREET_ADDRESS_TEXT', '');
define('ENTRY_SUBURB', ' ');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Postnummer:');
define('ENTRY_POST_CODE_ERROR', 'Der ser ud til at være en fejl i dit postnummer, det skal være mindst ' . ENTRY_POSTCODE_MIN_LENGTH . ' tegn.');
define('ENTRY_POST_CODE_TEXT', '');
define('ENTRY_CITY', 'By:');
define('ENTRY_CITY_ERROR', 'By skal bestå af mindst ' . ENTRY_CITY_MIN_LENGTH . ' tegn.');
define('ENTRY_CITY_TEXT', '');
define('ENTRY_STATE', 'Landsdel:');
define('ENTRY_STATE_ERROR', 'Stat/region skal bestå af mindst ' . ENTRY_STATE_MIN_LENGTH . ' tegn.');
define('ENTRY_STATE_ERROR_SELECT', 'Vælg venligst en stat fra dropdownmenuen.');
define('ENTRY_STATE_TEXT', '');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_COUNTRY_ERROR', 'Vælg et land fra dropdown listen.');
define('ENTRY_COUNTRY_TEXT', '');
define('ENTRY_TELEPHONE_NUMBER', 'Telefon:');
define('ENTRY_TELEPHONE_FETCH_ADDRESS', 'Hent adresse');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Dit telefonnummer skal bestå af mindst ' . ENTRY_TELEPHONE_MIN_LENGTH . ' tegn.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '');
define('ENTRY_FAX_NUMBER', 'Fax:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Ja tak! Jeg vil gerne modtage nyheder og gode tilbud på e-mail');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Tilmeldt');
define('ENTRY_NEWSLETTER_NO', 'Fravalgt');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Adgangskode:');
define('ENTRY_PASSWORD_ERROR', 'Din adgangskode er for kort! Det skal bestå af minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' tegn.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'De indtastede passwords er ikke ens!');
define('ENTRY_PASSWORD_TEXT', '');
define('ENTRY_PASSWORD_CONFIRMATION', 'Bekræft adgangskode:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '');
define('ENTRY_PASSWORD_CURRENT', 'Nuværende password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Dit password er for kort! Det skal bestå af minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' tegn.');
define('ENTRY_PASSWORD_NEW', 'Nyt password:');
define('ENTRY_PASSWORD_NEW_TEXT', '');
define('ENTRY_PASSWORD_NEW_ERROR', 'Dit nye password er for kort! Det skal bestå af minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' tegn.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'De indtastede passwords er ikke ens.');
define('PASSWORD_HIDDEN', '--SKJULT--');

define('FORM_REQUIRED_INFORMATION', 'Alle felter skal udfyldes');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Viser <b>%d</b> til <b>%d</b> (af <b>%d</b> produkter)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Viser<b>%d</b> til <b>%d</b> (af <b>%d</b> ordre)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Viser <b>%d</b> til <b>%d</b> (of <b>%d</b> anmeldelser)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Viser <b>%d</b> til <b>%d</b> (af <b>%d</b> nye produkter)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Viser <b>%d</b> til <b>%d</b> (af <b>%d</b> tilbud)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Første side');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', '< Forrige');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Næste >');
define('PREVNEXT_TITLE_LAST_PAGE', 'Sidste side >>');
define('PREVNEXT_TITLE_PAGE_NO', 'Side %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Forrige sæt af %d sider');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Næste sæt af %d sider');
define('PREVNEXT_BUTTON_FIRST', '<< Første side');
define('PREVNEXT_BUTTON_PREV', '< Forrige');
define('PREVNEXT_BUTTON_NEXT', 'Næste >');
define('PREVNEXT_BUTTON_LAST', 'Sidste side >>');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Tilføj adresse');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Adressebog');
define('IMAGE_BUTTON_BACK', 'Tilbage');
define('IMAGE_BUTTON_BUY_NOW', 'Bestil');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Skift adresse');
define('IMAGE_BUTTON_CHECKOUT', 'Send ordre');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Bekræft din ordre');
define('IMAGE_BUTTON_CONTINUE', 'Fortsæt');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Fortsæt med at handle');
define('IMAGE_BUTTON_DELETE', 'Slet');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Ret dine oplysninger');
define('IMAGE_BUTTON_HISTORY', 'Kontooversigt');
define('IMAGE_BUTTON_LOGIN', 'Log ind');
define('IMAGE_BUTTON_IN_CART', 'Læg i indkøbskurv');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Adviseringer');
define('IMAGE_BUTTON_QUICK_FIND', 'Hurtig søgning');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Fjern adviseringer');
define('IMAGE_BUTTON_REVIEWS', 'Anmeldelser');
define('IMAGE_BUTTON_SEARCH', 'Søg');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Forsendelse');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Tip en ven');
define('IMAGE_BUTTON_UPDATE', 'Opdater');
define('IMAGE_BUTTON_UPDATE_CART', 'Opdater indkøbskurv');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Skriv anmeldelse');

define('SMALL_IMAGE_BUTTON_DELETE', 'Slet');
define('SMALL_IMAGE_BUTTON_EDIT', 'Rediger');
define('SMALL_IMAGE_BUTTON_VIEW', 'Vis');

define('ICON_ARROW_RIGHT', 'Mere');
define('ICON_CART', 'Vis indkøbskurv');
define('ICON_ERROR', 'Fejl');
define('ICON_SUCCESS', 'Gennemført');
define('ICON_WARNING', 'Advarsel');

define('TEXT_GREETING_PERSONAL', 'Du er logget ind som <span class="greetUser">%s!</span><br><br><a href="%s"><b>Klik her</b></a> for at se en liste over nye produkter siden dit sidste besøg.');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s, please <a href="%s"><u>log yourself in</u></a> with your account information.</small>');
define('TEXT_GREETING_GUEST', 'Velkommen til ' . STORE_NAME . ' Ønsker du at <a href="%s"><u>logge ind</u></a>? eller <a href="%s"><u> oprette en konto</u></a>?');

define('TEXT_SORT_PRODUCTS', 'Sorter produkter ');
define('TEXT_DESCENDINGLY', 'fladende');
define('TEXT_ASCENDINGLY', 'stigende');
define('TEXT_BY', ' af ');

define('TEXT_QUANTITY', 'Antal:');

define('TEXT_REVIEW_BY', 'af %s');
define('TEXT_REVIEW_WORD_COUNT', '%s ord');
define('TEXT_REVIEW_RATING', 'Bedømmelse: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Tilføjet den: %s');
define('TEXT_NO_REVIEWS', 'Der er endnu ingen anmeldelser.');

define('TEXT_NO_NEW_PRODUCTS', 'Der er i øjeblikket ingen nye produkter.');

define('TEXT_UNKNOWN_TAX_RATE', 'Ukendt momssats');

define('TEXT_REQUIRED', '<span class="errorText">Påkrævet</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>TEP ERROR:</small> Kan ikke sende mailen gennem den angivne SMTP server. Kontroler indstillingerne i php.ini er korrekte, og ret SMTP server oplysningerne hvis nødvendigt.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'ADVARSEL: Installationsmappen: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. findes stadig dette er et sikkerhedsproblem, slet eller omdøb mappen.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Advarsel: Der kan skrives til konfigurationsfilen: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Dette udgør en potentiel sikkerhedsrisiko - Sæt venligst de rigtige rettigheder på filen.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Advarsel: Der findes ikke et sessions bibliotek: ' . tep_session_save_path() . '. Indtil dette bliver oprettet vil Sessions ikke virke.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Advarsel: Der kan ikke skrives til sessions biblioteket: ' . tep_session_save_path() . '. Sessions vil ikke kunne bruges før der bliver sat de rigtige brugerrettigheder.');
define('WARNING_SESSION_AUTO_START', 'Advarsel: session.auto_start er aktiveret - Deaktiver venligst denne php feature in php.ini og genstart webserveren.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Advarsel: Biblioteket til downloadprodukter findes ikke: ' . DIR_FS_DOWNLOAD . '. Produkt download vil ikke virke før dette er oprettet.');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Den oplyste udløbsdato for betalingskortet er ugyldig.<br>Kontroler venligst oplysningerne og prøv igen.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Det oplyste kortnummer er ugyldigt.<br>Kontroler venligst oplysningerne og prøv igen.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'De første 4 cifre i kortnummeret er angivet til: %s<br>Hvis dette nummer er korrekt kan vi desværre ikke modtage denne type kort. .<br>Hvis der er fejl i det indtastede bedes du rette det og prøve igen.');
if (FOOTER_SHOW_COMPANY_DETAILS == 'Ja') {
// Ændret af Whiskydepotet.dk for at skjule ikke indtastede data
	$FOOTER_TEXT_BODY = array();
	$FOOTER_TEXT_BODY2 = array();
	if (STORE_NAME !=''){$FOOTER_TEXT_BODY[] = STORE_NAME;}
	if (STORE_ADDRESS !=''){$FOOTER_TEXT_BODY[] = STORE_ADDRESS;}
	if (STORE_ADDRESS_2 !=''){$FOOTER_TEXT_BODY[] = STORE_ADDRESS_2;}
	if (STORE_ADDRESS_ZIP !='' and STORE_ADDRESS_CITY !=''){$FOOTER_TEXT_BODY[] = STORE_ADDRESS_ZIP . ' ' . STORE_ADDRESS_CITY;}
	else {
	if (STORE_ADDRESS_ZIP !=''){$FOOTER_TEXT_BODY[] = STORE_ADDRESS_ZIP;}
	if (STORE_ADDRESS_CITY !=''){$FOOTER_TEXT_BODY[] = STORE_ADDRESS_CITY;}}
	if (STORE_VAT !=''){$FOOTER_TEXT_BODY[] = 'CVR nummer: ' . STORE_VAT;}
	if (STORE_EMAIL_ADDRESS !='') {$FOOTER_TEXT_BODY2[] = 'E-mailadresse: ' . STORE_EMAIL_ADDRESS;}
	if (STORE_PHONE_COUNTRY_CODE !='' and STORE_PHONE !='') {$FOOTER_TEXT_BODY2[] = 'Telefon: ' . STORE_PHONE_COUNTRY_CODE . ' ' . STORE_PHONE;}
	else {
	if (STORE_PHONE_COUNTRY_CODE =='' and STORE_PHONE !='') {$FOOTER_TEXT_BODY2[] = 'Telefon: ' . STORE_PHONE;}}	
	if (STORE_PHONE_COUNTRY_CODE !='' and STORE_FAX !='') {$FOOTER_TEXT_BODY2[] = 'Fax: ' . STORE_PHONE_COUNTRY_CODE . ' ' . STORE_FAX;}
	else {
	if (STORE_PHONE_COUNTRY_CODE =='' and STORE_FAX !='') {$FOOTER_TEXT_BODY2[] = 'Fax: ' . STORE_FAX;}}
	$S_FOOTER_TEXT_BODY = implode("&nbsp;|&nbsp;", $FOOTER_TEXT_BODY);
	$S_FOOTER_TEXT_BODY2 = implode("&nbsp;|&nbsp;", $FOOTER_TEXT_BODY2);
	define('FOOTER_TEXT_BODY',$S_FOOTER_TEXT_BODY . '<BR>' . $S_FOOTER_TEXT_BODY2);
	// define('FOOTER_TEXT_BODY', STORE_NAME . '&nbsp;|&nbsp;' . STORE_ADDRESS . '&nbsp;|&nbsp;' . STORE_ADDRESS_ZIP . '&nbsp;' . STORE_ADDRESS_CITY . '&nbsp;|&nbsp;CVR nummer: ' . STORE_VAT . '<br>E-mailadresse: ' . STORE_EMAIL_ADDRESS . '&nbsp;|&nbsp;Telefon: ' . STORE_PHONE);
// Slut på ændring
} else {
define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y') . ' <a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . STORE_NAME . '</a><br>Denne shop er bygget på <a href="http://www.uniquefree.dk" target="_blank">Unique Free</a>, et gratis <a href="http://www.oscommerce.com" target="_blank">osCommerce</a> baseret webshopsystem.');
}
require(DIR_WS_LANGUAGES . 'add_ccgvdc_danish.php');  // CCGV
// ################# Contribution Newsletter v050 ##############

// subscribers box text in includes/boxes/subscribers.php
define('BOX_HEADING_SUBSCRIBERS', 'Nyhedsbrev');
define('BOX_TEXT_SUBSCRIBE', 'Tilmeld');
define('BOX_TEXT_UNSUBSCRIBE', 'Frameld');
define('TEXT_EMAIL_HTML','HTML');
define('TEXT_EMAIL_TXT','TXT');
define('TEXT_EMAIL','E-mailadresse:');
define('TEXT_EMAIL_FORMAT','Format');

define('TEXT_NAME', 'Dit navn:');
// Unsubscribe
define('UNSUBSCRIBE_TEXT','Afmeld: ');
// ################# Contribution Newsletter v050 ##############
// QuickPay added start
define('CHECKOUT_BAR_ONLINE_PAYMENT', 'Online betaling');
define('IMAGE_BUTTON_PBSCC_ORDER', 'Online betaling');
define('DENUNCIATION', 'Ordren betales via iBill Flex fakturabetaling. Det skyldige beløb kan alene betales med frigørende virkning til iBill, som fremsender særskilt opkrævning. Betaling kan ikke ske ved modregning af krav, der udspringer af andre retsforhold');
// QuickPay added end
define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'BEMÆRK: Webshoppen lukkes ned på grund af opdateringer - time period (mm/dd/yy) (hh-hh): ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'BEMÆRK: Webshoppen er i øjeblikket lukket ned for offentligheden, husk at sætte den online når du er færdig');

define('CLICK_TO_ENLARGE', '<i>Vis stort billede</i>');
define('READ_MORE', '...<i>læs mere</i>');
// Article Manager
define('BOX_HEADING_ARTICLES', 'Artikler');
define('BOX_ALL_ARTICLES', 'Alle artikler');
define('BOX_NEW_ARTICLES', 'Nye artikler');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Viser <b>%d</b> til <b>%d</b> (af <b>%d</b> artikler)');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW', 'Viser <b>%d</b> til <b>%d</b> (af <b>%d</b> nye artikler)');
define('TEXT_ARTICLES', 'Listen nedenfor viser de nyeste artikler først.');  
define('TABLE_HEADING_AUTHOR', 'Forfatter');
define('TABLE_HEADING_ABSTRACT', 'Sammendrag');
define('BOX_HEADING_AUTHORS', 'Aftikler skrevet af');
define('NAVBAR_TITLE_DEFAULT', 'Artikler');
// BOF: More Pics 6
define('CLOSE_POPUP', 'Luk vindue');
define('MORE_PIC', 'Screenshots');
// EOF: More Pics 6
define('TEXT_WE_ACCEPT', 'Vi modtager');
define('VAT_NUMBER', 'CVR-nummer');
define('EAN_NUMBER', 'EAN-nummer');
define('PHONE_NUMBER', 'Telefon');
define('EMAIL_ADDRESS', 'E-mail');
define('TEXT_PRODUCT_CATEGORY', 'Kategori:');

define('TEXT_SHIPPING', 'Forsendelse');

// Tekst til Print my invoice
define('TEXT_CLICK_TO_VIEW_STATUS', 'Klik her for at se status på din ordre eller downloade købte produkter.');
define('TEXT_BANK_TRANSFER', 'Hvis du har valgt at betale via bankoverførsel bedes ovenstående beløb overført til vores konto i ');
define('TEXT_BANK_REGISTRATION', 'registreringsnummer: ');
define('TEXT_BANK_ACCOUNT', 'kontonummer: ');

//
define('TEXT_PRICE_PER_PCS', 'pr. stk.');
define('TEXT_PRICE_PER', 'stk.');

define('TEXT_LOG_IN_TO_SEE_PRICE', 'Log ind for at se pris');
/*** Begin All Products SEO ***/
define('BOX_INFORMATION_ALLPRODS_SEO_CATEGORIES', 'Vis alle produkter');
define('BOX_INFORMATION_ALLPRODS_SEO_SPECIALS', 'Vis alle tilbud');
define('BOX_INFORMATION_ALLPRODS_SEO_WHATSNEW', 'Vis nyeste produkter');
/*** End All Products SEO ***/
define('TEXT_ALL_CATEGORIES', 'Alle kategorier');
define('TEXT_ALL_MANUFACTURERS', 'Alle producenter');

//SIMPLE GALLERY start
 define('BOX_HEADING_GALLERY', 'Galleri'); 
 define('TEXT_GALLERY', 'Se nogle af brugernes billeder');
 define('BOX_TEXT_GALLERY_LINK', '<a href="gallery_user.php">Tilføj dine egne billeder</a>');
 define('BOX_SLIDESHOW_MAX_THUMBS','25');
 define('BOX_GALLERY_TOOLTIP','Gå til galleriet');
//SIMPLE GALLERY end

// PostDanmark hack
$post_dk_text[1] = 'PostDanmark (pakkepost)';
$post_dk_text[2] = 'Post Danmark (økonomipakke)';
$post_dk_text[3] = 'Post Danmark (maxibrev)';
define('GLS_SHOP_ORDER_TOTAL_TEXT', 'Fragt');

define('IN_STOCK', 'På lager');
define('OUT_OF_STOCK', 'Ikke på lager');

define('TABLE_HEADING_FEATURED_PRODUCTS', 'Udvalgte produkter');
?>