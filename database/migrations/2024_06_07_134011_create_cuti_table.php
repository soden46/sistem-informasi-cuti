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
        Schema::create('cuti', function (Blueprint $table) {
            $table->char('no_cuti', 5)->primary();
            $table->char('npp', 5)->nullable();
            $table->char('id_jenis_cuti', 5)->nullable();
            $table->date('tgl_pengajuan');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->string('durasi', 3);
            $table->text('keterangan', 50);
            $table->string('stt_cuti', 50);
            $table->text('ket_reject');
            $table->timestamps();

            $table->foreign('id_jenis_cuti')
                ->references('id_jenis_cuti')
                ->on('jenis_cuti')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->foreign('npp')
                ->references('npp')
                ->on('employee')
                ->onUpdate('set null')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuti');
    }
};
