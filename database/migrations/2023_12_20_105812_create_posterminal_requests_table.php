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
        Schema::create('posterminal_requests', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0);

            $table->index('posterminal_id');
            $table->foreignId('posterminal_id')
                  ->constrained('posterminals');

            $table->index('theme_id');
            $table->foreignId('theme_id')
                  ->constrained('posterminal_themes');

            $table->index('solution_id');
            $table->foreignId('solution_id')
                  ->nullable()
                  ->constrained('posterminal_solutions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posterminal_requests');
    }
};
