<?php

namespace FruitCompanyTest;

use FruitCompany\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

class FixtureCommand extends Command
{
    /**
      * @var Fixtures
      */
     protected $fixtures;

    /**
     * @param Fixtures $fixtures
     */
    public function setFixtures(Fixtures $fixtures): void
    {
        $this->fixtures = $fixtures;
    }

    /**
     * Dumps the specified tables to $path
     *
     * @param string $path
     * @param string ...$tables
     *
     * @return string|null
     */
    protected function dump(string $path, string ...$tables ): ?string
    {
        $tablesToDump = implode(' ', $tables);

        $params = Config::get()['db'];

        $cleanParams  = array_map('escapeshellarg', $params);

        $command = "mysqldump -h {$cleanParams['host']} -u {$cleanParams['username']} -p{$cleanParams['password']}" .
            " --port={$cleanParams['port']} -t --xml {$cleanParams['database']}_test $tablesToDump > $path";

        $output = shell_exec($command);

        if (empty($output)) {
            $output = "Dumped tables $tablesToDump";
        }

        return $output;
    }

    protected function configure()
    {
        parent::configure();

        $this->addOption(
            '--dump',
            '-d',
            InputOption::VALUE_NONE,
            'Dumps the dataset with the fixtures in MySQL xml format'
        );
    }
}
