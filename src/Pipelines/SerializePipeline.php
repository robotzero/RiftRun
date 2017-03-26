<?php

namespace App\Pipelines;

use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class SerializePipeline
{
    /** @var  SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param PaginatedRepresentation $collection
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function __invoke(PaginatedRepresentation $collection):Response
    {
        return new Response($this->serializer->serialize($collection, 'json'));
    }
}