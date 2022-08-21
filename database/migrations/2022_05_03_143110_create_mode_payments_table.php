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
        Schema::create('mode_payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('code')->nullable();
            $table->string('reglement')->nullable();
            $table->boolean('redirection')->default(true);
            $table->string('nom_fr')->nullable();
            $table->string('nom_en')->nullable();
            $table->text('indic_fr')->nullable();
            $table->text('indic_en')->nullable();
            $table->string('ordre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mode_payments');
    }
};
