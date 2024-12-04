<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Integer;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alquilers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            $table->foreignId('users_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('img_path_garangia')->nullable();
            $table->string('tipo_garantia');
            $table->string('descripcion_garantia')->nullable()->default('N/A');
            $table->decimal('valor_garantia')->nullable()->default(0);
            $table->decimal('precio_alquiler', 10, 2);
            $table->dateTime('fecha_alquiler');
            $table->date('fecha_devolucion');
            $table->enum('estado', ['pendiente', 'en_progreso', 'finalizado', 'cancelado'])->default('pendiente');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquilers');
    }
};
