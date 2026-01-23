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
        Schema::table('leave_types', function (Blueprint $table) {
              $table->string('code',10)->nullable()->after('name');
                $table->boolean('is_paid')->default(1)->after('max_days');
                $table->boolean('allow_half')->default(0)->after('is_paid');
                $table->boolean('allow_short')->default(0)->after('allow_half');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_types', function (Blueprint $table) {
            //
        });
    }
};