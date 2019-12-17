<?php

use FruitCompany\Config;

require_once __DIR__ . '/../../../vendor/autoload.php';

$params = Config::get()['db'];

$structure = __DIR__ . '/structure.sql';

// dump structure from application database
$command = "mysqldump -h {$params['host']} -u {$params['username']} -p{$params['password']}" .
    " --port={$params['port']} --no-data {$params['database']} > $structure";

$output = shell_exec($command);

// load structure into test database
$command = "mysql -h {$params['host']} -u {$params['username']} -p{$params['password']}" .
    " --port={$params['port']} {$params['database']}_test < $structure";

$output .= shell_exec($command);

echo $output;
