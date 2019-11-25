<?php
declare(strict_types=1);

namespace FruitCompanyTest\Repository\CultivarRepositoryTest;


use FruitCompanyTest\Fixtures;
use FruitCompanyTest\FixtureCommand;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CultivarRepositoryFixtureCommand extends FixtureCommand
{
    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @return int|null null or 0 if everything went fine, or an error code
     *
     * @throws LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->fixtures instanceof Fixtures) {
            throw new \DomainException('Set Fixtures first in ' . __METHOD__);
        }

        $nightshades = $this->fixtures->createGenus('Nightshades');
        $malus = $this->fixtures->createGenus('Malus');

        $potato = $this->fixtures->createSpecies('Potato', $nightshades);
        $tomato = $this->fixtures->createSpecies('Tomato', $nightshades);
        $apple = $this->fixtures->createSpecies('Apple', $malus);

        $potatoes = [
            'Adirondack Blue',
            'Adirondack Red',
            'Agata',
            'Belana',
        ];
        $tomatoes = [
            'Alicante',
            'Beefsteak',
            'Celebrity',
        ];
        $apples = [
            'Adams Pearmain',
            'Anna',
            'Duchess of Oldenburg',
        ];

        foreach($potatoes as $potatoName) {
            $this->fixtures->createCultivar($potatoName, $potato);
        }

        foreach($tomatoes as $tomatoName) {
            $this->fixtures->createCultivar($tomatoName, $tomato);
        }

        foreach($apples as $appleName) {
            $this->fixtures->createCultivar($appleName, $apple);
        }

        if (true === $input->getOption('dump')) {
            $dumpResult = $this->dump(__DIR__ . '/dataset.xml', 'genus', 'species', 'cultivar');
            $output->writeln($dumpResult);
            $output->writeln('Executed table dump command for ' . __CLASS__);
        }
        
    }
}
