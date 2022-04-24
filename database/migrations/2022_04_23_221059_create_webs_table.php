<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::create('webs', function (Blueprint $table) {
                $table->id();
                $table->string('logo', '200');
                $table->string('primary_color', '50')->nullable();
                $table->string('name', '200');
                $table->text('description')->nullable();
                $table->string('tagline', '200')->nullable();
                $table->string('address', '200')->nullable();
                $table->string('phone', '20')->nullable();
                $table->string('email', '100')->nullable();
                $table->string('github', '100')->nullable();
                $table->string('instagram', '100')->nullable();
                $table->string('whatsapp', '100')->nullable();
                $table->unsignedBigInteger('updator');
                $table->foreign('updator')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('webs');
    }
}
