<?php
declare(strict_types=1);

namespace FruitCompanyTest\Repository\FruitRepositoryTest;


use FruitCompany\Model\Cultivar;
use FruitCompany\Repository\CultivarRepository;
use FruitCompanyTest\DbTest;
use PHPUnit\DbUnit\DataSet\IDataSet;

class CultivarRepositoryTest extends DbTest
{
    /**
     * @covers \FruitCompany\Repository\CultivarRepository::getByGenus
     */
    public function testGetByGenus()
    {
        $fruitRepository = new CultivarRepository(
            $this->getDbAdapter()
        );

        $id = $this->getIdFromDataset('genus', 'id', 2);
        $nightshades = $fruitRepository->getByGenus($id);
        $count = 0;

        /** @var Cultivar $cultivar */
        foreach ($nightshades as $cultivar) {
            $count++;
            $this->assertSame('Nightshades', $cultivar->getSpecies()->getGenus()->getName());
        }

        $this->assertSame(7, $count);
    }

    /**
     * @covers \FruitCompany\Repository\CultivarRepository::getBySpecies
     */
    public function testGetBySpecies()
    {
        $fruitRepository = new CultivarRepository(
            $this->getDbAdapter()
        );

        $id = $this->getIdFromDataset('species', 'id', 3);
        $apples = $fruitRepository->getBySpecies($id);
        $count = 0;

        /** @var Cultivar $cultivar */
        foreach ($apples as $cultivar) {
            $count++;
            $this->assertSame('Apple', $cultivar->getSpecies()->getName());
        }

        $this->assertSame(3, $count);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/dataset.xml');
    }
}
