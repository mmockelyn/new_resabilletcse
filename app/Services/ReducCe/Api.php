<?php

namespace App\Services\ReducCe;

use App\Helper\LogHelper;


class Api extends \SoapClient
{
    public $server;

    public function __construct(?string $wsdl, array $options = null)
    {
        parent::__construct($wsdl, $options);
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0): bool|string|null
    {
        $xml = explode("\r\n", parent::__doRequest($request, $location, $action, $version));
        $response = preg_replace('/^(\x00\x00\xFE\xFF|\xFF\xFE\x00\x00|\xFE\xFF|\xFF\xFE|\xEF\xBB\xBF)/', "", $xml[6]);
        return $response;
    }


}
