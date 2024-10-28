<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Producto extends Model
{
    use HasFactory; // Asegúrate de usar el trait HasFactory si necesitas factory en el futuro

    protected $fillable = ['nombre', 'descripcion', 'precio', 'marca_id', 'categoria_id'];

    protected $table = 'productos'; // Opcional si sigue la convención

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedores::class, 'productos_proveedores', 'producto_id', 'proveedor_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_productos', 'producto_id', 'usuario_id')
                    ->withTimestamps(); // Opcional: para mantener las marcas de tiempo
    }

}
