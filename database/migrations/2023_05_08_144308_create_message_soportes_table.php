<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageSoportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_soportes', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->integer('receiver_id')->nullable();
            $table->integer('emisor_id');
            $table->integer('soporte_id')->nullable();
            $table->integer('client_id');
            $table->boolean('is_read');
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
        Schema::dropIfExists('message_soportes');
    }
}
