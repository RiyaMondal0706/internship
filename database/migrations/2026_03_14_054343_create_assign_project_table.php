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
        Schema::create('assign_project', function (Blueprint $table) {
            $table->id();
            $table->string('designation')->default('employee')->nullable();
            $table->integer('employee_id')->default(0);
            $table->string('project_id', 11)->default(0);
            $table->text('work');
            $table->dateTime('created_at');
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_project');
    }
};