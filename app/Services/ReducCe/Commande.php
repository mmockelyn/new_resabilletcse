<?php

namespace App\Services\ReducCe;

use Illuminate\Http\Request;

class Commande extends Api
{
    public function create(array $table_ce, array $table_user, )
    {
        $client = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        return $client->CREATION_COMMANDE_ARRAY($tab);
    }
}
