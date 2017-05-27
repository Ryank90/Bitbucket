<?php

namespace ServiceMap\Bitbucket\Authenticators;

use Bitbucket\API\Http\Listener\OAuth2Listener;
use InvalidArgumentException;

class TokenAuthenticator extends AbstractAuthenticator implements AuthenticatorInterface
{
  /**
   * Authenticate the client, and return it.
   *
   * @param string[] $config
   *
   * @throws \InvalidArgumentException
   *
   * @return \Bitbucket\API\Api
   */
  public function authenticate(array $config)
  {
    if (!$this->client) {
      throw new InvalidArgumentException('The client instance was not given to the token authenticator.');
    }

    if (!array_key_exists('token', $config)) {
      throw new InvalidArgumentException('The token authenticator requires a token.');
    }

    $this->client->getClient()->addListener(new OAuth2Listener(['access_token' => $config['token']]));

    return $this->client;
  }
}
