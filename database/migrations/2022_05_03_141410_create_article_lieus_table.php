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
        Schema::create('article_lieus', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('address')->nullable();
            $table->string('addressbis')->nullable();
            $table->string('postal')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('pays')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

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
        Schema::dropIfExists('article_lieus');
    }
};
