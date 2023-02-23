<?php

declare(strict_types = 1);

namespace Spfc\Shared\Domain;

interface UuidGenerator
{
    public function generate(): string;
}
