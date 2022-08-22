<?php

namespace App\Services\Tradedoubler;

class Sources extends API
{
    public function list()
    {
        return $this->call('publisher/sources');
    }
}
