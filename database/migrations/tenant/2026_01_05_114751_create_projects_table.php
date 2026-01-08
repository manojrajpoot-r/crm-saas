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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->nullable()->comment('fixed,product');
            $table->string('name');
            $table->text('description');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('total_days')->nullable();
            $table->date('actual_start_date')->nullable();

            $table->integer('completion_percent')->nullable();
            $table->integer('hours_allocated')->nullable();

            $table->unsignedBigInteger('created_by')->comment('Created by');

            $table->date('last_updated')->nullable();

            $table->boolean('is_finished')->default(false);
            $table->date('finished_date')->nullable();
            $table->integer('completed_by')->nullable();

            $table->boolean('is_archived')->default(false);
            $table->date('archived_date')->nullable();
            $table->integer('archived_by')->nullable();

            $table->string('remarks');

            $table->enum('status', [
                'created',
                'working',
                'on_hold',
                'finished',
                'maintenance',
                'delay',
                'handover',
                'discontinued',
                'inactive'
            ])->default('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};