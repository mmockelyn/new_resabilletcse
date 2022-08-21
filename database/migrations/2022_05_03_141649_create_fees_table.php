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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->string('nom_fr')->nullable();
            $table->string('nom_en')->nullable();
            $table->float('puht')->nullable();
            $table->float('puttc')->nullable();
            $table->string('familletva')->nullable();
            $table->string('tva')->nullable();
            $table->boolean('par_cmd')->default(false);
            $table->boolean('plafond')->default(false);
            $table->string('champ_api')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
};
