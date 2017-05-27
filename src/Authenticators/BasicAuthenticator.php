<?php

namespace ServiceMap\Bitbucket\Authenticators;

use Bitbucket\API\Http\Listener\BasicAuthListener;
use InvalidArgumentException;

class BasicAuthenticator extends AbstractAuthenticator implements AuthenticatorInterface
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
      throw new InvalidArgumentException('The client instance was not given to the basic authenticator.');
    }

    if (!array_key_exists('username', $config) || !array_key_exists('password', $config)) {
      throw new InvalidArgumentException('The basic authenticator requires a username and password.');
    }

    $this->client->getClient()->addListener(new BasicAuthListener($config['username'], $config['password']));

    return $this->client;
  }
}
