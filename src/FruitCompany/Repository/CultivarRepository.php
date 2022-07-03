<?php
declare(strict_types=1);

namespace FruitCompany\Repository;

use FruitCompany\DataTransferObject\CultivarData;
use FruitCompany\DataTransferObject\GenusData;
use FruitCompany\DataTransferObject\SpeciesData;
use FruitCompany\Model\Cultivar;
use FruitCompany\Model\Genus;
use FruitCompany\Model\Species;
use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\AbstractTableGateway;

class CultivarRepository extends AbstractTableGateway
{
    protected $table = 'cultivar';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function save(Cultivar $cultivar): Cultivar
    {
        $set = [
            'name' => $cultivar->getName(),
            'species_id' => $cultivar->getSpecies()->getId(),
            'edible' => $cultivar->isEdible(),
        ];

        if ($cultivar->isNew()) {
            $this->insert($set);

            return $cultivar->withId((int)$this->lastInsertValue);
        }

        $this->update($set, ['id' => $cultivar->getId()]);

        return $cultivar;
    }

    public function getByGenus(int $genusId): Generator
    {
        $select = $this->getSelect();
        $select->where(['g.id' => $genusId]);

        return $this->getCultivars($select);
    }

    public function getBySpecies(int $speciesId): Generator
    {
        $select = $this->getSelect();
        $select->where(['s.id' => $speciesId]);

        return $this->getCultivars($select);
    }

    /**
     * @return Select
     */
    private function getSelect(): Select
    {
        $select = (new Select(['c' => $this->table]))
            ->columns([Select::SQL_STAR])
            ->join(['s' => 'species'], 'c.species_id = s.id', ['species_id' => 'id', 'species_name' => 'name'], Select::JOIN_LEFT)
            ->join(['g' => 'genus'], 's.genus_id = g.id', ['genus_id' => 'id', 'genus_name' => 'name'], Select::JOIN_LEFT);
        return $select;
    }

    /**
     * @param Select $select
     * @return Generator
     */
    private function getCultivars(Select $select): Generator
    {
        foreach ($this->selectWith($select) as $row) {
            $genusData = new GenusData();
            $genusData->name = $row['genus_name'];
            $genusData->id = (int)$row['genus_id'];

            $speciesData = new SpeciesData();
            $speciesData->id = (int)$row['species_id'];
            $speciesData->name = $row['species_name'];
            $speciesData->genus = Genus::load($genusData);

            $cultivarData = new CultivarData();
            $cultivarData->id = (int)$row['id'];
            $cultivarData->name = $row['name'];
            $cultivarData->edible = (bool)$row['edible'];
            $cultivarData->species = Species::load($speciesData);

            yield Cultivar::load($cultivarData);
        }
    }
}
