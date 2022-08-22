<?php

namespace App\Console\Commands;

use App\Helper\LogHelper;
use App\Models\Catalogue\Article;
use App\Models\Catalogue\ArticleLieu;
use App\Models\Catalogue\ArticleTarif;
use App\Models\Catalogue\Catalogue;
use App\Models\Catalogue\Genre;
use App\Models\Catalogue\SubGenre;
use App\Services\ReducCe\Api;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BilletterieCommand extends Command
{
    private Api $api;

    public function __construct()
    {
        parent::__construct();
        try {
            $this->api = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        } catch (\SoapFault $e) {
            LogHelper::notify('critical', 'SOAP: ' . $e->getMessage());
        }
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billetterie {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'importCatalogues':
                return $this->importCatalogues();

            case 'importGenres':
                return $this->importGenres();

            case 'importSubGenres':
                return $this->importSubGenres();

            case 'importArticles':
                return $this->importArticles();

            case 'all':
                $this->call('migrate:fresh', ['--seed']);
                $this->importCatalogues();
                $this->importGenres();
                $this->importSubGenres();
                $this->importArticles();
        }
    }

    private function importCatalogues(): int
    {
        $all = $this->api->GET_CATALOGUES(['partenaire_id' => config('ce.ce_id')]);
        $xml = simplexml_load_string($all->GET_CATALOGUESResult->any);
        $i = 0;
        foreach ($xml->NewDataSet->Catalogues as $catalogue) {
            Catalogue::create([
                'uuid' => $catalogue->catalogues_id,
                'name' => $catalogue->catalogues_nom,
                'url' => $catalogue->catalogues_url,
            ]);
            $i++;
        }
        $this->info("Nombre de catalogue importé: " . $i);
        return 0;
    }

    private function importGenres()
    {
        $catalogues = Catalogue::all();
        $i = 0;

        foreach ($catalogues as $catalogue) {
            $client = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
            $call = $client->GET_GENRES_CATALOGUE([
                'partenaire_id' => config('ce.ce_id'),
                'catalogues_id' => $catalogue->uuid,
                'format_fichier' => 'XML'
            ]);
            $xml = simplexml_load_string($call->GET_GENRES_CATALOGUEResult->any);
            $genres = $xml->NewDataSet->Genres;
            $count = count((array)$genres);
            if ($count != 0) {
                foreach ($genres as $genre) {
                    Genre::create([
                        'uuid' => $genre->genres_id,
                        'name' => $genre->genres_nom,
                        'url' => null,
                        'descriptif' => $genre->genres_descriptif,
                        'descriptif_data' => null,
                        'created_at' => Carbon::createFromTimestamp(strtotime($genre->genres_date_creation)),
                        'updated_at' => Carbon::createFromTimestamp(strtotime($genre->genres_date_modification)),
                        'actif' => $genre->genres_actif ? 1 : 0,
                        'catalogue_id' => $catalogue->id
                    ]);
                    $i++;
                }
            }
        }
        $this->info('Nombre de genre importé: ' . $i);
        return 0;
    }

    private function importSubGenres()
    {
        $genres = Genre::all();
        $i = 0;

        foreach ($genres as $genre) {
            $client = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
            $call = $client->GET_SOUS_GENRES([
                'partenaire_id' => config('ce.ce_id'),
                'genres_id' => $genre->uuid,
            ]);
            $xml = simplexml_load_string($call->GET_SOUS_GENRESResult->any);
            $subs = $xml->NewDataSet->Sousgenres;
            //dd(count((array)$subs));
            if (count((array)$subs) != 0) {
                $bar = $this->output->createProgressBar(count($subs));
                $this->line("Installation des sous-genres du genre: " . $genre->name);
                $bar->start();

                foreach ($subs as $sub) {
                    SubGenre::create([
                        'uuid' => $sub->sousgenres_id,
                        'name' => $sub->sousgenres_nom,
                        'open' => $sub->sousgenres_ouvert ? 1 : 0,
                        'date_open' => $sub->sousgenres_date_ouverture ? Carbon::createFromTimestamp(strtotime($sub->sousgenres_date_ouverture)) : null,
                        'info_open' => $sub->sousgenres_infos_ouverture,
                        'url_info' => $sub->sousgenres_url_informations,
                        'url_resa' => $sub->sousgenres_url_reservation,
                        'url' => $sub->sousgenres_url,
                        'descriptif' => $sub->sousgenres_descriptif,
                        'descriptif_data' => $sub->sousgenres_descriptif_data,
                        'logo' => $sub->sousgenres_logo,
                        'plan' => $sub->sousgenres_plan,
                        'postal' => $sub->sousgenres_codepostal,
                        'format_keycard' => $sub->sousgenres_format_keycard,
                        'sejour' => $sub->sousgenres_sejour ? 1 : 0,
                        'provider_url' => $sub->sousgenres_fournisseur_url,
                        'provider_code' => $sub->sousgenres_fournisseur_code,
                        'lieux_id' => $sub->lieux_id,
                        'lieux_latitude' => $sub->lieux_latitude,
                        'lieux_longitude' => $sub->lieux_longitude,
                        'actif' => $sub->sousgenres_actif ? 1 : 0,
                        'created_at' => Carbon::createFromTimestamp(strtotime($sub->sousgenres_date_creation)),
                        'updated_at' => Carbon::createFromTimestamp(strtotime($sub->sousgenres_date_modification)),
                        'genre_id' => $genre->id
                    ]);
                    $bar->advance();
                    $i++;
                }
                $bar->finish();
                $this->newLine(2);
            }
        }

        $this->info('Nombre de sous-genre importé: ' . $i);
        return 0;
    }

    public function importArticles()
    {
        $client = new Api('https://webservices-test.reducce.fr/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        $call = $client->GET_ARTICLES([
            'partenaire_id' => config('ce.ce_id'),
        ]);

        $articles = simplexml_load_string($call->GET_ARTICLESResult->any);
        $count = count((array) $articles->NewDataSet->Articles);
        $bar = $this->output->createProgressBar($count);
        $this->info("Installation des articles");
        $bar->start();
        foreach ($articles->NewDataSet->Articles as $article) {
            $genre = Genre::where('name', 'LIKE', "%".$article->articles_genre."%")->first();
            $subgenre = SubGenre::where('name', "LIKE", "%".$article->articles_sousgenre."%")->first();
            $catalogue = Catalogue::where('uuid', $article->catalogues_id)->first();
            $dataArticle = Article::create([
                'uuid' => $article->articles_id,
                'code' => $article->articles_code,
                'type' => $article->articles_type,
                'domain_id' => $article->articles_domaine_id,
                'domain' => $article->articles_domaine,
                'idmanif' => $article->articles_idmanif,
                'name_manif' => $article->articles_nom_manif,
                'state_manif' => $article->articles_statut_manif,
                'start_manif' => $article->articles_debut_manif ? Carbon::createFromTimestamp(strtotime($article->articles_debut_manif)) : null,
                'end_manif' => $article->articles_fin_manif ? Carbon::createFromTimestamp(strtotime($article->articles_fin_manif)) : null,
                'open_vente' => $article->articles_ouverture_vente ? Carbon::createFromTimestamp(strtotime($article->articles_ouverture_vente)) : null,
                'nb_max_billet' => $article->articles_nb_billets_max,
                'public_price' => $article->articles_prix_public,
                'puht' => $article->articles_puht,
                'puttc' => $article->articles_puttc,
                'remise_btob' => $article->articles_remise_btob,
                'valeur_variable' => $article->articles_valeur_variable ? 1 : 0,
                'valeur' => $article->articles_valeur,
                'valeur_min' => $article->articles_valeur_min,
                'valeur_max' => $article->articles_valeur_max,
                'valeur_restockage' => $article->articles_restockage ? 1 : 0,
                'valeur_cumulable' => $article->articles_cumulable ? 1 : 0,
                'nb_cumulable' => $article->articles_nb_cumulable,
                'plafond' => $article->articles_plafond,
                'famille_tva' => $article->articles_familletva,
                'tva' => $article->articles_tva,
                'nb_jours' => $article->nb_jours,
                'assurance' => $article->assurance,
                'caution' => $article->caution,
                'name_fr' => $article->articles_nom_fr,
                'name_en' => $article->articles_nom_en,
                'descriptif' => $article->articles_descriptif,
                'descriptif_data' => $article->articles_descriptif_data,
                'detail_fr' => $article->articles_detail_fr,
                'detail_en' => $article->articles_detail_en,
                'placement' => $article->articles_placement,
                'plan_placement' => $article->articles_plan_placement ? 1 : 0,
                'condition_tarifaire' => $article->articles_conditions_tarifaires,
                'url_rechargement' => $article->articles_url_rechargement,
                'url' => $article->articles_url,
                'image' => $article->articles_image,
                'image_choix_rapide' => $article->articles_image_choix_rapide,
                'image_choix_plan' => $article->articles_image_choix_plan,
                'image_plan_placement' => $article->articles_image_plan_placement,
                'date_libre' => $article->articles_date_libre,
                'date_debut' => $article->articles_date_debut ? Carbon::createFromTimestamp(strtotime($article->articles_date_debut)) : null,
                'date_fin' => $article->articles_date_fin ? Carbon::createFromTimestamp(strtotime($article->articles_date_fin)) : null,
                'heure_debut' => $article->articles_heure_debut,
                'heure_fin' => $article->articles_heure_fin,
                'age_min' => $article->articles_age_min,
                'age_max' => $article->articles_age_max,
                'condition_fr' => null,
                'condition_en' => null,
                'info_verite_fr' => $article->articles_infos_verite,
                'info_verite_en' => $article->articles_infos_verite,
                'pack' => $article->articles_pack ? : 1,
                'minimum_cmd' => $article->articles_minimum_cmd ,
                'multiple_cmd' => $article->articles_multiple_cmd,
                'support' => $article->articles_support,
                'assurance_non_disponible' => $article->articles_assurance_non_disponible ? 1 : 0,
                'nom_required' => $article->articles_nom_obligatoire ? 1 : 0,
                'prenom_required' => $article->articles_prenom_obligatoire ? 1 : 0,
                'naissance_required' => $article->articles_naissance_obligatoire ? 1 : 0,
                'date_jour_required' => $article->articles_date_jour_obligatoire ? 1 : 0,
                'prevente' => $article->articles_prevente ? 1 : 0,
                'dedie' => $article->articles_dedie ? 1 : 0,
                'invisible' => $article->articles_invisibleweb ? 1 : 0,
                'actif' => $article->articles_actif ? 1 : 0,
                'created_at' => Carbon::createFromTimestamp(strtotime($article->articles_date_creation)),
                'updated_at' => Carbon::createFromTimestamp(strtotime($article->articles_date_modification)),
                'genre_id' => $genre->id,
                'sub_genre_id' => $subgenre->id,
                'catalogue_id' => $catalogue->id
            ]);

            $callTarifs = $client->GET_ARTICLE_TARIFS([
                'partenaire_id' => config('ce.ce_id'),
                'articles_id' => $dataArticle->uuid
            ]);
            $tarifs = simplexml_load_string($callTarifs->GET_ARTICLE_TARIFSResult->any);

            foreach ($tarifs as $tarif) {
                ArticleTarif::create([
                    'date_debut' => $tarif->date_debut ? Carbon::createFromTimestamp(strtotime($tarif->date_debut)) : null,
                    'date_fin' => $tarif->date_fin ? Carbon::createFromTimestamp(strtotime($tarif->date_fin)) : null,
                    'place_code' => $tarif->categorie_place_code,
                    'place_nom' => $tarif->categorie_place_nom,
                    'place_nom_court' => $tarif->categorie_place_nom_court,
                    'nature_client_id' => $tarif->nature_client_id,
                    'nature_client_nom' => $tarif->nature_client_nom,
                    'nb_place_limite' => $tarif->nb_places_limitees ? 1 : 0,
                    'prix_ht' => $tarif->prix_ht,
                    'prix_ttc' => $tarif->prix_ttc,
                    'valeur' => $tarif->valeur,
                    'article_id' => $dataArticle->id
                ]);
            }

            $bar->advance();
        }
        $bar->finish();
        return 0;
    }
}
