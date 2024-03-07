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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othername')->nullable();
            $table->string('username');
            $table->string('email_address')->unique();
            $table->bigInteger('phone_number')->default(0);
            $table->string('password');
            $table->string('gender');
            $table->integer('birth_day');
            $table->string('birth_month');
            $table->integer('birth_year');
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->boolean('online')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->text('profile_image', 500);
            $table->string('wall_image')->nullable();
            $table->text('bio')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};