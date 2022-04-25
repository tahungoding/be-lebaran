<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKecelakaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kecelakaan', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi');
            $table->text('ringkas_kejadian');
            $table->text('detail_kejadian');
            $table->string('file_pendukung')->nullable();
            $table->string('waktu');
            $table->double('latitude');
            $table->double('longitude');
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
        Schema::dropIfExists('kecelakaan');
    }
}
