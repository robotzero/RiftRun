<?php

namespace Application\Request\Common;

/**
 * Class Pagination
 * @package Application\Request\Common
 */
class Pagination
{
    const
        LIMIT = 25,
        PAGE = 1
    ;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $page;

    /**
     * Pagination constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->limit     = $data['limit'] ?? self::LIMIT;
        $this->page      = $data['page'] ?? self::PAGE;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
}