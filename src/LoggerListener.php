<?php

namespace ServiceMap\Bitbucket;

use Bitbucket\API\Http\Listener\ListenerInterface;
use Buzz\Listener\LoggerListener as BaseListener;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class LoggerListener extends BaseListener implements ListenerInterface
{
  /**
   * Create a new logger listener instance.
   *
   * @param \Psr\Log\LoggerInterface $log
   *
   * @return void
   */
  public function __construct(LoggerInterface $log)
  {
    parent::__construct(function ($message) use ($log) {
      $log->log(LogLevel::DEBUG, $message);
    });
  }

  /**
   * Get the listener name.
   *
   * @return string
   */
  public function getName()
  {
    return 'logger';
  }
}
