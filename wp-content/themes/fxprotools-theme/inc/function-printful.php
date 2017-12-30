<?php

require_once 'modules/printful/vendor/autoload.php';

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

if (!class_exists('CPS_Printful')) {

	class CPS_Printful {
		const OPTION_WC_PRINTFUL_KEY = 'woocommerce_printful_settings';
		const PRINTFUL_API_URL = 'https://api.printful.com/';
		const PRINTFUL_API_ORDER_ENDPOINT = 'orders/';

		/** @var string */
		private $api_key;
		/** @var PrintfulApiClient */
		private $http_client;

		public function __construct() {
			$printful_options = get_option(self::OPTION_WC_PRINTFUL_KEY);
			$this->api_key = $printful_options['printful_key'];
			$this->set_client(new PrintfulApiClient($this->api_key));
		}

		public function get_order ($order_number) {
			$order = '@' . $order_number;
			try {
				return $this->http_client->get('orders/' . $order);
			} catch (PrintfulApiException $e) {
				var_dump($e->getMessage());
				error_log ('Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage());
			} catch (PrintfulException $e) {
				// API call failed
				var_dump($e->getMessage());
				error_log($this->http_client->getLastResponseRaw());
			}
			return null;
		}

		/**
		 * Sets PrintfulApiClient client.
		 *
		 * @param PrintfulApiClient $client
		 */
		private function set_client($client)
		{
			$this->http_client = $client;
		}
	}
}

return new CPS_Printful();
