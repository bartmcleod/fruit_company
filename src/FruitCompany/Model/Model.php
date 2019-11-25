<?php

namespace FruitCompany\Model;

interface Model
{
    /**
     * @return mixed
     */
    public function getId(): int;

    /**
     * Return true if the object has not been saved
     * @return bool
     */
    public function isNew(): bool;
}
