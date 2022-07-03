<?php
declare(strict_types=1);

namespace FruitCompany\Repository;

use FruitCompany\DataTransferObject\GenusData;
use FruitCompany\DataTransferObject\SpeciesData;
use FruitCompany\Model\Genus;
use FruitCompany\Model\Species;
use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\AbstractTableGateway;

class SpeciesRepository extends AbstractTableGateway
{
    protected $table = 'species';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function save(Species $species): Species
    {
        $set = [
            'name' => $species->getName(),
            'genus_id' => $species->getGenus()->getId(),
        ];

        if ($species->isNew()) {
            $this->insert($set);

            return $species->withId((int) $this->lastInsertValue);
        }

        $this->update($set, ['id' => $species->getId()]);

        return $species;
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
