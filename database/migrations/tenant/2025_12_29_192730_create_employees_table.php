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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
               $table->foreignId('user_id')
          ->constrained('users')
          ->onDelete('cascade');
                $table->string('employee_id', 30)->unique();

                $table->string('first_name', 50);
                $table->string('last_name', 50)->nullable();

                $table->string('phone', 20);
                $table->string('emergency_phone', 20)->nullable();

                $table->date('dob')->nullable();
                $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();

                $table->string('personal_email')->nullable();
                $table->string('corporate_email')->unique();

                $table->foreignId('department_id')->nullable()->constrained('departments');
                $table->foreignId('designation_id')->nullable()->constrained('designations');

                $table->foreignId('report_to')->nullable()->constrained('employees');

                $table->date('join_date')->nullable();
                $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};