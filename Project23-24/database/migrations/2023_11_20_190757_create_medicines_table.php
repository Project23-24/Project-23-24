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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->timestamps();
            $table->string('sname')->nullable();
            $table->string('cname')->nullable();
            $table->string('manufacturer')->nullable();
            $table->timestamp('edate')->nullable();
            $table->integer('remain')->nullable();
            $table->integer('cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
