<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Conf
|--------------------------------------------------------------------------
|
| DONT CHANGE THIS CONFIG!
|
| $config['access_secret'] = 'SgVkYp3s6v9y$B&E)H@MbQeThWmZq4t7';
| $config['refresh_secret'] = '4t7w!z$C&F)J@NcRfUjXn2r5u8x/A?D*';
|
*/
if (ENVIRONMENT == 'production') {
    $config['access_secret'] = 'SgVkYp3s6v9y$B&E)H@MbQeThWmZq4t7';
    $config['refresh_secret'] = '4t7w!z$C&F)J@NcRfUjXn2r5u8x/A?D*';
} else {
    $config['access_secret'] = 'SgVkYp3s6v9y$B&E)H@MbQeThWmZq4t7';
    $config['refresh_secret'] = '4t7w!z$C&F)J@NcRfUjXn2r5u8x/A?D*';
}

/*
|--------------------------------------------------------------------------
| App Info
|--------------------------------------------------------------------------
*/

$config['app_name'] = 'PSI';

/*
|--------------------------------------------------------------------------
| Xendit
|--------------------------------------------------------------------------
*/
if (ENVIRONMENT == 'production') {
	# example :
    $config['xendit_secret_key'] = 'xxx';
    $config['xendit_callback_token'] = 'xxx';
    $config['xendit_success_redirect_url'] = 'https://xxx.id/payment/success';
} else {
	# example :
    $config['xendit_secret_key'] = 'xxx';
    $config['xendit_callback_token'] = 'xxx';
    $config['xendit_success_redirect_url'] = 'https://xxx.id/payment/success';
}


/*
|--------------------------------------------------------------------------
| Email
|--------------------------------------------------------------------------
*/

$config['email_base_config'] = [
    'useragent' => 'PSIMailer',
    'protocol' => 'smtp',
    'smtp_host' => 'localhost',
    'smtp_port' => 25,
    'smtp_user' => '',
    'smtp_pass' => '',
    'crlf' => "\r\n",
    'newline' => "\r\n",
    'mailtype' => 'html'
];
$config['email_sender_noreply'] = ['noreply@psi.id', 'psi'];
$config['email_cs'] = 'cs@psi.co.id';
$config['email_developer'] = ['halfawi1703@gmail.com'];
$config['email_logo_url'] = 'https://cdn.skynet.alternatecreative.id/production/assets/images/logo-hantaran-colored-square-round.png';

/*
|--------------------------------------------------------------------------
| File
|--------------------------------------------------------------------------
*/
if (ENVIRONMENT == 'production') {
	# example : 
    $config['file_assets_path_url'] = 'https://cdn.skynet.alternatecreative.id/production/assets/';
    $config['file_upload_path_url'] = 'https://cdn.skynet.alternatecreative.id/production/uploads/';
} else {
	# example : 
    $config['file_assets_path_url'] = 'https://cdn.skynet.alternatecreative.id/production/assets/';
    $config['file_upload_path_url'] = 'https://cdn.skynet.alternatecreative.id/production/uploads/';
}

/*
|--------------------------------------------------------------------------
| Google FCM
|--------------------------------------------------------------------------
*/
if (ENVIRONMENT == 'production') {
	# example : 
    $config['google_fcm_server_key'] = 'AAAAiz879M8:APA91bFmTKUpbHOE8JFdHzbHI0wE8k57s1ujyk-M_9n8QSPNFB-tWbWgaeFpjt30tmEyEH5mJn28zPs7-rG08Pf4eNzqs7ZnBS9RIr_U57-GxQbG0U2MeW-yYt8nuV_uVdGsp-p9r90n';
} else {
	# example : 
    $config['google_fcm_server_key'] = 'AAAAiz879M8:APA91bFmTKUpbHOE8JFdHzbHI0wE8k57s1ujyk-M_9n8QSPNFB-tWbWgaeFpjt30tmEyEH5mJn28zPs7-rG08Pf4eNzqs7ZnBS9RIr_U57-GxQbG0U2MeW-yYt8nuV_uVdGsp-p9r90n';
}


/*
|--------------------------------------------------------------------------
| Meta Site
|--------------------------------------------------------------------------
*/
$config['meta_title'] = 'Primasis';
$config['meta_description'] = '';
$config['meta_keyword'] = '';
$config['theme_color'] = '#FF9426';

/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/
$config['api_host'] = 'http://localhost:8080/damage-detection/api/';
