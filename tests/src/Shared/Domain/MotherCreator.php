<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shared\Domain;

use Faker\Factory;
use Faker\Generator;

final class MotherCreator
{


    /**
     * @return Generator
     */
    public static function random(): Generator
    {
        static $faker;
        return $faker ??= Factory::create();
    }
}
