<?php

function afl_network_direct_uplines () {
		echo afl_eps_page_header();
		afl_content_wrapper_begin();
			afl_network_direct_uplines_callback();
		afl_content_wrapper_end();
}

function afl_network_direct_uplines_callback () {
		wp_register_style( 'zig-zag-timeline-cs',  EPSAFFILIATE_PLUGIN_ASSETS.'plugins/zigzag-timeline/Zigzagtimeline.css');
		wp_enqueue_style( 'zig-zag-timeline-cs' );
		afl_get_template('plan/matrix/member-direct-uplines.php');
}