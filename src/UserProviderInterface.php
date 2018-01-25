<?php

namespace MarkHewitt\GoogleAuthentication;

interface UserProviderInterface {

    public function setUserSecret($user, $secret);

}