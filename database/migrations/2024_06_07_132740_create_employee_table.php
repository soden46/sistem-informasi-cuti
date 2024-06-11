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
        Schema::create('employee', function (Blueprint $table) {
            $table->char('npp', 5)->primary();
            $table->char('id_divisi', 5)->nullable();
            $table->string('nama_emp', 20);
            $table->enum('jk_emp', ['Laki-Laki', 'Perempuan']);
            $table->string('jabatan', 50);
            $table->text('alamat');
            $table->string('hak_akses', 20);
            $table->integer('jml_cuti');
            $table->string('password');
            $table->text('foto_emp');
            $table->enum('active', ['Ya', 'Tidak']);
            $table->string('telp_emp', 20);
            $table->timestamps();

            $table->foreign('id_divisi')
                ->references('id_divisi')
                ->on('divisi')
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
