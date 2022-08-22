<?php

namespace App\Services\Tradedoubler;

/**
 * @codeCoverageIgnore
 */
class Program extends API
{
    public function list()
    {
        return $this->call('publisher/programs', 'GET', ['sourceId' => $this->sources_id]);
    }

    public function apply($program_id)
    {
        return $this->call('publisher/programs/apply', 'POST', [
            "sourceId" => $this->sources_id,
            'programId' => $program_id
        ]);
    }
}
