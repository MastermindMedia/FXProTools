<?php
/**
 * -------------------
 * Metabox Extesntions
 * -------------------
 * Force Loading of metabox plugin and extensions
 */
$mb_extenstions = array(
    // Core Plugin
    'meta-box.php',
    // Extensions
    'extensions/mb-admin-columns/mb-admin-columns.php',
    'extensions/mb-settings-page/mb-settings-page.php',
    'extensions/mb-term-meta/mb-term-meta.php',
    'extensions/meta-box-builder/meta-box-builder.php',
    'extensions/meta-box-columns/meta-box-columns.php',
    'extensions/meta-box-conditional-logic/meta-box-conditional-logic.php',
    'extensions/meta-box-group/meta-box-group.php',
    'extensions/meta-box-include-exclude/meta-box-include-exclude.php',
    'extensions/meta-box-show-hide/meta-box-show-hide.php',
    'extensions/meta-box-tabs/meta-box-tabs.php',
    // 'extensions/meta-box-template/meta-box-template.php',
    'extensions/meta-box-tooltip/meta-box-tooltip.php',
);

if($mb_extenstions){
    foreach ($mb_extenstions as $key => $ext) {
        require_once('inc/core/meta-box/'.$ext);
    }
}

/**
 * -------------------
 * FXprotools Settings
 * -------------------
 * Fxprotools admin/theme settings
 */

// Set the theme version number as a global variable
$theme          = wp_get_theme('fxprotools-theme');
$theme_version	= $theme['Version'];
$core_settings = [
	'core-admin-settings',
	'core-theme-settings',
];

foreach ($core_settings as $cs) {
    require_once('inc/core/'.$cs.'.php');
}

/**
 * ---------------
 * Settings MB/CPT
 * ---------------
 * Settings for custom post/taxonomy and metabox
 */
$settings = array(
    'settings-cpt', // Custom post/taxonomy settings
    'settings-mb',  // Metabox Settings
    'settings-woocommerce',  // Woocommerce Settings
    'settings-wc-subscriptions', //WC Subscription settings
);

if($settings){
    foreach ($settings as $key => $setting) {
        require_once('inc/settings/'.$setting.'.php');
    }
}

/**
 * ----------------
 * Custom Functions
 * ----------------
 * Includes all custom functions
 */
$custom_functions = array(
	'function-helper', // All Helper functions
	'function-custom', // All custom functions
    'function-ajax'    // All ajax calls
);

if($custom_functions){
	foreach($custom_functions as $key => $cf){
		require_once('inc/'.$cf.'.php');
	}
}

/**
 * --------------
 * Sendgrid - Contacts 
 * --------------
 * Sendgrid gateway class
 */

$sendgrid = array(
    'sendgrid-api', 
    'sendgrid-ajax',  
);
if($sendgrid){
    foreach($sendgrid as $key => $sg){
        require_once('inc/sendgrid/'.$sg.'.php');
    }
}

/**
Added by Allan / APYC
**/
require_once plugin_dir_path( __FILE__ ) . 'inc/Apyc/init.php';
/**
Added by Allan / APYC

/**
 * ---------------------------------------------------
 * ANET - Customer Informatio and Subscription Manager
 * ---------------------------------------------------
 * Authorize.net customer information and subscription manager
 */
// $anet_includes = [
	// 'auth-api.php',
	// 'auth-ajax.php',
// ];
// foreach ($anet_includes as $a) {
// 	require_once('inc/authorize-net/'.$a);
// }

/**
 * --------------
 * ANET - Payment 
 * --------------
 * Authorize.net payment gateway class
 */
//require('inc/fx-authorize-net/fx-authorize-net.php');