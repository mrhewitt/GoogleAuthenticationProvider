<?php

namespace MarkHewitt\GoogleAuthenticator;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

class GoogleAuthenticationProvider implements ServiceProviderInterface
{
    public function register(Container $app, $app_name)
    {
       $app['google.authenticator'] = function() use ($app) {
										return new GoogleAuthenticator($app_name);
									};
	}
	
}