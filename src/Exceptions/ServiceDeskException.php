<?php

namespace TianSchutte\ServiceDeskJira\Exceptions;

use Exception;
use Throwable;

class ServiceDeskException extends Exception implements Throwable
{

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        logger()->warning($message, ['exception' => $this]);
    }
}