<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices_techniques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('size_material_technique_id')->constrained('size_material_technique');
            $table->integer('escala_inicial');
            $table->integer('escala_final')->nullable();
            $table->decimal('precio', 8, 2);
            $table->enum('tipo_precio', ['F', 'D']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices_techniques');
    }
}
