<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use RiftRunBundle\CommandBus\Commands\Create;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreatePostCommandHandler
{
    /** @var FormFactory */
    private $formFactory;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var AbstractType */
    private $postFormType;

    /** @var RequestStack */
    private $requestStack;

    public function __construct(
        FormFactory $formFactory,
        EntityManagerInterface $entityManager,
        AbstractType $postFormType,
        RequestStack $requestStack
    ) {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->postFormType = $postFormType;
        $this->requestStack = $requestStack;
    }
    public function handle(Create $createPost)
    {
        $post = $createPost->getModel();

        $form = $this->formFactory->create(
            $this->postFormType,
            $post,
            ['method' => 'POST']
        );

        $currentRequest = $this->requestStack->getCurrentRequest();
        $form = $form->handleRequest($currentRequest);

        //$form->submit($form->getData(), false);

        if ($form->isValid() === false) {
            $iterator = $form->getErrors(true, true);
            //print_r($this->getFormErrors($form));
            throw new BadRequestHttpException('Invalid form ' . (string) $iterator);
        }

        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush($post);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        //return [];
        return new RedirectResponse('posts', 302);
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function getFormErrors($form)
    {
        //
        if ($err = $this->childErrors($form)) {
            $errors["form"] = $err;
        }

        //
        foreach ($form->all() as $key => $child) {
            //
            if ($err = $this->childErrors($child)) {
                $errors[$key] = $err;
            }
        }

        return $errors;
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function childErrors($form)
    {
        $errors = array();

        foreach ($form->getErrors() as $error) {
            $message = $error->getMessage();
            array_push($errors, $message);
        }

        return $errors;
    }
}
