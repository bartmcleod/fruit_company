<?php
declare(strict_types=1);

namespace FruitCompanyTest;

use FruitCompany\Model\Cultivar;
use FruitCompany\Model\Genus;
use FruitCompany\Model\Species;
use FruitCompany\Repository\CultivarRepository;
use FruitCompany\Repository\GenusRepository;
use FruitCompany\Repository\SpeciesRepository;

class Fixtures
{
    /**
     * @var GenusRepository
     */
    private $genusRepository;

    /**
     * @var SpeciesRepository
     */
    private $speciesRepository;

    /**
     * @var
     */
    private $cultivarRepository;

    public function createGenus(string $name): Genus
    {
        if (! $this->genusRepository instanceof GenusRepository) {
            throw new \DomainException('Set the genusRepository before calling ' . __METHOD__);
        }

        $genus = new Genus($name);

        return $this->genusRepository->save($genus);
    }

    public function createSpecies(string $name, Genus $genus): Species
    {
        if (! $this->speciesRepository instanceof SpeciesRepository) {
            throw new \DomainException('Set the genusRepository before calling ' . __METHOD__);
        }

        $species = new Species($name, $genus);

        return $this->speciesRepository->save($species);
    }

    public function createCultivar(string $name, Species $species, bool $edible = true): Cultivar
    {
        if (! $this->cultivarRepository instanceof CultivarRepository) {
            throw new \DomainException('Set the cultivarRepository before calling ' . __METHOD__);
        }

        $cultivar = new Cultivar($name, $species, $edible);

        return $this->cultivarRepository->save($cultivar);
    }

    /**
     * @param GenusRepository $genusRepository
     */
    public function setGenusRepository(GenusRepository $genusRepository): void
    {
        $this->genusRepository = $genusRepository;
    }

    /**
     * @param SpeciesRepository $speciesRepository
     */
    public function setSpeciesRepository(SpeciesRepository $speciesRepository): void
    {
        $this->speciesRepository = $speciesRepository;
    }

    /**
     * @param mixed $cultivarRepository
     */
    public function setCultivarRepository($cultivarRepository): void
    {
        $this->cultivarRepository = $cultivarRepository;
    }
}
