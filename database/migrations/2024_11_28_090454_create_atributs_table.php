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
        Schema::create('atributs', function (Blueprint $table) {
            $table->id('id_atributs');
            $table->unsignedBigInteger('id_reels');
            $table->unsignedBigInteger('id_users'); 
            $table->string('type');
            $table->string('desc')->nullable();
            $table->timestamps();
        
            // Foreign key
            $table->foreign('id_reels')->references('id_reels')->on('reels')->onDelete('cascade');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atributs');
    }
};
