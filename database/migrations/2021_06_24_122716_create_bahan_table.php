<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id')->index();
            $table->string('nama');
            $table->string('jumlah')->default('0');
            $table->string('harga', 50)->default('0');
            $table->string('satuan', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')
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
        Schema::dropIfExists('bahan');
    }
}
