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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
           $table->string('name');
            $table->text('description')->nullable();

            // 🔹 Project relations (same tenant DB)
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('module_id')
                ->constrained('project_modules')
                ->cascadeOnDelete();

            // 🔹 Users (NO FK – SaaS safe)
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();

            $table->dateTime('assigned_at')->nullable();

            // 🔹 Task meta
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // 🔹 Completion
            $table->boolean('is_completed')->default(false);
            $table->dateTime('completed_at')->nullable();

            // 🔹 Approval (tenant users)
            $table->boolean('is_approved')->default(false);
            $table->dateTime('approved_at')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // 🔹 Status
            $table->boolean('is_assigned')->default(false);

            $table->tinyInteger('status')
                ->default(2)
                ->comment('1-completed, 2-created, 3-decline');

            $table->tinyInteger('task_status')
                ->nullable()
                ->comment('0-pending, 1-started');

            $table->dateTime('started_at')->nullable();

            // 🔹 Post relation flag
            $table->boolean('is_belong_to_post')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};