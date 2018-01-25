<?php

namespace MarkHewitt\GoogleAuthentication;
use Endroid\QrCode\QrCode;
use RobThree\Auth\Providers\Qr\IQRCodeProvider;

/**
 *
 */
class QRProvider implements IQRCodeProvider {

	/**
	 * This is slightly different, it returns the image as a base64 encoded data URI
	 * to allow direct embedding into img tags, avoiding multiple round trips to server
	 */
	public function getMimeType() {
		return 'image/png';                            
	}

	public function getQRCodeImage($secret, $size) {
		$qrCode = new QrCode($secret);
		$qrCode->setSize(300);
		return (string)$qrCode->getImage();
	}

}