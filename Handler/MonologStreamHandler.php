<?php

namespace Avtonom\MediaStorageClientBundle\Handler;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MonologStreamHandler extends StreamHandler
{
    /**
     * @param resource|string $stream
     * @param array         $config
     * @param Boolean         $bubble         Whether the messages that are handled can bubble up the stack or not
     * @param int|null        $filePermission Optional file permissions (default (0644) are only for owner read/write)
     * @param Boolean         $useLocking     Try to lock log file before doing any writes
     *
     * @throws \InvalidArgumentException If stream is not a resource or string
     */
    public function __construct($stream, $config, $bubble = true, $filePermission = null, $useLocking = false)
    {
        $level = ($config && is_array($config) && !empty($config['logging_level'])) ? $config['logging_level'] : Logger::ERROR;
        parent::__construct($stream, $level, $bubble, $filePermission, $useLocking);
    }
}