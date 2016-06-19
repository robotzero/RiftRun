<?php

namespace spec\RiftRunBundle\Services\Pipelines;

use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\SerializerInterface;
use RiftRunBundle\Services\Pipelines\SerializePipeline;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SerializePipelineSpec extends ObjectBehavior
{
    function let(SerializerInterface $serializer)
    {
        $this->beConstructedWith($serializer);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(SerializePipeline::class);
    }

    function it_should_delegate_to_serializer_to_serialize_a_collection(PaginatedRepresentation $collection, SerializerInterface $serializer)
    {
        $serializer->serialize($collection, 'json')->shouldBeCalled();
        $this->__invoke($collection);
    }

    function it_should_return_framework_response_object(PaginatedRepresentation $collection, SerializerInterface $serializer)
    {
        $this->__invoke($collection)->shouldReturnAnInstanceOf('Symfony\Component\HttpFoundation\Response');
        $serializer->serialize($collection, 'json')->shouldHaveBeenCalled();
    }
}
