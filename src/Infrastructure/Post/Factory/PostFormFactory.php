<?php

namespace App\Infrastructure\Post\Factory;

use App\Forms\PostType;
use App\Model\Post;
use App\Infrastructure\Common\Factory\AbstractFormFactory;
use Symfony\Component\Form\FormFactory;

/**
 * Class PostFormFactory
 * @package App\Infrastructure\Post\Factory
 */
class PostFormFactory extends AbstractFormFactory
{
    public function __construct(FormFactory $factory)
    {
       $this->formClass = PostType::class;
       parent::__construct($factory);
    }

    public function create(array $data): Post
    {
        return $this->execute(self::CREATE, $data);
    }
}