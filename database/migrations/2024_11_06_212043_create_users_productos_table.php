<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersProductosTable extends Migration
{
    public function up()
    {
        Schema::create('users_productos', function (Blueprint $table) {
            $table->id();  // BigInt UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_productos');
    }
}
