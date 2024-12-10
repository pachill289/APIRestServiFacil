<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model {
    protected $table = 'publicacion';
    protected $fillable = [
        'id_usuario', 'titulo_servicio', 'tipo', 'descripcion', 'costo', 'url_imagen', 'fecha_validez'
    ];
    public $timestamps = false;

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
}

?>