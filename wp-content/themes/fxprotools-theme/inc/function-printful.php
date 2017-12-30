<?php

namespace CPS;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

if (!class_exists('CPS_Printful')) {

	class CPS_Printful {
		const OPTION_WC_PRINTFUL_KEY = 'woocommerce_printful_settings';
		const PRINTFUL_API_URL = 'https://api.printful.com/';

		/** @var string */
		private $api_key;
		/** @var Client */
		private $http_client;

		public function __construct() {
			$printful_options = get_option(self::OPTION_WC_PRINTFUL_KEY);
			$this->api_key = $printful_options['printful_key'];
			$this->set_client(new Client());
		}

		public function get_order ($order_number) {
			$order = '@' . $order_number;
			try {
				$printful_order = $this->get('order', $order);
				return $printful_order;
			} catch (GuzzleException $exception) {
				var_dump($exception->getMessage());
				error_log ($exception->getMessage());
			}
			return null;
		}

		/**
		 * @param string $endpoint
		 * @param string  $query
		 * @return mixed
		 * @throws GuzzleException
		 */
		public function get($endpoint, $query)
		{
			return $this->http_client->request('GET', self::PRINTFUL_API_URL . '/' . $endpoint . '/' . $query, [
				'Authorization' => ['Basic ' . $this->api_key],
			]);
		}

		/**
		 * Sets GuzzleHttp client.
		 *
		 * @param Client $client
		 */
		public function set_client($client)
		{
			$this->http_client = $client;
		}
	}
}

return new CPS_Printful();
