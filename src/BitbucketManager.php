<?php

namespace ServiceMap\Bitbucket;

use ServiceMap\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * @method \Bitbucket\API\Http\ClientInterface getClient()
 * @method \Bitbucket\API\Api setClient(\Bitbucket\API\Http\ClientInterface $client)
 * @method void setCredentials(\Bitbucket\API\Authentication\AuthenticationInterface $auth)
 * @method \Buzz\Message\MessageInterface requestGet(string $endpoint, array|string $params = [], array $headers = [])
 * @method \Buzz\Message\MessageInterface requestPost(string $endpoint, array|string $params = [], array $headers = [])
 * @method \Buzz\Message\MessageInterface requestPut(string $endpoint, array|string $params = [], array $headers = [])
 * @method \Buzz\Message\MessageInterface requestDelete(string $endpoint, array|string $params = [], array $headers = [])
 * @method \Bitbucket\API\Api setFormat(string $name)
 * @method string getFormat()
 * @method \Bitbucket\API\Api api(string $name)
 */

class BitbucketManager extends AbstractManager
{
  /**
   * The factory instance.
   *
   * @var \ServiceMap\Bitbucket\BitbucketFactory
   */
  protected $factory;

  /**
   * Create a new bitbucket manager instance.
   *
   * @param \Illuminate\Contracts\Config\Repository    $config
   * @param \ServiceMap\Bitbucket\BitbucketFactory     $factory
   *
   * @return void
   */
  public function __construct(Repository $config, BitbucketFactory $factory)
  {
      parent::__construct($config);
      $this->factory = $factory;
  }

  /**
   * Create the connection instance.
   *
   * @param array $config
   *
   * @return \Bitbucket\API\Api
   */
  protected function createConnection(array $config)
  {
    return $this->factory->make($config);
  }

  /**
   * Get the configuration name.
   *
   * @return string
   */
  protected function getConfigName()
  {
    return 'bitbucket';
  }

  /**
   * Get the factory instance.
   *
   * @return \ServiceMap\Bitbucket\BitbucketFactory
   */
  public function getFactory()
  {
    return $this->factory;
  }
}
