<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_supports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('message');
            $table->integer('emisor_id')->nullable();
            $table->integer('seller_id')->nullable();
            $table->integer('received_id')->nullable();
            $table->integer('id_proceso_compra')->nullable();
            $table->string('type_proceso_compra')->nullable();
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
        Schema::dropIfExists('comments_supports');
    }
}
