<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;

class SearchController extends FOSRestController
{
    /**
     * @return array
     * @Post("/search")
     * @View()
     */
    public function searchAction(Request $request)
    {
        return [];
    }
}