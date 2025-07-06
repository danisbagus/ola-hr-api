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
            $table->string(column: 'name');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('division_id')->index();
            $table->string('employee_number')->unique();
            $table->string('phone_number')->nullable();
            $table->enum('employment_status', ['PERMANENT', 'CONTRACT', 'INTERNSHIP'])->default('PERMANENT');
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('hire_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('division_id')->references('id')->on('divisions');
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
