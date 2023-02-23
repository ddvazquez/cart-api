<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shared\Domain;

final class FloatMother
{
    public static function between($nbMaxDecimals = null, $min = 0, $max = null): float
    {
        return MotherCreator::random()->randomFloat($nbMaxDecimals, $min, $max);
    }
}
