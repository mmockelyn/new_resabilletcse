<?php

namespace App\Services\ReducCe;

use App\Helper\LogHelper;

/**
 * @codeCoverageIgnore
 */

class Api extends \SoapClient
{
    public $server;

    public function __construct(?string $wsdl, array $options = null)
    {
        parent::__construct($wsdl, $options);
    }

    public function __doRequest($request, $location, $action, $version, $one_way = NULL): bool|string|null
    {
        $xml = explode("\r\n", parent::__doRequest($request, $location, $action, $version, $one_way = NULL));
        return preg_replace('/^(\x00\x00\xFE\xFF|\xFF\xFE\x00\x00|\xFE\xFF|\xFF\xFE|\xEF\xBB\xBF)/', "", $xml[6]);
    }
}
