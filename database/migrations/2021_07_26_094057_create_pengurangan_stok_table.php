<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenguranganStokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengurangan_stok', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_bahan')->nullable()->index();
            $table->string('nama_produk')->nullable()->index();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->string('jumlah')->nullable();
            $table->datetime('tanggal')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::dropIfExists('pengurangan_stok');
    }
}
