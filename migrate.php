<?php

require __DIR__ . '/config/database.php';

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Filesystem\Filesystem;

$files = new Filesystem();
$repository = new DatabaseMigrationRepository($capsule->getDatabaseManager(), 'migrations');

if (! $repository->repositoryExists()) {
    $repository->createRepository();
}

$migrator = new Migrator($repository, $capsule->getDatabaseManager(), $files);

// Detectar argumentos pasados por la línea de comandos
$action = $argv[1] ?? 'migrate'; // Acción por defecto: 'migrate'

switch ($action) {
    case 'migrate':
        $migrator->run(__DIR__ . '/migrations');
        echo "Migraciones ejecutadas con éxito.\n";
        break;

    case 'rollback':
        $steps = $argv[2] ?? 1; // Por defecto, un paso atrás
        $migrator->rollback(__DIR__ . '/migrations', ['step' => $steps]);
        echo "Migraciones revertidas con éxito.\n";
        break;

    case 'status':
        $ran = $migrator->getRepository()->getRan();
        $pending = $migrator->getMigrationFiles(__DIR__ . '/migrations');
        echo "Migraciones aplicadas:\n";
        foreach ($ran as $migration) {
            echo "- $migration\n";
        }
        echo "\nMigraciones pendientes:\n";
        foreach (array_diff(array_keys($pending), $ran) as $migration) {
            echo "- $migration\n";
        }
        break;

    default:
        echo "Acción no reconocida. Usa 'migrate', 'rollback' o 'status'.\n";
}
?>
