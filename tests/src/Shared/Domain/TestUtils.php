<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shared\Domain;

use Spfc\Tests\Shared\Infrastructure\Mockery\SpfcMatcherIsSimilar;
use Spfc\Tests\Shared\Infrastructure\PhpUnit\Constraint\SpfcConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar($expected, $actual): bool
    {
        $constraint = new SpfcConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function assertSimilar($expected, $actual): void
    {
        $constraint = new SpfcConstraintIsSimilar($expected);

        $constraint->evaluate($actual);
    }

    public static function similarTo($value, $delta = 0.0): SpfcMatcherIsSimilar
    {
        return new SpfcMatcherIsSimilar($value, $delta);
    }
}
