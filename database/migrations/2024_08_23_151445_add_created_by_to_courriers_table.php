<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToCourriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('courriers', function (Blueprint $table) {
        // Add the 'created_by' column as an unsigned big integer
        $table->unsignedBigInteger('created_by')->nullable()->after('id');
        
        // Add the foreign key constraint
        $table->foreign('created_by')
              ->references('id')
              ->on('employees')
              ->onDelete('set null'); // or 'cascade' if you want to delete courriers when the employee is deleted

        // Optionally, add an index to the 'created_by' column
        $table->index('created_by');
    });
}


public function down()
{
    Schema::table('courriers', function (Blueprint $table) {
        // Drop the foreign key constraint
        $table->dropForeign(['created_by']);
        
        // Remove the 'created_by' column
        $table->dropColumn('created_by');
    });
}


}
