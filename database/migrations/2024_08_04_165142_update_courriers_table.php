<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUserAndServiceFromCourriers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // Check and drop foreign key constraints and columns if they exist
            if (Schema::hasColumn('courriers', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('courriers', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }

            // Add unique constraint to the 'reference' column
            $table->string('reference')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // Add columns and foreign keys back if they do not exist
            if (!Schema::hasColumn('courriers', 'user_id')) {
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('courriers', 'service_id')) {
                $table->unsignedBigInteger('service_id');
                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            }

            // Remove unique constraint from the 'reference' column
            $table->dropUnique(['reference']);
        });
    }
}
