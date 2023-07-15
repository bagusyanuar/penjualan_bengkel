<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranPiutang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_piutang', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penjualan_id')->unsigned();
            $table->string('no_transaksi')->unique();
            $table->date('tanggal');
            $table->integer('nominal');
            $table->text('keterangan');
            $table->timestamps();
            $table->foreign('penjualan_id')->references('id')->on('penjualan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_piutang');
    }
}
