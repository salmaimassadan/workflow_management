<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToDossiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('courrier_id');
        });
    }

    public function down()
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}
