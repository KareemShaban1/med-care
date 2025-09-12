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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); 
            $table->string('model'); 
            $table->unsignedBigInteger('model_id'); 
            $table->json('changes')->nullable(); 
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('additional_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
