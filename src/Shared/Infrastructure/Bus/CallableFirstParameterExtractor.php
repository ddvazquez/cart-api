<?php

declare(strict_types=1);

namespace Spfc\Shared\Infrastructure\Bus;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;
use ReflectionClass;
use ReflectionMethod;
use Spfc\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class CallableFirstParameterExtractor
{
    /**
     * @param $class
     * @return string|null
     *
     * @throws \ReflectionException
     */
    public function extract($class): ?string
    {
        $reflector = new ReflectionClass($class);
        $method = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    /**
     * @param  iterable  $callables
     * @return array
     */
    public static function forCallables(iterable $callables): array
    {
        return map(self::unflatten(), reindex(self::classExtractor(new self()), $callables));
    }

    /**
     * @param  iterable  $callables
     * @return array
     */
    public static function forPipedCallables(iterable $callables): array
    {
        return reduce(self::pipedCallablesReducer(), $callables, []);
    }

    /**
     * @param  ReflectionMethod  $method
     * @return string
     */
    private function firstParameterClassFrom(ReflectionMethod $method): string
    {
        return $method->getParameters()[0]->getClass()->getName();
    }

    /**
     * @param  ReflectionMethod  $method
     * @return bool
     */
    private function hasOnlyOneParameter(ReflectionMethod $method): bool
    {
        return $method->getNumberOfParameters() === 1;
    }

    /**
     * @param  CallableFirstParameterExtractor  $parameterExtractor
     * @return callable
     */
    private static function classExtractor(CallableFirstParameterExtractor $parameterExtractor): callable
    {
        return static function (callable $handler) use ($parameterExtractor): string {
            return $parameterExtractor->extract($handler);
        };
    }

    /**
     * @return callable
     */
    private static function pipedCallablesReducer(): callable
    {
        return static function ($subscribers, DomainEventSubscriber $subscriber): array {
            $subscribedEvents = $subscriber::subscribedTo();

            foreach ($subscribedEvents as $subscribedEvent) {
                $subscribers[$subscribedEvent][] = $subscriber;
            }

            return $subscribers;
        };
    }

    /**
     * @return callable
     */
    private static function unflatten(): callable
    {
        return static function ($value) {
            return [$value];
        };
    }
}
