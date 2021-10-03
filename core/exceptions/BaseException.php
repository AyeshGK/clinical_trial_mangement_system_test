<?php

namespace app\core\exceptions;

abstract class BaseException extends \Exception
{
    protected $code;
    protected $message;
}