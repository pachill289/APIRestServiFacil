<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {
    protected $table = 'usuario';
    protected $fillable = [
        'id', 'nombres', 'apellidos', 'clave', 'tipo', 'cargo', 'correo', 'telefono', 'celular', 'fecha_nacimiento', 'direccion'
    ];
    public $timestamps = false;

    public function publicaciones() {
        return $this->hasMany(Publicacion::class, 'id_usuario', 'id');
    }
}

?>
