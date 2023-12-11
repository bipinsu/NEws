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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nav_headings_id');
            $table->unsignedBigInteger('nav_sub_headings_id');
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->timestamps();

             // Foreign keys
             $table->foreign('nav_headings_id')
             ->references('id')
             ->on('nav_headings')
             ->onDelete('cascade');
             $table->foreign('nav_sub_headings_id')
             ->references('id')
             ->on('nav_sub_headings')
             ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
