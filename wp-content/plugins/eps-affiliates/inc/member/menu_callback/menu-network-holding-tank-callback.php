<?php
function afl_network_holding_tank () {
	echo afl_eps_page_header();
	
	echo afl_content_wrapper_begin();
		afl_get_template('plan/matrix/holding-tank.php');
	echo afl_content_wrapper_end();
}