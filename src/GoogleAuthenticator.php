<?php

namespace MarkHewitt\GoogleAuthentication;

use RobThree;
use MarkHewitt\GoogleAuthentication\QRProvider as QRProvider;

class GoogleAuthenticator {

	protected $tfa = null;
	protected $qr = null;
	protected $app_name = "";

	public function __construct($app_name) {
	//	$this->qr = new QRProvider();
		$this->tfa = new RobThree\Auth\TwoFactorAuth($app_name, 6, 60, 'sha1'/*, $this->qr*/);	
		$this->app_name = $app_name;
	}

	/**
	 * Creates a secret and returns the QR code associated with it 
	 * Note the QR code with be returned as a base64 encoded img suitable for direct insertion into an image tag
	 * using the data: URL scheme, example :
	 *
	 *		$secret = $ga->generate();
	 *		print '<img src="data:' . $secret['qr'] .'" />';
	 *
	 * @param mixed $secret Can pass an already existing secret if this has been created already but the user did
	 * 						not complete the code entry, he may have already scanned the QR into his device, but just
	 * 						refreshed the page instead of entering his code, hence we want an option to prevent
	 * 						continuously generating new secrets for him
	 *
	 * @param string $label Optional additional label to be shown in the app along with company name, for example 
	 * 						this can be a user name which can differentiate the accounts in one human has multiple accounts
	 * 						
	 *
	 * @return array 
	 */
	public function generate( $secret = false, $label = "" ) {
		if ( empty($secret) ) { $secret = $this->tfa->createSecret(); }
		$qr = $this->getQR($secret, $label);
		return ['secret' => $secret, 'qr' => $qr];
	}
	
	/**
	 * Returns the QR code as a base64 encoded img data attribute, simply output the return from this
	 * function into the <img> tag in your template to show the QR code image
	 * 
	 * [method]
	 * 		$qr = $app['google.authenticator']->getQR($secret,"Mark");
	 * 		// now pass qr as a param to your twig render call
	 * [template]
	 * 		<img src="{{qr}}" alt="Google QR Code"/> 
	 * 
	 * @param string $secret The secret that was given by ::generate() for creating tokens associated with that user
	 * @param string $label Optional additional label to be shown in the app along with company name, for example 
	 * 						this can be a user name which can differentiate the accounts in one human has multiple accounts
	 *
	 * @return string Base64 encoded img data attribute
	 */
	public function getQR($secret, $label = "") {
		return $this->tfa->getQRCodeImageAsDataUri($label, $secret);
	}
	
	public function validate($secret, $code) {
		return $this->tfa->verifyCode($secret, $code);
	}
	
}