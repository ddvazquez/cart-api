<?php

declare(strict_types = 1);

namespace Spfc\Shared\Infrastructure;

use Illuminate\Support\Str;
use Spfc\Shared\Domain\UuidGenerator;


final class LaravelUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {

        return Str::uuid()->toString();;
    }
}
