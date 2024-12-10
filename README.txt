Comandos:

realizar migraciones

php migrate.php

levantar el servidor

php -S localhost:8080 -t public/

Migraciones:

Ejecuta las migraciones pendientes (crear tablas en la base de datos)

php migrate.php migrate

Muestra las migraciones aplicadas y las migraciones pendientes

php migrate.php status

Ejecuta un rollback para las migraciones aplicadas

php migrate.php rollback [numero de migraciones para ser revertidas]