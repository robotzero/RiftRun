<?php

namespace Test\Integration\Helpers;

/**
 * Class PathBuilder
 * @package Test\Integration\Helpers
 */
final class PathBuilder
{
    /**
     * PathBuilder constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param array ...$segments
     * @return string
     */
    public static function build(...$segments)
    {
        return implode(DIRECTORY_SEPARATOR, $segments);
    }
}