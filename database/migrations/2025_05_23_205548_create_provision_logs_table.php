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
        Schema::create('provision_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provision_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by_id')->constrained('users')->onDelete('cascade');
            $table->text('entry');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provision_logs');
    }
};
