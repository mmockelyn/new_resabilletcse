<?php

namespace App\Http\Controllers;

use App\Services\ReducCe\Api;
use App\Services\Tradedoubler\Program;
use App\Services\Tradedoubler\Sources;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function code()
    {
        /*try {
            $client = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        } catch (\SoapFault $e) {
            dd($e->getMessage());
        }

        dd($client->GET_CATALOGUES(['partenaire_id' => config('ce.ce_id')]));*/

        $client = new Program();
        dd($client->list()->items);
    }
}
