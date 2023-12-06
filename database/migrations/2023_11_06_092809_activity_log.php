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
            // Add the 'user_id' field as a foreign key
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('email');
            $table->string('request_type');
            $table->string('ip_address');
            $table->json('geo_location');
            $table->string('description');
            $table->string('activity_type');
            $table->string('url');
            $table->string('changed_id');
            $table->json('data')->nullable();
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
