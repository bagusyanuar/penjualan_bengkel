<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pembelian_id')->unsigned()->nullable();
            $table->bigInteger('barang_id')->unsigned();
            $table->integer('qty')->default(0);
            $table->integer('harga')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
            $table->foreign('pembelian_id')->references('id')->on('pembelian');
            $table->foreign('barang_id')->references('id')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_detail');
    }
}
