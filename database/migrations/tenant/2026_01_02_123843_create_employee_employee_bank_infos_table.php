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
        Schema::create('employee_employee_bank_infos', function (Blueprint $table) {
            $table->id();
             $table->foreignId('employee_id')->constrained()->onDelete('cascade');

                $table->string('account_name');
                $table->string('bank_name');
                $table->string('account_no');
                $table->string('ifsc');
                $table->string('pan_no')->nullable();
                $table->string('uan_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_employee_bank_infos');
    }
};