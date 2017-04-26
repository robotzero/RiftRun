<?php

namespace App\Infrastructure\SearchQuery\Factory;

use App\Domain\SearchQuery\Model\SearchQuery;
use App\Infrastructure\Common\Factory\AbstractFormFactory;
use App\Infrastructure\SearchQuery\Factory\Form\SearchQueryType;
use Symfony\Component\Form\FormFactory;

/**
 * Class SearchQueryFormFactory
 * @package App\Infrastructure\SearchQuery\Factory
 */
class SearchQueryFormFactory extends AbstractFormFactory
{
    public function __construct(FormFactory $factory)
    {
        $this->formClass = SearchQueryType::class;
        parent::__construct($factory);
    }

    public function create(array $data): SearchQuery
    {
        return $this->execute(self::CREATE, $data);
    }
}