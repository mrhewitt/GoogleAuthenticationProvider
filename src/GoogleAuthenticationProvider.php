<?php

namespace MarkHewitt\GoogleAuthentication;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

class GoogleAuthenticationProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
       $app['google.authenticator'] = function() use ($app) {
										return new GoogleAuthenticator($app['markhewitt.ga.app']);
									};
									
	}
	
}