<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserIdForeignKeyInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the existing foreign key constraint if it exists
            $table->dropForeign(['user_id']);

            // Add the new foreign key constraint referencing the `employees` table
            $table->foreign('user_id')->references('id')->on('employees')->onDelete('cascade');
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
            // Drop the foreign key constraint added in the `up` method
            $table->dropForeign(['user_id']);
            
            // Optionally, if needed, you can revert to the previous state
            // Assuming the previous foreign key was referencing `users`
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
