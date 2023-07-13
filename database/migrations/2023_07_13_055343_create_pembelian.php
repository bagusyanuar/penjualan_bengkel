<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned();
            $table->date('tanggal');
            $table->string('no_nota');
            $table->integer('sub_total')->default(0);
            $table->integer('diskon')->default(0);
            $table->integer('total')->default(0);
            $table->integer('terbayar')->default(0);
            $table->integer('sisa')->default(0);
            $table->text('keterangan');
            $table->timestamps();
            $table->foreign('supplier_id')->references('id')->on('supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}
