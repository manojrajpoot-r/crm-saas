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
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_type')->nullable(); // sms | whatsapp | email | google
            $table->string('otp_hash')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->integer('otp_attempts')->default(0);
});
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
              $table->dropColumn([
            'phone',
            'two_factor_enabled',
            'two_factor_type',
            'otp_hash',
            'otp_expires_at',
            'otp_attempts',
        ]);
        });
    }
};
