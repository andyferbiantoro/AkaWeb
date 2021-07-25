<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('paket_id')->nullable();
            $table->string('kategori_pemesanan')->nullable();
            $table->date('tanggal_pemesanan')->nullable();
            $table->date('tanggal_berkunjung')->nullable();
            $table->time('pukul_kunjungan')->nullable();
            $table->integer('jumlah_pengunjung');
            $table->integer('jumlah_pembayaran');
            $table->integer('status_pemesanan')->nullable();
            $table->integer('nomor_pemesanan');
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paket_id')->references('id')->on('pakets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanans');
    }
}