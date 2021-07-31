<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->nullable()->index();
            $table->string('nama', 50);
            $table->string('email')->unique()->nullable();
            $table->string('username', 30)->nullable();
            $table->string('password')->nullable();
            $table->string('nohp', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->char('jenis_kelamin')->nullable();
            $table->string('foto', 50)->nullable();
            $table->string('ktp', 50)->nullable();
            $table->string('nama_rekening', 50)->nullable();
            $table->string('no_rekening', 50)->nullable();
            $table->boolean('is_valid')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')
                    ->references('id')
                    ->on('role')
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
        Schema::dropIfExists('users');
    }
}
