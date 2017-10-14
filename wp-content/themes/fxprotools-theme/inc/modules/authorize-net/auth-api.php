<?php
/**
 * -----------------------
 * Authorize.net Functions
 * -----------------------
 * Authorize.net API functions
 */

require  $_SERVER['DOCUMENT_ROOT'] . '/fxprotools/vendor/autoload.php';
	
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('AuthAPI')){

	class AuthAPI {
		
		// Account 1 - volishon
		const AUTHORIZENET_API_LOGIN_ID = '54g7ndfYHDA';
		const AUTHORIZENET_TRANSACTION_KEY = '3qW3tc776AC4YzA3';

		// Account 1 - volishon
		// const AUTHORIZENET_API_LOGIN_ID = '2nnPd9yFA34';
		// const AUTHORIZENET_TRANSACTION_KEY = '45BH9L8HgP6m3hyM';

		// Get all users
		public function get_all_users()
		{
			$merchantAuthentication = $this->anet_authentication(self::AUTHORIZENET_API_LOGIN_ID, self::AUTHORIZENET_TRANSACTION_KEY);

			// // Get all existing customer profile ID's
			// $request = new AnetAPI\GetCustomerProfileIdsRequest();
			// $request->setMerchantAuthentication($merchantAuthentication);
			// $controller = new AnetController\GetCustomerProfileIdsController($request);
			// $anetResponse = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

			// if ( ($anetResponse != null) && ($anetResponse->getMessages()->getResultCode() == "Ok") ) {
			// 	// $response['data']   =
			// 	$profile_ids = $anetResponse->getIds();
			// 	$users = array();
			// 	foreach ($profile_ids as $key => $pid) {
			// 		$get     =  $this->get_user_info($pid);
			// 		$users[] = $get['data'];
			// 	}
			// 	$response['data'] = $users;
			// 	$response['status'] = $anetResponse->getMessages()->getResultCode();
			// } else {
			// 	$response['status'] = $anetResponse->getMessages()->getResultCode();
			// }

			return $merchantAuthentication;
			// return $response;
		}

		// Get user information - profile and payment information
		public function get_user_info($profile_id)
		{
			$merchantAuthentication = $this->anet_authentication(self::AUTHORIZENET_API_LOGIN_ID, self::AUTHORIZENET_TRANSACTION_KEY);

			$request = new AnetAPI\GetCustomerProfileRequest();
			$request->setMerchantAuthentication($merchantAuthentication);
			$request->setCustomerProfileId($profile_id);
			$controller = new AnetController\GetCustomerProfileController($request);
			$anetResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
			
			if ( ($anetResponse != null) && ($anetResponse->getMessages()->getResultCode() == "Ok") ) {
				$basicInfo       = $anetResponse->getProfile();
				$paymentInfo     = $basicInfo->getPaymentProfiles();
				$data = array(
					'profile_id'  => $basicInfo->getCustomerProfileId(),
					'merchant_id' => $basicInfo->getmerchantCustomerId(),
					'description' => $basicInfo->getDescription(),
					'email'       => $basicInfo->getEmail(),
					// 'customer_profile_id'         => $paymentInfo[0]->getCustomerProfileId(),
					// 'customer_payment_profile_id' => $paymentInfo[0]->getCustomerPaymentProfileId(),
					// 'defaul_payment_profile'      => $paymentInfo[0]->getDefaultPaymentProfile(),
					// 'payment' => array(
					// 	'credit_card' => array(
					// 		'card_number'     => $paymentInfo[0]->getPayment()->getCreditCard()->getCardNumber(),
					// 		'expiration_date' => $paymentInfo[0]->getPayment()->getCreditCard()->getExpirationDate(),
					// 		'card_type'       => $paymentInfo[0]->getPayment()->getCreditCard()->getCardType(),
					// 		'card_art'        => $paymentInfo[0]->getPayment()->getCreditCard()->getCardArt()
					// 	),
					// ),
					// 'drivers_license'  => $paymentInfo[0]->getDriversLicense(),
					// 'tax_id'           => $paymentInfo[0]->getTaxId(),
					// 'subscription_ids' => '', // Leave it blank for a while
					// 'customer_type'    => $paymentInfo[0]->getCustomerType(),
					// 'billing_info'     => array(
					// 	'phone_number' => $paymentInfo[0]->getBillTo()->getPhoneNumber(),
					// 	'fax_number'   => $paymentInfo[0]->getBillTo()->getFaxNumber(),
					// 	'email'        => $paymentInfo[0]->getBillTo()->getEmail(),
					// 	'first_name'   => $paymentInfo[0]->getBillTo()->getFirstName(),
					// 	'last_name'    => $paymentInfo[0]->getBillTo()->getLastName(),
					// 	'company'      => $paymentInfo[0]->getBillTo()->getCompany(),
					// 	'address'      => $paymentInfo[0]->getBillTo()->getAddress(),
					// 	'city'         => $paymentInfo[0]->getBillTo()->getCity(),
					// 	'state'        => $paymentInfo[0]->getBillTo()->getState(),
					// 	'zip'          => $paymentInfo[0]->getBillTo()->getZip(),
					// 	'country'      => $paymentInfo[0]->getBillTo()->getCountry(),
					// ),
				);
				
				$response['data']   = $data;
				$response['status'] = $anetResponse->getMessages()->getResultCode();
			} else {
				$response['status'] = $anetResponse->getMessages()->getResultCode();
			}

			return $response;
		}

		// Get shipping information
		public function get_shipping_info($profile_id)
		{
			$merchantAuthentication = $this->anet_authentication(self::AUTHORIZENET_API_LOGIN_ID, self::AUTHORIZENET_TRANSACTION_KEY);
			$request = new AnetAPI\GetCustomerShippingAddressRequest();
			$request->setMerchantAuthentication($merchantAuthentication);
			$request->setCustomerProfileId($profile_id);
			
			$controller   = new AnetController\GetCustomerShippingAddressController($request);
			$anetResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

			if ( ($anetResponse != null) && ($anetResponse->getMessages()->getResultCode() == "Ok") ) {
				$response['shipping_info'] = array(
					'first_name' 	      => $anetResponse->getAddress()->getFirstName(),
					'last_name' 	      => $anetResponse->getAddress()->getLastName(),
					'company' 	          => $anetResponse->getAddress()->getCompany(),
					'address' 	          => $anetResponse->getAddress()->getAddress(),
					'city' 		          => $anetResponse->getAddress()->getCity(),
					'state' 		      => $anetResponse->getAddress()->getState(),
					'zip' 		          => $anetResponse->getAddress()->getZip(),
					'country' 	          => $anetResponse->getAddress()->getCountry(),
					'phone_number' 	      => $anetResponse->getAddress()->getPhoneNumber(),
					'fax_number' 	      => $anetResponse->getAddress()->getFaxNumber(),
					'customer_address_id' => $anetResponse->getAddress()->getCustomerAddressId(),
				);
				$response['status'] = $anetResponse->getMessages()->getResultCode();
			} else {
				$response['status'] = $anetResponse->getMessages()->getResultCode();
			}

			return $response;
		}

		// Get payment information
		public function get_payment_info($profile_id)
		{

		}

		// Authentication
		public function anet_authentication($login_id, $transaction_key)
		{
			$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
			$merchantAuthentication->setName($login_id);
			$merchantAuthentication->setTransactionKey($transaction_key);
			return $merchantAuthentication;
		}

	}

}

return new AuthAPI();