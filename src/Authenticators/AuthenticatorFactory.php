<?php

namespace ServiceMap\Bitbucket\Authenticators;

use InvalidArgumentException;

class AuthenticatorFactory
{
  /**
   * Make a new authenticator instance.
   *
   * @param string $method
   *
   * @return \ServiceMap\Bitbucket\Authenticators\AuthenticatorInterface
   */
  public function make($method)
  {
    switch ($method) {
      case 'basic':
        return new BasicAuthenticator();
      case 'token':
        return new TokenAuthenticator();
      case 'oauth':
        return new OAuthAuthenticator();
    }

    throw new InvalidArgumentException('Unsupported authentication method [' . $method . '].');
  }
}
