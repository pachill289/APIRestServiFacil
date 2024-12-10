<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('usuario', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('clave', 500);
            $table->integer('tipo')->check('tipo IN (1, 2, 3)');
            $table->string('cargo', 255);
            $table->string('correo', 50);
            $table->integer('telefono')->nullable();
            $table->integer('celular');
            $table->date('fecha_nacimiento');
            $table->string('direccion', 500);
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('usuario');
    }
}

?>