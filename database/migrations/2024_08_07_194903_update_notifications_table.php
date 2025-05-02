<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('courrier_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('message')->nullable();
            $table->date('deadline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['courrier_id']);
            $table->dropColumn('courrier_id');

            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');

            

            $table->dropColumn('message');
            $table->dropColumn('deadline');
        });
    }
}
