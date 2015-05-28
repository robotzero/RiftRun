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
use RiftRunBundle\Model\Wizard;
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
        $characterRepository = $this->container->get('doctrine')
                                    ->getRepository('RiftRunners:Character');

        $queryBuilder = $characterRepository->createQueryBuilder('w')
                                            ->select('w')
                                            ->where('w.type=?1')
                                            ->setParameter(1, 'monk');

        //$wizards = $characterRepository->findBy(['type' => 'wizard']);


        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);


        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        // $pagerfanta->setCurrentPage($page);
        // $pagerfanta->setMaxPerPage($limit);

        $pagerFantaFactory = new PagerfantaFactory();
        // echo $adapter->getQuery()->getDQL();
        //$wizards = $adapter->getQuery()->execute();

        // print_r($wizards);
        // my manual, silly pagination logic.
        //$offset = ($page - 1) * $limit;
        //$numberOfPages = (int) ceil(count($wizards) / $limit);
        //$numberOfPages = $pagerfanta->getNbResults();

        $paginatedCollection = $pagerFantaFactory->createRepresentation(
            $pagerfanta,
            new Route('get_wizards', [], true)
        );

        // $paginatedCollection = new PaginatedRepresentation(
        //     new CollectionRepresentation(
        //         array_slice($wizards, 25, 20),
        //         'wizards', // embedded rel
        //         'wizards'  // xml element name
        //     ),
        //     'get_wizards', // route
        //     array(), // route parameters
        //     1,       // page number
        //     $limit,      // limit
        //     $numberOfPages,       // total pages
        //     'page',  // page route parameter name, optional, defaults to 'page'
        //     'limit', // limit route parameter name, optional, defaults to 'limit'
        //     true,   // generate relative URIs, optional, defaults to `false`
        //     null       // total collection size, optional, defaults to `null`
        // );

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
