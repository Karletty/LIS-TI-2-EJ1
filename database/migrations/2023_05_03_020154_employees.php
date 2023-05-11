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
                  $table->unsignedBigInteger('user_id')->unique();
                  $table->string('company_id',6)->charset('utf8mb4')->nullable();
                  $table->foreign('user_id')->references('id')->on('users');
                  $table->foreign('company_id')->references('company_id')->on('companies');
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
