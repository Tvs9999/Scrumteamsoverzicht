<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scrumteam_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scrumteam_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('scrumteam_id')->references('id')->on('scrumteams');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrumteam_user');
    }
};
