<?php

namespace SipalingNgoding\MVC\Exception;

class NotFoundError extends ClientError
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 404);
    }
}
