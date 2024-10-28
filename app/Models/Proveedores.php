<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'direccion', 'telefono'];

    public function producto()
    {
        return $this->belongsToMany(Producto::class, 'productos_proveedores', 'proveedor_id', 'producto_id');
    }
}
