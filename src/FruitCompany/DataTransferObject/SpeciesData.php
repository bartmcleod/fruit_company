<?php
declare(strict_types=1);

namespace FruitCompany\DataTransferObject;


use FruitCompany\Model\Genus;

final class SpeciesData
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Genus
     */
    public $genus;
}
