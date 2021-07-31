<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('produk_id')->nullable()->index();
            $table->unsignedInteger('bahan_id')->nullable()->index();
            $table->text('keterangan')->nullable();
            $table->date('tanggal')->nullable()->index();
            $table->string('jumlah')->nullable();
            $table->string('harga')->nullable();
            $table->string('status', 2)->default('0')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->string('alasan_cancel')->nullable();
            $table->string('alasan_retur')->nullable();
            $table->string('bukti_pembayaran_retur')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('produk_id')
                    ->references('id')
                    ->on('produk')
                    ->onDelete('cascade');

            $table->foreign('bahan_id')
                    ->references('id')
                    ->on('bahan')
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
        Schema::dropIfExists('pesanan');
    }
}
