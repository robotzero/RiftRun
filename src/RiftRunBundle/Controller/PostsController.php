<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use RiftRunBundle\Forms\PostType;
use RiftRunBundle\Model\Post as PostModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends FOSRestController
{
    /**
     * @return array
     * @View()
     * @Get("/posts")
     */
    public function getPostsAction(Request $request)
    {
        return $this->container->get('paginationfactory')->create(
            'post',
            'get_posts'
        );
    }

    /**
     * @return Post
     * @View()
     * @Get("/posts/{id}")
     */
    public function getPostAction(Request $request, $id)
    {
        return $this->container->get('singletype_factory')->create($id, 'post');
    }

    /**
     * @return array
     * @View()
     * @Post("/posts")
     */
    public function createPostAction(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $formFactory = $this->container->get('form.factory');
        $post = new PostModel();
        $form = $formFactory->create(new PostType(), $post, ['method' => 'POST']);
        $form->submit($content, true);

        //$form = $this->createForm(new PostType($post));
        //var_dump($post);
        //var_dump($content);
        $em = $this->container->get('doctrine')->getManager();

        try {
            $em->persist($post);
            $em->flush($post);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return [];
    }
}
