<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentQuotesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_quotes_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('current_quote_id')->constrained('current_quotes');
            $table->integer('product_id');
            $table->integer('price_technique')->constrained('prices_techniques');
            $table->integer('color_logos');
            $table->integer('dias_entrega');
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 8, 2)->nullable();
            $table->decimal('precio_total', 12, 2)->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('current_quotes');
    }
}
