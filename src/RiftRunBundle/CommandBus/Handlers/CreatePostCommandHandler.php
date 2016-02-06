<?php

namespace RiftRunBundle\CommandBus\Handlers;

use Doctrine\ORM\EntityManagerInterface;
use RiftRunBundle\CommandBus\Commands\Create;
use Symfony\Component\HttpFoundation\Response;

final class CreatePostCommandHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function handle(Create $createPost)
    {
        $post = $createPost->getPost();
        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush($post);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $response = new Response();
        $response->setContent(json_encode([]));
        $response->setStatusCode(200);
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Access-Control-Allow-Origin, Key, X-Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Origin', 'http://fa.local');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        return $response;
        //return new RedirectResponse('posts', 302);
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
