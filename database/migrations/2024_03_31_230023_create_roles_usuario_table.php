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
        Schema::create('rsg_roles_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IN_USUARIO_ID')->constrained('rsg_users','id');
            $table->foreignId('IN_ROL_ID')->constrained('rsg_roles','id');
            $table->boolean('BT_ESTADO_FILA');
            $table->string('VC_USUARIO_CREACION');
            $table->string('VC_USUARIO_MODIFICACION')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsg_roles_usuario');
    }
};
