<?php

namespace App\Http\Controllers;

use App\Services\ReducCe\Api;
use App\Services\ReducCe\Commande;
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
            $commande = new Commande('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        } catch (\SoapFault $e) {
            dd($e->getMessage());
        }

        dd($commande->ETAT_SITE());

        dd($commande->create([
            'schema' => [],
            'any' => [
                "ce" => [
                    "ce_id" => 4,
                    'ce_societe' => "TEST",
                    "ce_nom" => "Doe",
                    'ce_prenom' => "John",
                    'ce_email' => "Test@test.com",
                    'ce_codepostal' => "85100",
                    'ce_ville' => "Les Sables d'Olonne"
                ],
                'commande' => [
                    'mode_paiement' => 'Carte bancaire',
                    'prix_livraison' => '',
                    'livraison_adresse_societe',
                    'livraison_adresse_nom',
                    'livraison_adresse_1',
                    'livraison_adresse_2',
                    'livraison_adresse_3',
                    'livraison_codepostal',
                    'livraison_ville'
                ],
                'signature' => [
                    'clef_secret' => sha1("LS50G".config('ce.ce_id')."")
                ]
            ]
        ]));
    }
}
