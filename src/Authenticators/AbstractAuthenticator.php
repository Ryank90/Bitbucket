<?php

namespace ServiceMap\Bitbucket\Authenticators;

use Bitbucket\API\Api;

abstract class AbstractAuthenticator
{
  /**
   * The client to perform the authentication on.
   *
   * @var \Bitbucket\API\Api|null
   */
  protected $client;

  /**
   * Set the client to perform the authentication on.
   *
   * @param \Bitbucket\API\Api $client
   *
   * @return \ServiceMap\Bitbucket\Authenticators\AuthenticatorInterface
   */
  public function with(Api $client)
  {
    $this->client = $client;

    return $this;
  }
}
