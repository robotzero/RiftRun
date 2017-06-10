<?php

namespace App\Infrastructure\Post\Factory;

use App\Domain\Player\Model\Player;
use App\Domain\Player\ValueObject\PlayerId;
use App\Domain\Post\Model\Post;
use App\Infrastructure\Common\Exception\Form\FormException;
use App\Infrastructure\Post\Factory\Form\Event\GameModeEvent;
use App\Infrastructure\Post\Factory\Form\PostType;
use App\Infrastructure\Common\Factory\AbstractFormFactory;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class PostFormFactory
 * @package App\Infrastructure\Post\Factory
 */
class PostFormFactory extends AbstractFormFactory
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(FormFactory $factory, ValidatorInterface $validator)
    {
       $this->formClass = PostType::class;
       $this->validator = $validator;
       parent::__construct($factory);
    }

    public function create(array $data): Post
    {
        return $this->execute(self::CREATE, $data);
    }

    /**
     * @param string $action
     * @param array $data
     * @param null|object $object
     *
     * @return mixed
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     *
     * @throws FormException
     */
    protected function execute(string $action = self::CREATE, array $data, $object = null)
    {
        $formObject = new PostType(new GameModeEvent($this->validator));

        /** @var FormInterface $form */
        $form = $this->formFactory->create($formObject, $object, [
            'method' => $action
        ])->submit($data, self::UPDATE !== $action);

        if (!$form->isValid()) {
            throw new FormException($form);
        }
        return $form->getData();
    }
}