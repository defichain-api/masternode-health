<?php

namespace App\Exceptions\Client;

use Exception;

class GithubClientException extends Exception
{
    public static function requestFailed(string $className): self
    {
        return new self(sprintf('Failed to load latest info from %s', $className));
    }
}
