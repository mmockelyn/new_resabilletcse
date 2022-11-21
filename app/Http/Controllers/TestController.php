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

        $add = $faker->address;
        $nom = $faker->name;
        $postal = $faker->postcode;
        $email = $faker->email;
        $name = $faker->firstName;
        $prenom = $faker->lastName;
        $ville = $faker->city;


        dd($commande->create(
            [
                "ce" => [
                    "ce_id" => config('ce.ce_id'),
                    'ce_societe' => "TEST",
                    'ce_civilite' => "TEST",
                    "ce_nom" => "Doe",
                    'ce_prenom' => "John",
                    'ce_email' => "Test@test.com",
                    'ce_telephone' => $faker->phoneNumber,
                    'ce_portable' => $faker->phoneNumber,
                    'ce_fax' => $faker->phoneNumber,
                    'ce_email' => "Test@test.com",
                    'ce_adresse_nom' => $faker->name,
                    'ce_adresse1' => $faker->address,
                    'ce_adresse2' => '',
                    'ce_codepostal' => "85100",
                    'ce_ville' => "Les Sables d'Olonne",
                    'ce_pays' => "France"
                ],
                'commande' => [
                    'nb_cheques_vacances' => '',
                    'montant_total_cheques_vacances' => '',
                    'mode_paiement' => 'Carte bancaire',
                    'prix_livraison' => $faker->randomFloat(),
                    'code_livraison' => '',
                    'commentaire' => '',
                    'livraison_adresse_societe',
                    'livraison_adresse_nom' => $faker->name,
                    'livraison_adresse_1' => $faker->address,
                    'livraison_adresse_2',
                    'livraison_codepostal' => $faker->postcode,
                    'livraison_ville' => $faker->city,
                    'livraison_pays' => "France",
                    'url_retour_ok' => config('app.url'),
                    'url_retour_err' => config('app.url'),
                    'acompte' => '',
                    'numero_commande_ticketnet' => '',
                    'frais_gestion_payeur' => '',
                    'frais_port_payeur' => '',
                    'remise_frais_port' => '',
                    'numero_commande_distributeur' => 'CMD'.$faker->randomDigit(),
                ],
                'utilisateur' => [
                    'id_partenaire' => "ID874596P",
                    'utilisateurs_societe' => $name,
                    'utilisateurs_civilite' => $name,
                    'utilisateurs_nom' => $name,
                    'utilisateurs_prenom' => $prenom,
                    'utilisateurs_telephone' => $faker->e164PhoneNumber,
                    'utilisateurs_portable' => $faker->e164PhoneNumber,
                    'utilisateurs_fax' => $faker->e164PhoneNumber,
                    'utilisateurs_email' => $email,
                    'utilisateurs_adresse_nom' => $name,
                    'utilisateurs_adresse1' => $add,
                    'utilisateurs_adresse2' => '',
                    'utilisateurs_codepostal' => $postal,
                    'utilisateurs_ville' => $ville,
                    'utilisateurs_pays' => "France",
                    'utilisateurs_date_naissance' => ""
                ],
                'signature' => [
                    'clef_secret' => hash("sha512", "LS50G" . config('ce.ce_id') . $add . $name.$postal.$email.$nom.$prenom.$ville."SECRET")
                ],
            ]
        ));
    }
}
