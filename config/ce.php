<?php
return [
    'ce_id' => '8430fb82-768d-4f80-9f19-0b073c5d7741',
    'ce_name' => 'RESABILLETCSE',
    'secret_key' => 'SECRET',
    'signature' => sha1(config('ce.ce_id')+config('ce.secret_key')),
    'tradedoubler_client_id' => '12d237f8-660d-3e34-9a12-970d4b96b38c',
    'tradedoubler_client_secret' => 'cdd44f77163d8a7f',
];
