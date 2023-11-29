<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_products', function (Blueprint $table) {
            $table->id();
            $table->text('product');
            $table->text('technique');
            $table->decimal('prices_techniques', 8, 2)->nullable();
            $table->integer('color_logos');
            $table->decimal('costo_indirecto', 8, 2);
            $table->decimal('utilidad', 8, 2)->nullable();
            $table->integer('dias_entrega');
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 8, 2)->nullable();
            $table->decimal('precio_total', 12, 2)->nullable();
            $table->boolean('quote_by_scales')->default(false);
            $table->text('scales_info')->nullable();
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
        Schema::dropIfExists('quote_products');
    }
}
