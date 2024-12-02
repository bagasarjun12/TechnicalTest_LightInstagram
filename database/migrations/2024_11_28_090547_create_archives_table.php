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
        Schema::create('archives', function (Blueprint $table) {
            $table->id('id_archives');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_images');
            $table->string('caption');
            $table->integer('like');
            $table->datetime('upload_date');
            $table->timestamps();
        
            // Foreign key
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_images')->references('id_images')->on('images')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
