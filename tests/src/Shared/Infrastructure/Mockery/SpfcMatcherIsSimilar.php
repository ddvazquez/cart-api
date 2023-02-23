<?php

declare(strict_types = 1);

namespace Spfc\Tests\Shared\Infrastructure\Mockery;

use Spfc\Tests\Shared\Infrastructure\PhpUnit\Constraint\SpfcConstraintIsSimilar;
use Mockery\Matcher\MatcherAbstract;

final class SpfcMatcherIsSimilar extends MatcherAbstract
{
    private $constraint;

    public function __construct($value, $delta = 0.0)
    {
        parent::__construct($value);

        $this->constraint = new SpfcConstraintIsSimilar($value, $delta);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'Is similar';
    }
}
