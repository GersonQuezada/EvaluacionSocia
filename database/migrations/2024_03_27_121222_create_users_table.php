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
        Schema::create('rsg_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('VC_CELULAR')->nullable();
            // $table->dateTime('DT_EXPIRACION_PASSWORD')->nullable();
            $table->boolean('BT_ESTADO_FILA')->nullable();
            $table->string('VC_USUARIO_CREACION')->nullable();
            $table->string('VC_USUARIO_MODIFICACION')->nullable();
            $table->boolean('BT_ACT_PASSWORD_OBLIGATORIO')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsg_users');
    }
};
