<?php

namespace App\Http\Controllers;

use App\Services\ReducCe\Api;
use App\Services\ReducCe\Commande;
use App\Services\Tradedoubler\Program;
use App\Services\Tradedoubler\Sources;
use Faker\Factory;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @return void
     * @codeCoverageIgnore
     */
    public function code()
    {
        $faker = Factory::create('fr_FR');
        try {
            $commande = new Commande('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        } catch (\SoapFault $e) {
            dd($e->getMessage());
        }


        dd($commande->create(
            [
                config('ce.ce_id'),
                "ce" => [
                    "ce_id" => config('ce.ce_id'),
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
                    'livraison_adresse_nom' => $faker->name,
                    'livraison_adresse_1' => $faker->address,
                    'livraison_adresse_2',
                    'livraison_adresse_3',
                    'livraison_codepostal' => $faker->postcode,
                    'livraison_ville' => $faker->city
                ],
                'utilisateur' => [
                    'id_partenaire' => "ID874596P",
                    'utilisateurs_nom' => $faker->firstName,
                    'utilisateurs_prenom' => $faker->lastName,
                    'utilisateurs_telephone' => $faker->e164PhoneNumber,
                    'utilisateurs_portable' => $faker->e164PhoneNumber,
                    'utilisateurs_email' => $faker->email,
                    'utilisateurs_adresse1' => $faker->address,
                    'utilisateurs_codepostal' => $faker->postcode,
                    'utilisateurs_ville' => $faker->city,
                    'utilisateurs_pays' => "France"
                ],
                'signature' => [
                    'clef_secret' => sha1("LS50G" . config('ce.ce_id') . "")
                ],
            ]
        ));
    }
}
