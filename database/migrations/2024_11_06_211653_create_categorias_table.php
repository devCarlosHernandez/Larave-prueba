<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();  // BigInt UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre');
            $table->text('descripcion');
            $table->timestamps(0);  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
