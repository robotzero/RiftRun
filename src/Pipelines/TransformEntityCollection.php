<?php

namespace App\Pipelines;

use ArrayIterator;
use Hateoas\Representation\CollectionRepresentation;
use Pagerfanta\Pagerfanta;
use App\Model\Post;

/**
 * Class TransformEntityCollection
 * @package RiftRunBundle\Services\Pipelines
 */
class TransformEntityCollection
{
    /**
     * @param Pagerfanta $pagerfanta
     * @return CollectionRepresentation
     */
    public function transform(Pagerfanta $pagerfanta):CollectionRepresentation
    {
        /** @var ArrayIterator $results */
        $results = $pagerfanta->getCurrentPageResults();
        $singleEntityTransoform = new TransformEntity();

        $dtosCollection = array_map(function (Post $post) use ($singleEntityTransoform) {
            return $singleEntityTransoform->transform($post);
        }, $results->getArrayCopy());

        return new CollectionRepresentation(new ArrayIterator($dtosCollection));
    }
}