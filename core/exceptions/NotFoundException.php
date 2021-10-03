<?php

namespace app\core\exceptions;

class NotFoundException extends \Exception
{
    public function __construct()
    {
        $message = "Not Found";
        $code = 404;
        $previous = null;
        parent::__construct($message, $code, $previous);
    }

}