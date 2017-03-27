<?php

namespace App\Transformers;

use ArrayIterator;
use Hateoas\Representation\CollectionRepresentation;
use Pagerfanta\Pagerfanta;
use App\Model\Post;

/**
 * Class TransformEntityCollection
 * @package RiftRunBundle\Services\Pipelines
 */
class EntityCollectionToDTOTransformer implements Transformer
{
    /** @var  EntityToDTOTransformer */
    private $singleEntityTransformer;

    public function __construct(EntityToDTOTransformer $singleEntityTransformer)
    {
        $this->singleEntityTransformer = $singleEntityTransformer;
    }

    /**
     * @param Pagerfanta $pagerfanta
     * @return CollectionRepresentation
     */
    public function transform(Pagerfanta $pagerfanta):CollectionRepresentation
    {
        /** @var ArrayIterator $results */
        $results = $pagerfanta->getCurrentPageResults();

        $dtosCollection = array_map(function (Post $post) {
            return $this->singleEntityTransformer->transform($post);
        }, $results->getArrayCopy());

        return new CollectionRepresentation(new ArrayIterator($dtosCollection));
    }
}