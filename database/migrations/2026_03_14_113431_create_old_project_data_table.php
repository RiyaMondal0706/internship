<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
           protected $connection = 'mysql_second';
           
    public function up(): void
    {
        Schema::create('old_project_data', function (Blueprint $table) {
               $table->id();
            $table->integer('project_id');
            $table->string('company_name');
            $table->text('project_title');
            $table->string('project_document')->nullable();
            $table->string('project_department');
            $table->string('technology');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('noe');
            $table->text('description');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_project_data');
    }
};