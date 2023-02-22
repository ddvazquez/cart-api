<?php

declare(strict_types=1);

namespace Spfc\Shared\Infrastructure\Bus\Event;

use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;
use RuntimeException;
use Spfc\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class DomainEventMapping
{
    private iterable $mapping;

    /**
     * @param  iterable  $mapping
     */
    public function __construct(iterable $mapping)
    {
        $this->mapping = reduce($this->eventsExtractor(), $mapping, []);
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function for(string $name)
    {
        if (! isset($this->mapping[$name])) {
            throw new RuntimeException("The Domain Event Class for <$name> doesn't exists or have no subscribers");
        }

        return $this->mapping[$name];
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->mapping;
    }

    /**
     * @return callable
     */
    private function eventsExtractor(): callable
    {
        return function (array $mapping, DomainEventSubscriber $subscriber) {
            return array_merge($mapping, reindex($this->eventNameExtractor(), $subscriber::subscribedTo()));
        };
    }

    /**
     * @return callable
     */
    private function eventNameExtractor(): callable
    {
        return static function (string $eventClass): string {
            return $eventClass::eventName();
        };
    }
}
