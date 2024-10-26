<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
