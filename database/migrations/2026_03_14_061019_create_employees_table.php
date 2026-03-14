<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   protected $connection = 'mysql';
   
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
        $table->id();
            $table->string('employee_code',20)->default('0000')->nullable();
            $table->string('name',100)->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('image')->nullable();
            $table->string('gender');
            $table->dateTime('dob');
            $table->text('address');
            $table->string('state');
            $table->string('distric');
            $table->string('city');
            $table->integer('pincode');
            $table->string('company_name');
            $table->string('department');
            $table->string('subdepartment');
            $table->string('designation')->nullable();
            $table->string('employee_type');
            $table->dateTime('joining_date');
            $table->string('salary');
            $table->string('work_location');
            $table->string('experience');
            $table->string('id_proof_type')->nullable();
            $table->string('id_proof_number')->nullable();
            $table->string('id_proof_doccument')->nullable();
            $table->string('address_proof')->nullable();
            $table->string('address_proof_document')->nullable();
            $table->string('collage_name')->nullable();
            $table->string('course')->nullable();
            $table->string('course_document')->nullable();
            $table->string('internship_duration')->nullable();
            $table->integer('status')->default(1);
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