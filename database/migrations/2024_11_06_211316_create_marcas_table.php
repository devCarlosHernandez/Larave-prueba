<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcasTable extends Migration
{
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();  // BigInt UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre')->unique();  // UNIQUE (nombre)
            $table->timestamps(0);  // created_at, updated_at con precisión de 0
        });
    }

    public function down()
    {
        Schema::dropIfExists('marcas');
    }
}
