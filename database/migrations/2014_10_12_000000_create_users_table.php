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
            $table->string('surname');
            $table->string('othername');
            $table->string('username');
            $table->string('email')->unique();
            $table->bigInteger('phone')->default(0);
            $table->string('password');
            $table->string('gender');
            $table->integer('birthDay');
            $table->string('birthMonth');
            $table->integer('birthYear');
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->boolean('isOnline')->default(false);
            $table->boolean('isActive')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->text('profileImage', 500);
            $table->string('coverImage')->nullable();
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
