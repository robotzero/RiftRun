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

class WizardsController extends Controller
{
    /**
     * @return array
     * @View()
     * @Get("/wizards")
     */
    public function getWizardsAction(Request $request)
    {
        // $characterRepository = $this->container->get('doctrine')
        //                             ->getRepository('RiftRunners:Character');

        // $queryBuilder = $characterRepository->createQueryBuilder('w')
        //                                     ->select('w')
        //                                     ->where('w.type=?1')
        //                                     ->setParameter(1, 'wizard');


        // $adapter = new DoctrineORMAdapter($queryBuilder);
        // $pagerfanta = new Pagerfanta($adapter);

        // $limit = $request->query->get('limit', 20);
        // $page = $request->query->get('page', 1);
        // $pagerfanta->setMaxPerPage($limit);
        // $pagerfanta->setCurrentPage($page);

        // $pagerFantaFactory = new PagerfantaFactory();

        // $paginatedCollection = $pagerFantaFactory->createRepresentation(
        //     $pagerfanta,
        //     new Route('get_wizards', [], true)
        // );

        // $json = $this->get('serializer')->serialize($paginatedCollection, 'json');
        // return new Response($json);
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
