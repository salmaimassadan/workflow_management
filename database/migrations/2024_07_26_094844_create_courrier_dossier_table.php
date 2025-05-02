<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourrierDossierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courrier_dossier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained()->onDelete('cascade');
            $table->foreignId('dossier_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('courrier_dossier');
    }
}
