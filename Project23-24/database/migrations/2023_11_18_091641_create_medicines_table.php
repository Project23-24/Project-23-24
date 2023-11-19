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
            $table->foreignId('Category')->nullable();
            $table->timestamps();
            $table->string('Scientific_Name')->nullable();
            $table->string('Commercial_Name')->nullable();
            $table->string('Manufacturer')->nullable();
            $table->timestamp('Expire_date')->nullable();
            $table->integer('Remaining')->nullable();
            $table->integer('cost')->nullable();
;        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
