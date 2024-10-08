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
        Schema::create('disfrazs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('nroPiezas');
            $table->string('img_path')->nullable();
            $table->string('color');
            $table->string('genero');
            //$table->string('talla');
            $table->integer('edad_min');
            $table->integer('edad_max');
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad');
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disfrazs');
    }
};
