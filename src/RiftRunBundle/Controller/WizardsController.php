<?php

namespace RiftRunBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Hateoas\Configuration\Route;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RiftRunBundle\ORM\Specification\WizardsSpecification;

class WizardsController extends Controller
{
    /**
     * @return array
     * @View()
     * @Get("/wizards")
     */
    public function getWizardsAction(Request $request)
    {
        $characterRepository = $this->container->get('doctrine')
                                    ->getRepository('RiftRunners:Character');

        $paginatedCollection = $this->container->get('paginationfactory')->create(
            $characterRepository,
            'get_wizards',
            $request->query->get('limit', 20),
            $request->query->get('page', 1)
        );

        $json = $this->get('serializer')->serialize($paginatedCollection, 'json');
        return new Response($json);
    }

    /**
     * @return Wizard
     * @View()
     * @Get("/wizards/{id}")
     */
    public function getWizardAction(Request $request, $id)
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
