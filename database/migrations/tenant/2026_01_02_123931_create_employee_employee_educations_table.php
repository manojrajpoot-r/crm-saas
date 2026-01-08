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
        Schema::create('employee_employee_educations', function (Blueprint $table) {
            $table->id();
              $table->foreignId('employee_id')->constrained()->onDelete('cascade');

                $table->string('institute');
                $table->string('degree');
                $table->string('stream')->nullable();
                $table->date('from_date')->nullable();
                $table->date('to_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_employee_educations');
    }
};