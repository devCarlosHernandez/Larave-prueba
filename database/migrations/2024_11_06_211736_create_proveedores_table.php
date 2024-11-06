<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();  // BigInt UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre');
            $table->text('direccion');
            $table->string('telefono', 20)->nullable();
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
