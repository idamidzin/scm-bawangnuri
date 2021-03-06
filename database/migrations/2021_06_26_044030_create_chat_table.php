<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('from_id')->index();
            $table->unsignedInteger('to_id')->index();
            $table->text('pesan')->nullable();
            $table->timestamps();

            $table->foreign('from_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('to_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat');
    }
}
