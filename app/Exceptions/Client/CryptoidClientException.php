<?php

namespace App\Exceptions\Client;

use Exception;

class CryptoidClientException extends Exception
{
    public static function latestBlockHeight(): self
    {
        return new self('Failed to get latest block height');
    }

    public static function latestBlockHash(int $blockHeight): self
    {
        return new self(sprintf('Failed to get block hash for block %s', $blockHeight));
    }
}
