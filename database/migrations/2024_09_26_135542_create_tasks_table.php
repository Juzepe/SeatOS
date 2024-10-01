<?php

use App\Enums\TaskStatus;
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
            $table->ulid('id')->primary();
            $table->foreignUlid('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignUlid('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->date('due_date');
            $table->enum('status', array_column(TaskStatus::cases(), 'value'))
                ->default(TaskStatus::NEW->value);
            $table->timestamps();

            $table->index('status');
            $table->index('due_date');
            $table->index(['title', 'description']);
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
