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
        Schema::create('article_tarifs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_debut')->nullable();
            $table->timestamp('date_fin')->nullable();
            $table->string('place_code')->nullable();
            $table->string('place_nom')->nullable();
            $table->string('place_nom_court')->nullable();
            $table->string('nature_client_id')->nullable();
            $table->string('nature_client_nom')->nullable();
            $table->boolean('nb_place_limite')->default(false);
            $table->float('prix_ht')->nullable();
            $table->float('prix_ttc')->nullable();
            $table->float('valeur')->nullable();

            $table->foreignId('article_id')
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
        Schema::dropIfExists('article_tarifs');
    }
};
