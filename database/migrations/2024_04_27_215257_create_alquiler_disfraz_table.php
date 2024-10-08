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
        Schema::create('alquiler_disfraz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alquiler_id')->constrained('alquilers')->onDelete('cascade');
            $table->foreignId('disfraz_id')->constrained('disfrazs')->onDelete('cascade');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquiler_disfraz');
    }
};
