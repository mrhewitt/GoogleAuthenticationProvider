<?php

namespace MarkHewitt\GoogleAuthentication;
use RobThree;
use MarkHewitt\GoogleAuthentication\QRProvider as QRProvider;

class GoogleAuthenticator {

	public function __constructor($app_name) {
		$this->qr = new QRProvider();
		$this->tfa = new RobThree\Auth\TwoFactorAuth($app_name, 6, 30, 'sha1', $this->qr);	
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
	 * @return array 
	 */
	public function generate() {
		$secret = $this->tfa->createSecret();
		$qr = $this->getQR($secret);
		return ['secret' => $secret, 'qr' => $qr];
	}
	
	public function getQR($secret) {
		return $this->tfa->getQRCodeImageAsDataUri($this->app_name, $secret);
	}
	
	public function validate($secret, $code) {
		return $this->verifyCode($secret, $code);
	}
	
}