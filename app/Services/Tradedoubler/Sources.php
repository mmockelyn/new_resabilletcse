<?php

namespace App\Services\Tradedoubler;

/**
 * @codeCoverageIgnore
 */
class Sources extends API
{
    public function list()
    {
        return $this->call('publisher/sources');
    }
}
