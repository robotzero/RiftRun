<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use RiftRunBundle\Model\Wizard;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WizardsController extends Controller
{
    /**
     * @return array
     * @View()
     * @Get("/wizards")
     */
    public function getWizardsAction()
    {
        $characterRepository = $this->container->get('doctrine')
                                    ->getRepository('RiftRunners:Character');

        $wizards = $characterRepository->findBy(['type' => 'wizard']);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                $wizards,
                'wizards', // embedded rel
                'wizards'  // xml element name
            ),
            'get_wizards', // route
            array(), // route parameters
            1,       // page number
            20,      // limit
            1,       // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            true,   // generate relative URIs, optional, defaults to `false`
            null       // total collection size, optional, defaults to `null`
        );

        $json = $this->get('serializer')->serialize($paginatedCollection, 'json');
        return new Response($json);
    }

    /**
     * @return Wizard
     * @View()
     * @Get("/wizards/{id}")
     */
    public function getWizardAction($id)
    {
        $characterRepository = $this->container->get('doctrine')
                                    ->getRepository('RiftRunners:Character');

        $wizard = $characterRepository->findBy(['id' => $id, 'type' => 'wizard'])[0];

        $json = $this->get('serializer')->serialize(
            $wizard,
            'json'
        );

        return new Response($json);
    }
}
