<?php

$lang = array(
	// payment gateways
	'merchant_2checkout'					=> '2Checkout',
	'merchant_authorize_net'				=> 'Authorize.Net AIM',
	'merchant_authorize_net_sim'			=> 'Authorize.Net SIM',
	'merchant_buckaroo'						=> 'Buckaroo',
	'merchant_cardsave'						=> 'Cardsave',
	'merchant_dps_pxpay'					=> 'DPS PaymentExpress PxPay',
	'merchant_dps_pxpost'					=> 'DPS PaymentExpress PxPost',
	'merchant_dummy'						=> 'Dummy',
	'merchant_eway'							=> 'eWay Hosted',
	'merchant_eway_shared'					=> 'eWay Shared',
	'merchant_eway_shared_uk'				=> 'eWay Shared (UK)',
	'merchant_ideal'						=> 'iDEAL',
	'merchant_inipay'						=> 'INIpay',
	'merchant_gocardless'					=> 'GoCardless',
	'merchant_manual'						=> 'Ręcznie',
	'merchant_mollie'						=> 'Mollie',
	'merchant_netaxept'						=> 'Nets Netaxept',
	'merchant_ogone_directlink'				=> 'Ogone DirectLink',
	'merchant_payflow_pro'					=> 'Payflow Pro',
	'merchant_paymate'						=> 'Paymate',
	'merchant_paypal_express'				=> 'PayPal Express',
	'merchant_paypal_pro'					=> 'PayPal Pro',
	'merchant_rabo_omnikassa'				=> 'Rabo OmniKassa',
	'merchant_sagepay_direct'				=> 'Sagepay Direct',
	'merchant_sagepay_server'				=> 'Sagepay Server',
	'merchant_stripe'						=> 'Stripe',
	'merchant_webteh_direct'				=> 'Webteh Direct',
	'merchant_worldpay'						=> 'WorldPay',

	// payment gateway settings
	'merchant_api_login_id'					=> 'API Login ID',
	'merchant_transaction_key'				=> 'Klucz transakcji',
	'merchant_test_mode'					=> 'Tryb testowy',
	'merchant_developer_mode'				=> 'Tryb deweloperski',
	'merchant_simulator_mode'				=> 'Tryb symulatora',
	'merchant_user_id'						=> 'Identyfikator użytkownika',
	'merchant_app_id'						=> 'App ID',
	'merchant_psp_id'						=> 'ID dostawcy usług płatniczych',
	'merchant_api_key'						=> 'Klucz API',
	'merchant_key'							=> 'Klucz',
	'merchant_key_version'					=> 'Wersja klucza',
	'merchant_username'						=> 'Nazwa użytkownika',
	'merchant_vendor'						=> 'Dostawca',
	'merchant_partner_id'					=> 'ID partnera',
	'merchant_password'						=> 'Hasło',
	'merchant_signature'					=> 'Podpis',
	'merchant_customer_id'					=> 'Identyfikator klienta',
	'merchant_merchant_id'					=> 'Identyfikator handlowca',
	'merchant_account_no'					=> 'Nr konta',
	'merchant_installation_id'				=> 'Identyfikator instalacji',
	'merchant_website_key'					=> 'Klucz strony',
	'merchant_secret_word'					=> 'Tajne słowo',
	'merchant_secret'						=> 'Sekret',
	'merchant_app_secret'					=> 'App Secret',
	'merchant_secret_key'					=> 'Secret Key',
	'merchant_token'						=> 'Token',
	'merchant_access_token'					=> 'Token dostępowy',
	'merchant_payment_response_password'	=> 'Hasło akceptacji płatności',
	'merchant_company_name'					=> 'Nazwa firmy',
	'merchant_company_logo'					=> 'Logo firmy',
	'merchant_page_title'					=> 'Tytuł Strony',
	'merchant_page_banner'					=> 'Baner strony',
	'merchant_page_description'				=> 'Opis Strony',
	'merchant_page_footer'					=> 'Stopka strony',
	'merchant_enable_token_billing'			=> 'Zachowaj dane karty do płatności z użyciem tokena',
	'merchant_paypal_email'					=> 'PayPal E-mail',
	'merchant_acquirer_url'					=> 'URL serwisu płatniczego',
	'merchant_public_key_path'				=> 'Ścieżka do Klucza Publicznego serwera',
	'merchant_private_key_path'				=> 'Ścieżka do Klucza Prywatnego serwera',
	'merchant_private_key_password'			=> 'Hasło Klucza Prywatnego',
	'merchant_solution_type'				=> 'Wymagane konto PayPal',
	'merchant_landing_page'					=> 'Karta wybranych metod płatniczych',
	'merchant_solution_type_mark'			=> 'Wymagane konto PayPal',
	'merchant_solution_type_sole'			=> 'Konto PayPal Opcjonalne',
	'merchant_landing_page_billing'			=> 'Zakończ transakcję jako gość / Utwórz konto',
	'merchant_landing_page_login'			=> 'Login konta PayPal',

	// payment gateway fields
	'merchant_card_type'					=> 'Typ karty',
	'merchant_card_no'						=> 'Numer karty',
	'merchant_name'							=> 'Nazwa',
	'merchant_first_name'					=> 'Imię',
	'merchant_last_name'					=> 'Nazwisko',
	'merchant_card_issue'					=> 'Numer karty kredytowej',
	'merchant_exp_month'					=> 'Data ważności miesiąc',
	'merchant_exp_year'						=> 'Data ważności rok',
	'merchant_start_month'					=> 'Początkowy miesiąc',
	'merchant_start_year'					=> 'Rok rozpoczęcia',
	'merchant_csc'							=> 'CSC',
	'merchant_issuer'						=> 'Wystawca',

	// status/error messages
	'merchant_insecure_connection'			=> 'Szczegóły karty muszą być wprowadzane przez połączenie szyfrowane (SSL).',
	'merchant_required'						=> 'Pole %s jest wymagane.',
	'merchant_invalid_card_no'				=> 'Numer karty jest nieprawidłowy.',
	'merchant_card_expired'					=> 'Karta jest nieaktualna.',
	'merchant_invalid_status'				=> 'Nieprawidłowy status płatności',
	'merchant_invalid_method'				=> 'Metoda nie obsługiwana przez bramkę.',
	'merchant_invalid_response'				=> 'Nieprawidłowa odpowiedź z bramki płatniczej.',
	'merchant_payment_failed'				=> 'Niepowodzenie płatności. Prosimy spróbować ponownie.',
	'merchant_payment_redirect'				=> 'Czekaj, przekierowanie do strony płatności...',
	'merchant_3dauth_redirect'				=> 'Proszę czekać... Przekierowujemy cię do wystawcy twojej karty w celu autentykacji...'
);

/* End of file ./language/english/merchant_lang.php */