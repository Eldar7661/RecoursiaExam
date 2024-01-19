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
        Schema::create('postamats', function (Blueprint $table) {
            $table->id();
<<<<<<<< HEAD:database/migrations/2023_11_21_110229_create_postamats_table.php
            $table->tinyInteger('status');
            $table->string('system_id', 8);
            $table->string('address', 255);
            $table->string('serial_number', 10);
========
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
>>>>>>>> feature/task10-posterminal-requests:database/migrations/2014_10_12_000000_create_users_table.php
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postamats');
    }
};
