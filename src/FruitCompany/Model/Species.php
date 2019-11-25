<?php
declare(strict_types=1);

namespace FruitCompany\Model;


use FruitCompany\DataTransferObject\SpeciesData;

final class Species implements Model
{
    /**
     * @var
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Genus
     */
    private $genus;

    public function __construct(
        string $name,
        Genus $genus
    ) {
        $this->name = $name;
        $this->genus = $genus;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Return true if the object has not been saved
     * @return bool
     */
    public function isNew(): bool
    {
        return is_null($this->id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Genus
     */
    public function getGenus(): Genus
    {
        return $this->genus;
    }

    /**
     * @param SpeciesData $data
     * @return Species
     */
    public static function load(SpeciesData $data): Species
    {
        $species = new Species($data->name, $data->genus);
        $species->id = $data->id;

        return $species;
    }

    public function withId(int $id): Species
    {
        $species = clone $this;
        $species->id = $id;

        return $species;
    }
}
