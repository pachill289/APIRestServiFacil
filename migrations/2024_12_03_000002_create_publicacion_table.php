<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicacionTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('publicacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_usuario', 20);
            $table->string('titulo_servicio', 200);
            $table->string('tipo', 100);
            $table->string('descripcion', 100);
            $table->decimal('costo', 150, 2);
            $table->string('url_imagen', 500)->nullable();
            $table->date('fecha_validez');
            $table->foreign('id_usuario')->references('id')->on('usuario');
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('publicacion');
    }
}

?>