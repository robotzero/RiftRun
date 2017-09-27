<?php

namespace App\Application\Common\Request;

/**
 * Class Pagination
 * @package App\Application\Common\Request
 */
class Pagination
{
    const LIMIT = 25, PAGE = 1;

    /**
     * @var array
     */
    private $filters = [];

    /**
     * @var array
     */
    private $operators = [];

    /**
     * @var array
     */
    private $values = [];

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
        $this->filters   = $data['filterParam'] ?? [];
        $this->operators = $data['filterOp'] ?? [];
        $this->values    = $data['filterValue'] ?? [];
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

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function getOperators(): array
    {
        return $this->operators;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }
}