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

    public function __construct(
        private readonly string $name,
        private readonly Genus $genus
    ) {
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
     */
    public function isNew(): bool
    {
        return is_null($this->id);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGenus(): Genus
    {
        return $this->genus;
    }

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
