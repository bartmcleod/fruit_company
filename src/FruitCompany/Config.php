<?php

namespace FruitCompany;

class Config
{
    public static function get(): array
    {
        return [
            'db' => [
                'host' => 'mariadb',
                'port' => 3306,
                'username' => 'root',
                'password' => 'docker',
                'database' => 'fruit_company',
            ],
        ];
    }
}
