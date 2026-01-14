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
        $table->unsignedBigInteger('role_id')->nullable();
        $table->string('name');
        $table->string('email')->index();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->string('profile')->nullable();
        $table->tinyInteger('status')->default(1);
        $table->boolean('two_factor_enabled')->default(0);
        $table->string('two_factor_type')->nullable();
        $table->string('otp_hash')->nullable();
        $table->timestamp('otp_expires_at')->nullable();
        $table->integer('otp_attempts')->default(0);
        $table->string('phone')->nullable();
        $table->string('sms_otp')->nullable();
        $table->timestamp('sms_otp_expires_at')->nullable();
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