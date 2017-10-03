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
	'core-admin-settings.php',
	'core-theme-settings.php',
    'core-woocommerce-settings.php'
];

foreach ($core_settings as $cs) {
    require_once('inc/core/'.$cs);
}

/**
 * ----------------
 * Custom Functions
 * ----------------
 * Includes all custom functions
 */
$custom_functions = array(
	'function-helper.php',
	'function-custom.php'
);

if($custom_functions){
	foreach($custom_functions as $key => $cf){
		require_once('inc/'.$cf);
	}
}

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



/** Meta Box for the Page Menu*/
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add()
{
    add_meta_box( 'menu_meta_box', 'Page Menu', 'cd_meta_box_cb', 'post', 'normal', 'high' );
}


function cd_meta_box_cb()
{
    ?>
    <label for="my_meta_box_text">Page Title: </label>
    <input type="text" name="my_meta_box_text" id="my_meta_box_text" />
    <label for="my_meta_box_text">Page: </label>
    <select>
        <option></option>
        <?php 
            $custom_query = new WP_Query( array( 'post_type' => 'post' ) );
            if($custom_query->have_posts()) :

                while ( $custom_query->have_posts() ) : $custom_query->the_post();
                echo '<option>'.get_the_title().'</option>';
                endwhile;
            endif;
        ?>
    </select>
    <?php         
}