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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('telephone');
            $table->string('bvn');
            $table->date('dob');
            $table->string('residential_address');
            $table->string('state');
            $table->string('bankcode');
            $table->string('accountnumber');
            $table->unsignedBigInteger('company_id');
            $table->string('email')->unique();
            $table->string('city');
            $table->string('country');
            $table->string('id_card')->nullable();
            $table->string('voters_card')->nullable();
            $table->string('drivers_licence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
