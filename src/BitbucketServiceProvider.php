<?php

namespace ServiceMap\Bitbucket;

use Bitbucket\API\Api;
use ServiceMap\Bitbucket\Authenticators\AuthenticatorFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class BitbucketServiceProvider extends ServiceProvider
{
  /**
   * Boot the service provider.
   *
   * @return void
   */
  public function boot()
  {
    $this->setupConfig();
  }

  /**
   * Setup the config.
   *
   * @return void
   */
  protected function setupConfig()
  {
    $source = realpath(__DIR__.'/../config/bitbucket.php');

    if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
      $this->publishes([$source => config_path('bitbucket.php')]);
    }

    $this->mergeConfigFrom($source, 'bitbucket');
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->registerAuthFactory();
    $this->registerBitbucketFactory();
    $this->registerManager();
    $this->registerBindings();
  }

  /**
   * Register the auth factory class.
   *
   * @return void
   */
  protected function registerAuthFactory()
  {
    $this->app->singleton('bitbucket.authfactory', function () {
      return new AuthenticatorFactory();
    });

    $this->app->alias('bitbucket.authfactory', AuthenticatorFactory::class);
  }

  /**
   * Register the bitbucket factory class.
   *
   * @return void
   */
  protected function registerBitbucketFactory()
  {
    $this->app->singleton('bitbucket.factory', function (Container $app) {
      $log = $app->make(LoggerInterface::class);
      $auth = $app['bitbucket.authfactory'];

      return new BitbucketFactory($log, $auth);
    });

    $this->app->alias('bitbucket.factory', BitbucketFactory::class);
  }

  /**
   * Register the manager class.
   *
   * @return void
   */
  protected function registerManager()
  {
    $this->app->singleton('bitbucket', function (Container $app) {
      $config = $app['config'];
      $factory = $app['bitbucket.factory'];

      return new BitbucketManager($config, $factory);
    });

    $this->app->alias('bitbucket', BitbucketManager::class);
  }

  /**
   * Register the bindings.
   *
   * @return void
   */
  protected function registerBindings()
  {
    $this->app->bind('bitbucket.connection', function (Container $app) {
      $manager = $app['bitbucket'];

      return $manager->connection();
    });

    $this->app->alias('bitbucket.connection', Api::class);
  }

  /**
   * Get the services provided by the provider.
   *
   * @return string[]
   */
  public function provides()
  {
    return [
      'bitbucket.authfactory',
      'bitbucket.factory',
      'bitbucket',
      'bitbucket.connection',
    ];
  }
}
