<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('no_nota')->unique();
            $table->string('customer');
            $table->integer('sub_total')->default(0);
            $table->integer('diskon')->default(0);
            $table->integer('total')->default(0);
            $table->integer('terbayar')->default(0);
            $table->integer('sisa')->default(0);
            $table->text('keterangan');
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
        Schema::dropIfExists('penjualan');
    }
}
