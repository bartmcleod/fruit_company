<?php
declare(strict_types=1);

namespace FruitCompany\Repository;

use FruitCompany\DataTransferObject\GenusData;
use FruitCompany\DataTransferObject\SpeciesData;
use FruitCompany\Model\Genus;
use FruitCompany\Model\Species;
use Generator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;

class GenusRepository extends AbstractTableGateway
{
    protected $table = 'genus';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function save(Genus $genus): Genus
    {
        $set = [
            'name' => $genus->getName(),
        ];

        if ($genus->isNew()) {
            $this->insert($set);

            return $genus->withId((int) $this->lastInsertValue);
        }

        $this->update($set, ['id' => $genus->getId()]);

        return $genus;
    }

    public function getByGenus(int $genusId): Generator
    {
        $select = $this->getSelect();
        $select->where(['g.id' => $genusId]);

        return $this->getSpecies($select);
    }

    /**
     * @return Select
     */
    private function getSelect(): Select
    {
        $select = (new Select(['s' => $this->table]))
            ->columns([Select::SQL_STAR])
            ->join(['g' => 'genus'], 's.genus_id = g.id', ['genus_name' => 'name'], Select::JOIN_LEFT);
        return $select;
    }

    /**
     * @param Select $select
     * @return Generator
     */
    private function getSpecies(Select $select): Generator
    {
        foreach ($this->selectWith($select) as $row) {
            $genusData = new GenusData();
            $genusData->name = $row['genus_name'];
            $genusData->id = (int)$row['genus_id'];

            $speciesData = new SpeciesData();
            $speciesData->id = (int)$row['species_id'];
            $speciesData->name = $row['species_name'];
            $speciesData->genus = Genus::load($genusData);

            yield Species::load($speciesData);
        }
    }
}
