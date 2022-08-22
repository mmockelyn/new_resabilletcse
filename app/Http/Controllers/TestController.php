<?php

namespace App\Http\Controllers;

use App\Services\ReducCe\Api;
use App\Services\Tradedoubler\Program;
use App\Services\Tradedoubler\Sources;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @return void
     * @codeCoverageIgnore
     */
    public function code()
    {
        try {
            $client = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        } catch (\SoapFault $e) {
            dd($e->getMessage());
        }

        $tarifs = $client->GET_ARTICLE_TARIFS([
            'partenaire_id' => config('ce.ce_id'),
            'articles_id' => '744e68cf-748a-4ae1-8876-db239ca6acb5'
        ]);
        $xml = simplexml_load_string($tarifs->GET_ARTICLE_TARIFSResult->any);
        dd($xml);
    }
}
