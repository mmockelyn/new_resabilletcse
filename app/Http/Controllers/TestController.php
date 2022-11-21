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

        $add = $faker->streetAddress;
        $nom = $faker->name;
        $postal = $faker->postcode;
        $email = $faker->email;
        $name = $faker->firstName;
        $prenom = $faker->lastName;
        $ville = $faker->city;

        $signature_i = "EBILLET+ID45465465+FCH+" . $add."+bureau+".$postal."+".$email."+".$nom."+".$prenom."+".$ville."+"."SECRET";
        //dd($signature, $add, $nom, $postal, $email, $prenom, $ville);
        $signature = hash("sha512", $signature_i);

        $table_ce = [
            '123456', 									// ce_id
            'CE TEST', 								// ce_societe
            'Monsieur', 										// ce_civilite
            $nom, 										// ce_nom
            $prenom, 										// ce_prenom
            $faker->phoneNumber, 										// ce_telephone
            $faker->phoneNumber, 										// ce_portable
            $faker->phoneNumber, 										// ce_fax
            $faker->email, 										// ce_email
            'bureau', 										// ce_adresse_nom
            $add, 										// ce_adresse1
            '', 										// ce_adresse2
            $postal, 										// ce_codepostal
            $ville, 										// ce_ville
            'France' 										// ce_pays
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
            '0', 										// nb_cheques_vacances
            '0', 										// montant_total_cheques_vacances
            'FCH', 									// mode_paiement
            '0', 										// prix_livraison
            'EBILLET', 								// code_livraison
            '', 										// commentaire
            $faker->company, 										// livraison_adresse_societe
            'bureau', 										// livraison_adresse_nom
            $add, 										// livraison_adresse_1
            '', 										// livraison_adresse_2
            $postal, 										// livraison_codepostal
            $ville, 										// livraison_ville
            'France', 										// livraison_pays
            '', 										// url_retour
            '', 										// url_retour_ok
            'https://test.com', 										// url_retour_err
            '', 										// acompte
            '', 										// numero_commande_ticketnet
            '', 										// frais_gestion_payeur
            '', 										// frais_port_payeur
            '', 										// remise_frais_port
            'FRF8569665' 										// numero_commande_distributeur
        ];

        $data = [
            'CE_ID' => config('ce.ce_id'),
            'SIGNATURE' => $signature,
            'TABLE_CE' => $table_ce,
            'TABLE_UTILISATEUR' => $table_user,
            'TABLE_COMMANDE' => $table_command,
        ];

        dd($commande->create($data), $signature_i, $table_command, $table_user);
    }
}
