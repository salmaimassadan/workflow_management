<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDossiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('dossiers', function (Blueprint $table) {
        $table->dropColumn('status');  // Remove the status column
        $table->text('description')->nullable();  // Add a description column
        $table->unsignedBigInteger('courrier_id')->nullable();  // Add a foreign key for courriers

        // Create a foreign key relationship to the courriers table
        $table->foreign('courrier_id')->references('id')->on('courriers')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('dossiers', function (Blueprint $table) {
        $table->string('status')->default('clos');  // Add back the status column if rollback is needed
        $table->dropForeign(['courrier_id']);  // Drop foreign key
        $table->dropColumn(['description', 'courrier_id']);  // Remove new columns
    });
}

}
