<?php
declare(strict_types=1);

namespace FruitCompany\Model;

use FruitCompany\DataTransferObject\GenusData;

final class Genus implements Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    public static function load(GenusData $data): Genus
    {
        $genus = new Genus($data->name);
        $genus->id = $data->id;

        return $genus;
    }

    /**
     * @return int
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
     * @param int $id
     * @return Genus
     */
    public function withId(int $id): Genus
    {
        $genus = clone $this;
        $genus->id = $id;

        return $genus;
    }
}
