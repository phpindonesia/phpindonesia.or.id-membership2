<?php

namespace Membership\Http;

class ValidatorException extends \InvalidArgumentException
{
    protected $errors;

    public function __construct($message = '', array $errors = [], $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
