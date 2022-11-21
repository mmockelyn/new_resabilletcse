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

        $data = [
            'SIGNATURE' => [
                hash("sha512", "LS50G+" . config('ce.ce_id')."+" . $add."+" . $name."+".$postal."+".$email."+".$nom."+".$prenom."+".$ville."+"."SECRET")
            ],
            "TABLE_CE" => [
                "ID".$faker->randomDigit(),
                "TEST",
                "TEST",
                "Doe",
                "John",
                "Test@test.com",
                $faker->phoneNumber,
                $faker->phoneNumber,
                $faker->phoneNumber,
                "Test@test.com",
                $faker->name,
                $faker->address,
                '',
                "85100",
                "Les Sables d'Olonne",
                "France"
            ],
            'TABLE_UTILISATEUR' => [
                "ID874596P",
                $name,
                $name,
                $name,
                $prenom,
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber,
                $email,
                $name,
                $add,
                '',
                $postal,
                $ville,
                "France",
                ""
            ],
            'TABLE_COMMANDE' => [
                '',
                '',
                'Carte bancaire',
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
            ],
        ];

        dd($commande->create($data));
    }
}
