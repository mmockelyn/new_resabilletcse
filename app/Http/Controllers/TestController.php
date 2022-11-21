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

        $signature = hash("sha512", "EBILLET+" . config('ce.ce_id')."+FCH+" . $add."+bureau+".$postal."+".$email."+".$nom."+".$prenom."+".$ville."+"."SECRET");

        $table_ce = [
            "ID".$faker->randomDigit(),
            "TEST",
            "Monsieur",
            "Doe",
            "John",
            $faker->phoneNumber,
            $faker->phoneNumber,
            $faker->phoneNumber,
            "Test@test.com",
            "Bureau",
            $faker->address,
            '',
            "85100",
            "Les Sables d'Olonne",
            "France",
        ];

        $table_user = [
            'ID45465465', 										// id_partenaire
            'TEST', 										// utilisateurs_societe
            'Monsieur', 										// utilisateurs_civilite
            $nom, 										// utilisateurs_nom
            $prenom, 										// utilisateurs_prenom
            '0964856525', 										// utilisateurs_telephone
            '0633526585', 										// utilisateurs_portable
            '', 										// utilisateurs_fax
            $email, 										// utilisateurs_email
            'bureau', 										// utilisateurs_adresse_nom
            $add, 										// utilisateurs_adresse1
            '', 										// utilisateurs_adresse2
            $postal, 										// utilisateurs_codepostal
            $ville, 										// utilisateurs_ville
            'France', 										// utilisateurs_pays
            '' 										// utilisateurs_date_naissance
        ];

        $table_command = [
            '',
            '',
            'FCH',
            $faker->randomFloat(),
            '',
            '',
            '',
            $faker->name,
            $faker->address,
            '',
            $faker->postcode,
            $faker->city,
            "France",
            config('app.url'),
            config('app.url'),
            '',
            '',
            '',
            '',
            '',
            'CMD'.$faker->randomDigit(),
        ];

        $data = [
            'CE_ID' => config('ce.ce_id'),
            'SIGNATURE' => $signature,
            'TABLE_CE' => $table_ce,
            'TABLE_UTILISATEUR' => $table_user,
            'TABLE_COMMANDE' => $table_command,
        ];

        dd($commande->create($data));
    }
}
