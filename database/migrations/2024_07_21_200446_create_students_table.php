<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
        $table->string('username');   // Utilisation du type de colonne string pour le champ username
        $table->string('firstname');  // Utilisation du type de colonne string pour le champ firstname
        $table->string('name');       // Utilisation du type de colonne string pour le champ name
        $table->integer('age');       // Utilisation du type de colonne integer pour le champ age
        $table->string('email')->unique(); // Utilisation du type de colonne string pour le champ email, avec l'unicité
        $table->string('password');   // Utilisation du type de colonne string pour le champ password
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
        Schema::dropIfExists('students');
    }
}
