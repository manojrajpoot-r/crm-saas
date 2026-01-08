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
        Schema::create('employee_addresses', function (Blueprint $table) {
            $table->id();
             $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');

                $table->text('present_address')->nullable();
                $table->string('present_landmark')->nullable();
                $table->string('present_zipcode', 10)->nullable();
                $table->string('present_country')->nullable();
                $table->string('present_state')->nullable();
                $table->string('present_city')->nullable();

                $table->text('permanent_address')->nullable();
                $table->string('permanent_landmark')->nullable();
                $table->string('permanent_zipcode', 10)->nullable();
                $table->string('permanent_country')->nullable();
                $table->string('permanent_state')->nullable();
                $table->string('permanent_city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_addresses');
    }
};