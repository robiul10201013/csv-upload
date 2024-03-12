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
            $table->id('emp_id'); // Assuming 'Emp ID' is the primary key
            $table->string('name_prefix');
            $table->string('first_name');
            $table->string('middle_initial')->nullable(); // Assuming 'Middle Initial' can be null
            $table->string('last_name');
            $table->enum('gender', ['M', 'F']); // Assuming 'Gender' is stored as 'M' or 'F'
            $table->string('email')->unique();
            $table->date('date_of_birth');
            $table->time('time_of_birth');
            $table->integer('age_in_years');
            $table->date('date_of_joining');
            $table->integer('age_in_company_years');
            $table->string('phone_no');
            $table->string('place_name');
            $table->string('county');
            $table->string('city');
            $table->string('zip');
            $table->string('region');
            $table->string('user_name')->unique();
            $table->timestamps();
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
