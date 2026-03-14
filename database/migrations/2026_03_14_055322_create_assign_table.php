<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   protected $connection = 'mysql';
   
    public function up(): void
    {
        Schema::create('assign', function (Blueprint $table) {
             $table->id();
            $table->string('assign_type');
            $table->integer('mentor_id');
            $table->integer('employee_id');
            $table->dateTime('created_at');
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign');
    }
};