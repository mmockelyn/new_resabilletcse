<?php
return [
    'ce_id' => env("CE_ID"),
    'ce_name' => 'RESABILLETCSE',
    'secret_key' => env('CE_SECRET'),
    'signature' => sha1(config('ce.ce_id')+config('ce.secret_key')),
    'tradedoubler_client_id' => env("TRADEDOUBLER_CLIENT_ID"),
    'tradedoubler_client_secret' => env("TRADEDOUBLER_CLIENT_SECRET"),
];
