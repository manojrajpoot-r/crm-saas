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
        Schema::create('employee_personal_infos', function (Blueprint $table) {
            $table->id();
             $table->foreignId('employee_id')->constrained()->onDelete('cascade');
                $table->string('passport_no')->nullable();
                $table->date('passport_expiry')->nullable();
                $table->string('identity_no')->nullable();
                $table->string('nationality')->nullable();
                $table->string('religion')->nullable();
                $table->string('marital_status')->nullable();
                $table->string('spouse_name')->nullable();
                $table->integer('children')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_personal_infos');
    }
};