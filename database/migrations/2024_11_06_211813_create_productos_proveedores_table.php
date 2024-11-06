<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosProveedoresTable extends Migration
{
    public function up()
    {
        Schema::create('productos_proveedores', function (Blueprint $table) {
            $table->id();  // BigInt UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos_proveedores');
    }
}
