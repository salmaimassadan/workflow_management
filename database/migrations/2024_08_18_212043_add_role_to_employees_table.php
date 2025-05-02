<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->string('role')->default('secrétaire'); // Add role column with default value
    });
}

public function down()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}

}
