<?php
/**
 * -------------------
 * Metabox Extensions
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
 * Fxprotools core admin/theme settings
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
 * ----------------
 * Custom Functions
 * ----------------
 * Includes all custom functions
 */
$custom_functions = array(
	'function-helper', // All Helper functions
    'function-ajax',   // All Ajax Calls
    'function-custom', // All custom functions
    'function-cpt', // Custom post/taxonomy settings
    'function-mb',  // Metabox Settings
    'function-woocommerce', // Woocommerce Settings
    'function-wc-subscriptions', // WC Subscription settings,
    'function-email', // Email,
    'function-learndash' //Learndash LMS
);

if($custom_functions){
	foreach($custom_functions as $key => $cf){
		require_once('inc/'.$cf.'.php');
	}
}

/**
 * ------------------
 * FXprotools Modules
 * ------------------
 * Includes all third party libraries
 */
$modules = array(
    // ANET - Customer Informatio and Subscription Manager
    'authorize-net/auth-api',
    'authorize-net/auth-ajax',

    // Sendgrid - Contacts
    'sendgrid/sendgrid-api',
    'sendgrid/sendgrid-ajax',

    // APYC
    'apyc/init',

    // Walkers
    'walkers/nav-secondary-walker'
);

if($modules){
    foreach($modules as $key => $md){
        require_once('inc/modules/'.$md.'.php');
    }
}
