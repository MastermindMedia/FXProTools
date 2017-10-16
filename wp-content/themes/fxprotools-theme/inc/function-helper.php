<?php
/**
 * -----------------------------
 * Fxprotools - Helper Functions
 * -----------------------------
 * All helper functions
 */

// Styled Array
function dd($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function get_query_string()
{
	$string = '';
	$counter = 1;
	foreach($_GET as $key => $val){
		if($counter == 1){
			echo '?' . $key . '=' . $val;
		}else{
			echo '&' . $key . '=' . $val;
		}
		$counter++;
	}
	return $string;
}

