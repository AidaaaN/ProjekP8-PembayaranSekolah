<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihans')->index();
            $table->foreignId('siswa_id')->index();
            $table->dateTime('tanggal_bayar');
            $table->string('status_konfirmasi')->nullable();
            $table->double('jumlah_dibayar');
            $table->string('bukti_bayar')->nullable();
            $table->string('metode_pembayaran');
            $table->string('dibayar_oleh');
            $table->foreignId('user_id')->nullable();
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
        Schema::dropIfExists('pembayarans');
    }
};
