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
        Schema::create('sub_genres', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->boolean('open')->default(true);
            $table->timestamp('date_open')->nullable();
            $table->string('info_open')->nullable();
            $table->string('url_info')->nullable();
            $table->string('url_resa')->nullable();
            $table->string('url')->nullable();
            $table->string('descriptif')->nullable();
            $table->string('descriptif_data')->nullable();
            $table->string('logo')->nullable();
            $table->string('plan')->nullable();
            $table->string('postal')->nullable();
            $table->string('format_keycard')->nullable();
            $table->boolean('sejour')->default(false);
            $table->string('provider_url')->nullable();
            $table->string('provider_code')->nullable();
            $table->integer('lieux_id')->nullable();
            $table->string('lieux_latitude')->nullable();
            $table->string('lieux_longitude')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->foreignId('genre_id')
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
        Schema::dropIfExists('sub_genres');
    }
};
