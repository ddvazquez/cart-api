<?php

declare(strict_types=1);

namespace Spfc\Shared\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use function Lambdish\Phunctional\filter;
use RuntimeException;

final class Utils
{
    /**
     * @param  string  $needle
     * @param  string  $haystack
     * @return bool
     */
    public static function endsWith(string $needle, string $haystack): bool
    {
        $length = strlen($needle);
        if ($length === 0) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }

    /**
     * @param  DateTimeInterface  $date
     * @return string
     */
    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    /**
     * @param  string  $date
     * @return DateTimeImmutable
     *
     * @throws \Exception
     */
    public static function stringToDate(string $date): DateTimeImmutable
    {
        return new DateTimeImmutable($date);
    }

    /**
     * @param  array  $values
     * @return string
     */
    public static function jsonEncode(array $values): string
    {
        return json_encode($values);
    }

    /**
     * @param  string  $json
     * @return array
     */
    public static function jsonDecode(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Unable to parse response body into JSON: '.json_last_error());
        }

        return $data;
    }

    /**
     * @param  string  $text
     * @return string
     */
    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text));
    }

    /**
     * @param  string  $text
     * @return string
     */
    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }

    /**
     * @param $array
     * @param $prepend
     * @return array
     */
    public static function dot($array, $prepend = ''): array
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }

    /**
     * @param  string  $path
     * @return array
     */
    public static function directoriesIn(string $path): array
    {
        return filter(
            static function (string $possibleModule) {
                return ! in_array($possibleModule, ['.', '..']);
            },
            scandir($path)
        );
    }

    /**
     * @param  string  $path
     * @param $fileType
     * @return array
     */
    public static function filesIn(string $path, $fileType): array
    {
        return filter(
            static function (string $possibleModule) use ($fileType) {
                return strstr($possibleModule, $fileType);
            },
            scandir($path)
        );
    }
}
