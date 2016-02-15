<?php

namespace Avtonom\MediaStorageClientBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class MediaStorageClientManagerNotFoundException extends MediaStorageClientException implements HttpExceptionInterface
{
    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(404, $message, $previous, array(), $code);
    }
}