<?php
declare(strict_types=1);

namespace FruitCompany\DataTransferObject;


use FruitCompany\Model\Species;

final class CultivarData
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
     * @var Species
     */
    public $species;

    /**
     * @var bool
     */
    public $edible;
}
