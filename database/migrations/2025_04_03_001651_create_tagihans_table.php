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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->index();
            $table->foreignId('user_id')->index();
            $table->integer('kelas')->nullable();
            $table->date('tanggal_tagihan');
            $table->date('tanggal_jatuh_tempo');
            $table->double('jumlah_biaya');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['baru', 'angsur', 'lunas']);
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
        Schema::dropIfExists('tagihans');
    }
};
