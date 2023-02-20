<?php

declare(strict_types=1);

namespace Spfc\Shared\Infrastructure\Bus\Event;

use Spfc\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Traversable;

final class DomainEventSubscriberLocator
{
    private $mapping;

    /**
     * @param $mapping
     */
    public function __construct(Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    /**
     * @param string $eventClass
     * @return array
     */
    public function allSubscribedTo(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mapping);

        return $formatted[$eventClass];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->mapping;
    }
}
