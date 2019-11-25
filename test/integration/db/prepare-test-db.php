<?php

use FruitCompany\Config;

require_once __DIR__ . '/../../../vendor/autoload.php';

$dbParams = Config::get()['db'];
$params = array_map('escapeshellarg', $dbParams);

$structure = __DIR__ . '/structure.sql';

// dump structure from application database
$command = "mysqldump -h {$params['host']} -u {$params['username']} -p{$params['password']}" .
    " --port={$params['port']} -t --no-data {$params['database']} > $structure";

// load structure into test database
$command = "mysql -h {$params['host']} -u {$params['username']} -p{$params['password']}" .
    " --port={$params['port']} -t --xml {$params['database']}_test < $structure";

$output = shell_exec($command);
