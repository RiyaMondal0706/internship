<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        protected $connection = 'mysql_second';
        
    public function up(): void
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('project_title');
            $table->string('project_document')->nullable();
            $table->string('project_department');
            $table->text('technology');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('noe'); // number of employees
            $table->text('description');
            $table->dateTime('created_at');
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};