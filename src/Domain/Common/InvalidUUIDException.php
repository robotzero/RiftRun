<?php

namespace App\Domain\Common;

/**
 * Class InvalidUUIDException
 * @package App\Domain\Common
 */
class InvalidUUIDException extends \InvalidArgumentException
{
    /**
     * InvalidUUIDException constructor.
     */
    public function __construct()
    {
        parent::__construct('aggregator_root.exception.invalid_uuid', 400);
    }
}