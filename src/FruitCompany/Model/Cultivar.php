<?php
declare(strict_types=1);

namespace FruitCompany\Model;

use FruitCompany\DataTransferObject\CultivarData;

final class Cultivar implements Model
{
    private ?int $id = null;

    public function __construct(
        private readonly string $name,
        private readonly Species $species,
        private readonly bool $edible
    ) {
    }

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

    public function getSpecies(): Species
    {
        return $this->species;
    }

    public function isEdible(): bool
    {
        return $this->edible;
    }

    public static function load(CultivarData $data): Cultivar
    {
        $cultivar = new Cultivar($data->name, $data->species, $data->edible);
        $cultivar->id = $data->id;

        return $cultivar;
    }

    public function withId(int $id): Cultivar
    {
        $cultivar = clone $this;
        $cultivar->id = $id;

        return $cultivar;
    }
}
