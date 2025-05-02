<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('responses', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('courrier_id');
        $table->text('content');
        $table->unsignedBigInteger('created_by');
        $table->timestamps();

        $table->foreign('courrier_id')->references('id')->on('courriers')->onDelete('cascade');
        $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responses');
    }
}
