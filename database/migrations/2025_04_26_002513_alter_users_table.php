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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name']);
            $table->unsignedInteger('role_id');
            $table->boolean('is_active');
            $table->softDeletesTz();

            $table->timestampTz('created_at')->nullable()->change();
            $table->timestampTz('updated_at')->nullable()->change();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);

            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();

            $table->dropColumn(['role_id', 'is_active', 'deleted_at']);

            $table->string('name');
        });
    }
};
