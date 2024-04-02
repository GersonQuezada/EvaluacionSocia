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
        Schema::create('rsg_roles', function (Blueprint $table) {
            $table->id();
            $table->string('VC_DESCRIPCION');
            $table->boolean('BT_ESTADO_FILA');
            $table->string('VC_USUARIO_CREACION');
            $table->string('VC_USUARIO_MODICIACION')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsg_roles');
    }
};
