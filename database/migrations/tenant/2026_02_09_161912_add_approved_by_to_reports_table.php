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
    Schema::table('reports', function (Blueprint $table) {
        $table->unsignedBigInteger('approved_by')->nullable()->after('status');
        $table->dateTime('approved_at')->nullable()->after('approved_by');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};