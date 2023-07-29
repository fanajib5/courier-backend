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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id('id');
            $table->string('email')->unique();
            $table->string('name');
            $table->date('DOB');
            $table->string('phone');
            $table->enum('status', ['Active', 'Disabled'])->default('Active');
            $table->date('DOJ');
            $table->integer('level');
            $table->integer('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
