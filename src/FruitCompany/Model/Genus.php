<?php
declare(strict_types=1);

namespace FruitCompany\Model;

use FruitCompany\DataTransferObject\GenusData;

final class Genus implements Model
{
    private ?int $id = null;

    public function __construct(
        private readonly string $name
    ) {
    }

    public static function load(GenusData $data): Genus
    {
        $genus = new Genus($data->name);
        $genus->id = $data->id;

        return $genus;
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

    public function withId(int $id): Genus
    {
        $genus = clone $this;
        $genus->id = $id;

        return $genus;
    }
}
