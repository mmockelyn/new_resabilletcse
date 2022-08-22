<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->integer('domain_id')->nullable();
            $table->string('domain')->nullable();
            $table->string('idmanif')->nullable();
            $table->string('name_manif')->nullable();
            $table->string('state_manif')->nullable();
            $table->timestamp('start_manif')->nullable();
            $table->timestamp('end_manif')->nullable();
            $table->timestamp('open_vente')->nullable();
            $table->integer('nb_max_billet')->nullable();
            $table->float('public_price')->nullable();
            $table->float('puht')->nullable();
            $table->float('puttc')->nullable();
            $table->string('remise_btob')->nullable();
            $table->boolean('valeur_variable')->default(true);
            $table->string('valeur')->nullable();
            $table->string('valeur_min')->nullable();
            $table->string('valeur_max')->nullable();
            $table->boolean('valeur_restockage')->default(false);
            $table->boolean('valeur_cumulable')->default(true);
            $table->integer('nb_cumulable')->nullable();
            $table->float('plafond')->nullable();

            $table->string('famille_tva')->nullable();
            $table->float('tva')->nullable();
            $table->string('nb_jours')->nullable();
            $table->string('assurance')->nullable();
            $table->string('caution')->nullable();

            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->string('descriptif')->nullable();
            $table->longText('descriptif_data')->nullable();
            $table->longText('detail_fr')->nullable();
            $table->longText('detail_en')->nullable();
            $table->text('placement')->nullable();
            $table->boolean('plan_placement')->default(true);
            $table->text('condition_tarifaire')->nullable();

            $table->string('url_rechargement')->nullable();
            $table->string('url')->nullable();

            $table->string('image')->nullable();
            $table->string('image_choix_rapide')->nullable();
            $table->string('image_choix_plan')->nullable();
            $table->string('image_plan_placement')->nullable();

            $table->boolean('date_libre')->default(false);

            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();

            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();

            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();

            $table->text('condition_fr')->nullable();
            $table->text('condition_en')->nullable();
            $table->text('info_verite_fr')->nullable();
            $table->text('info_verite_en')->nullable();

            $table->integer('pack')->nullable();
            $table->integer('minimum_cmd')->nullable();
            $table->integer('multiple_cmd')->nullable();

            $table->string('support')->nullable();

            $table->boolean('assurance_non_disponible')->default(false);
            $table->boolean('nom_required')->default(false);
            $table->boolean('prenom_required')->default(false);
            $table->boolean('naissance_required')->default(false);
            $table->boolean('date_jour_required')->default(false);
            $table->boolean('prevente')->default(false);
            $table->boolean('dedie')->default(false);
            $table->boolean('invisible')->default(false);
            $table->boolean('actif')->default(false);

            $table->timestamps();

            $table->foreignId('genre_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

            $table->foreignId('sub_genre_id')
                            ->constrained()
                            ->cascadeOnUpdate()
                            ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
