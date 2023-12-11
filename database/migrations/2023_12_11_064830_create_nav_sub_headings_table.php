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
        Schema::create('nav_sub_headings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nav_headings_id');
            $table->string('name');
            $table->timestamps();

            // Foreign keys
            $table->foreign('nav_headings_id')
            ->references('id')
            ->on('nav_headings')
            ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nav_sub_headings');
    }
};
