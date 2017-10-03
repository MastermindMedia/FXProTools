<?php
require ABSPATH . 'vendor/autoload.php';

if(!class_exists('FX_Sendgrid')){

	class FX_Sendgrid {

		const SENDGRID_API_KEY = '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';
		
		public function __construct()
		{
			
		}	
		// Get all contacts of a list
		public function get_contacts($list_id)
		{
			$sg = new \SendGrid( self::SENDGRID_API_KEY );
			$query_params = json_decode('{"page": 1, "page_size": 1, }');
			$response = $sg->client->contactdb()->lists()->_($list_id)->recipients()->get(null, $query_params);
			return $response->body();
		}
	}
}
