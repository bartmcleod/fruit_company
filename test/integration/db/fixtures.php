<?php

use FruitCompany\Config;
use FruitCompany\Repository\CultivarRepository;
use FruitCompany\Repository\GenusRepository;
use FruitCompany\Repository\SpeciesRepository;
use FruitCompanyTest\Fixtures;
use FruitCompanyTest\Repository\CultivarRepositoryTest\CultivarRepositoryFixtureCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Pdo as PdoDriver;
use Laminas\Db\Adapter\Platform\Mysql;

require_once __DIR__ . '/../../../vendor/autoload.php';

// @todo: design and configure as a proper console command

// load structure and lookup tables
require __DIR__ . '/prepare-test-db.php';

$dbParams = Config::get()['db'];

$dsn = sprintf(
    'mysql:dbname=%s;host=%s;port=%d;charset=utf8',
    $database = $dbParams['database'] . '_test', // you will never use the production database
    $host = $dbParams['host'],
    $port = $dbParams['port'],
);

$pdo = new PDO($dsn, $dbParams['username'], $dbParams['password']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$driver = new PdoDriver($pdo);
$platform = new Mysql($driver);

// @todo: create a facade for the adapter, just like Config
$adapter = new Adapter($driver, $platform, $queryResultPrototype = null, $profiler = null);

$genusRepository = new GenusRepository($adapter);
$speciesRepository = new SpeciesRepository($adapter);
$cultivarRepository = new CultivarRepository($adapter);

$fixtures = new Fixtures();
$fixtures->setGenusRepository($genusRepository);
$fixtures->setSpeciesRepository($speciesRepository);
$fixtures->setCultivarRepository($cultivarRepository);

$commands = [
    new CultivarRepositoryFixtureCommand( 'fixtures:cultivars'),
];

$input = new ArrayInput(['--dump' => true]);

foreach ($commands as $command) {
    /** @var Command $command */
    $command->setFixtures($fixtures);
    $command->run($input, new ConsoleOutput());
}
