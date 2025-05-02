<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->enum('type', ['entrant', 'sortant']);
            $table->string('subject');
            $table->text('content');
            $table->enum('status', ['non lu', 'lu', 'traité', 'urgent', 'archivé']);
            $table->string('sender');
            $table->string('recipient');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('courriers');
    }
}
