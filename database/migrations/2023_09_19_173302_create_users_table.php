<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('role');
            $table->integer('present');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('email');
            $table->string('activation_key')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('class_id')->references('id')->on('classes');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
