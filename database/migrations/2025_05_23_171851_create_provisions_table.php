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
        Schema::create('provisions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['pull-out', 'push-in', 'reduced-curriculum'])->nullable();
            $table->enum('length', ['3-weeks', '6-weeks', 'one-term', 'year-round'])->nullable();
            $table->enum('support_level', ['low', 'moderate', 'intensive'])->nullable();
            $table->integer('students_count')->default(0);
            $table->boolean('includes_with_plans')->default(false);
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->foreignId('created_by_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provisions');
    }
};
