<?php
declare(strict_types=1);

namespace FruitCompany\Model;

use FruitCompany\DataTransferObject\CultivarData;

final class Cultivar implements Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Species
     */
    private $species;

    /**
     * @var bool
     */
    private $edible;

    public function __construct(
        string $name,
        Species $species,
        bool $edible
    ) {
        $this->name = $name;
        $this->species = $species;
        $this->edible = $edible;
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
     * @return Species
     */
    public function getSpecies(): Species
    {
        return $this->species;
    }

    /**
     * @return bool
     */
    public function isEdible(): bool
    {
        return $this->edible;
    }

    /**
     * @param CultivarData $data
     * @return Cultivar
     */
    public static function load(CultivarData $data): Cultivar
    {
        $cultivar = new Cultivar($data->name, $data->species, $data->edible);
        $cultivar->id = $data->id;

        return $cultivar;
    }

    /**
     * @param int $id
     * @return Cultivar
     */
    public function withId(int $id): Cultivar
    {
        $cultivar = clone $this;
        $cultivar->id = $id;

        return $cultivar;
    }
}
