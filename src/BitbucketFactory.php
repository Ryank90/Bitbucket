<?php

namespace ServiceMap\Bitbucket;

use Bitbucket\API\Api;
use Bitbucket\API\Http\Client;
use Bitbucket\API\Http\ClientInterface;
use Bitbucket\API\Http\Listener\NormalizeArrayListener;
use ServiceMap\Bitbucket\Authenticators\AuthenticatorFactory;
use Psr\Log\LoggerInterface;

class BitbucketFactory
{
  /**
   * The psr logger instance.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $log;

  /**
   * The authenticator factory instance.
   *
   * @var \ServiceMap\Bitbucket\Authenticators\AuthenticatorFactory
   */
  protected $auth;

  /**
   * Create a new bitbucket factory instance.
   *
   * @param \Psr\Log\LoggerInterface                                      $log
   * @param \ServiceMap\Bitbucket\Authenticators\AuthenticatorFactory     $auth
   *
   * @return void
   */
  public function __construct(LoggerInterface $log, AuthenticatorFactory $auth)
  {
    $this->log = $log;
    $this->auth = $auth;
  }

  /**
   * Make a new bitbucket client.
   *
   * @param string[] $config
   *
   * @return \Bitbucket\API\Api
   */
  public function make(array $config)
  {
    $http = $this->getHttpClient($config);

    return $this->getClient($http, $config);
  }

  /**
   * Get the http client.
   *
   * @param string[] $config
   *
   * @return \Bitbucket\API\Http\ClientInterface
   */
  protected function getHttpClient(array $config)
  {
    $options = [
      'base_url'    => array_get($config, 'baseUrl', 'https://api.bitbucket.org'),
      'api_version' => array_get($config, 'version', '1.0'),
      'verify_peer' => array_get($config, 'verify', true),
    ];

    $client = new Client($options);

    if (array_get($config, 'logging')) {
      $client->addListener(new LoggerListener($this->log));
    }

    $client->addListener(new NormalizeArrayListener());

    return $client;
  }

  /**
   * Get the main client.
   *
   * @param \Bitbucket\API\Http\ClientInterface $http
   * @param string[]                            $config
   *
   * @return \Bitbucket\API\Api
   */
  protected function getClient(ClientInterface $http, array $config)
  {
    $client = new Api();

    $client->setClient($http);

    return $this->auth->make(array_get($config, 'method'))->with($client)->authenticate($config);
  }
}
