<?php

declare(strict_types=1);

namespace Spfc\BoundedContext\Carts\Domain;

use Illuminate\Support\Facades\Hash;
use Spfc\Shared\Domain\ValueObject\DateTimeValueObject;
use Spfc\Shared\Domain\ValueObject\StringValueObject;

final class CartDate extends DateTimeValueObject
{
}
