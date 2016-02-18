<?php

namespace spec\RiftRunBundle\CommandBus\Handlers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RiftRunBundle\CommandBus\Commands\DTOAdapter;
use RiftRunBundle\DTO\CharacterDTO;
use RiftRunBundle\DTO\CharacterTypeDTO;
use RiftRunBundle\DTO\GriftDTO;
use RiftRunBundle\DTO\PostDTO;
use RiftRunBundle\DTO\SearchQueryDTO;

class TransformDTOModelCommandHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\CommandBus\Handlers\TransformDTOModelCommandHandler');
    }

    function it_implements_an_interface()
    {
        $this->shouldImplement('RiftRunBundle\CommandBus\Handlers\CommandHandler');
    }

    function it_should_return_new_post_instance()
    {
        $postDTO = new PostDTO();
        $searchQueryDTO = new SearchQueryDTO();
        $characterDTO = new CharacterDTO();
        $griftDTO = new GriftDTO();
        $characterType1 = new CharacterTypeDTO();
        $characterType2 = new CharacterTypeDTO();
        $characterTypes = [ $characterType1, $characterType2 ];

        $characterType1->type = 'wizard';
        $characterType2->type = 'barbarian';
        $griftDTO->level = '40+';
        $searchQueryDTO->minParagon = 200;
        $searchQueryDTO->game = $griftDTO;
        $searchQueryDTO->characterType = $characterTypes;

        $characterDTO->type = 'wizard';
        $characterDTO->region = 'EU';
        $characterDTO->battleTag = '#2000';
        $characterDTO->seasonal = 1;
        $characterDTO->gameType = 'hardcore';

        $postDTO->query = $searchQueryDTO;
        $postDTO->player = $characterDTO;

        $adapter = new DTOAdapter($postDTO);

        $result = $this->handle($adapter)->shouldReturn(Argument::type('RiftRunBundle\Model\Post'));

        print_r($result);
    }
}