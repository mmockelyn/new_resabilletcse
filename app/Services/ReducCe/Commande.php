<?php

namespace App\Services\ReducCe;

use Illuminate\Http\Request;

class Commande extends Api
{
    public function create(array $tab)
    {
        $dataset = new \stdClass();
        $dataset->schema = '';
        $dataset->any = '';

        $params = [
            'CE_ID' => config('ce.ce_id'),
            $tab
        ];
        $client = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        return $client->CREATION_COMMANDE_ARRAY($params);
    }
}
