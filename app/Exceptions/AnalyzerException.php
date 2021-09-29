<?php

namespace App\Exceptions;

use Exception;
use Log;

class AnalyzerException extends Exception
{
    public static function attributeNotFound(string $attribute): self
    {
        $message = sprintf('Could not find requested attribute "%s"', $attribute);

        return new self($message);
    }
}
