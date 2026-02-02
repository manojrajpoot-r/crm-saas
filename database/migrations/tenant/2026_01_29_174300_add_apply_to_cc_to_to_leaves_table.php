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
        Schema::table('leaves', function (Blueprint $table) {
        $table->unsignedBigInteger('apply_to')->nullable()->after('user_id');
        $table->json('cc_to')->nullable()->after('apply_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
              Schema::table('leaves', function (Blueprint $table) {
                $table->dropColumn(['apply_to','cc_to']);
            });
        });
    }
};
