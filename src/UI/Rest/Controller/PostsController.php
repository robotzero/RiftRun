<?php

namespace App\UI\Rest\Controller;

use App\Application\UseCase\Post\Find;
use App\Infrastructure\Common\Pagination\PaginationTrait;
use App\Services\PostQueryService;
use App\Services\PostsQueryService;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use App\CommandBus\Commands\CreatePost;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\PaginatedRepresentation;
use Infrastructure\Common\Exception\Form\FormException;
use JMS\Serializer\SerializerInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Forms\PostType;

class PostsController extends AbstractBusController
{
    use PaginationTrait;

    private $postsQueryService;
    private $postQueryService;
    private $commandBus;
    private $serializer;

//    public function __construct(
////        PostsQueryService $postsQueryService,
////        PostQueryService $postQueryService,
//        CommandBus $commandBus
////        SerializerInterface $serializer
//    ) {
////        parent::__construct($commandBus);
////        $this->postsQueryService = $postsQueryService;
////        $this->postQueryService = $postQueryService;
//        $this->commandBus = $commandBus;
////        $this->serializer = $serializer;
//    }

    /**
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return PaginatedRepresentation
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerMaxPerPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1MaxPerPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     * @View()
     * @QueryParam(name="page", key="page", requirements="\d+", default=1, description="Page Number", strict=true, nullable=true)
     * @QueryParam(name="limit", key="limit", requirements="\d+", default=20, description="Item per page", strict=true, nullable=true)
     * @Get("/posts")
     */
    public function getPostsAction(Request $request, ParamFetcherInterface $paramFetcher) : PaginatedRepresentation
    {
        $findRequest = new Find($paramFetcher->all());
        return $this->getPagination(
            $this->handle($findRequest),
            $request->get('_route'),
            [],
            $findRequest->getLimit(),
            $findRequest->getPage()
        );
//        return [];
//        return $this->postsQueryService->query($paramFetcher->get('page', true), $paramFetcher->get('limit', true), $request->get('_route'));
    }

    /**
     * @param $id
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \InvalidArgumentException
     * @View()
     * @Get("/posts/{id}")
     */
    public function getPostAction(string $id) : Response
    {
        return new Response($this->serializer->serialize($this->postQueryService->query($id), 'json'));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @View()
     * @Post("/posts")
     */
    public function createPostAction(Request $request) : Post
    {
        try {
            $post = $this->handle(
                new CreatePost(
                    PostType::class,
                    $request->getMethod(),
                    $request->request->all()
                )
            );
        } catch (FormException $exception) {
            return $exception->getForm();
        }
        return $post;
//        return $this->routeRedirectView('get_wallet', [ 'walletId' => $wallet->id() ]);

//        $post = $this->commandBus->handle(new CreatePost(
//            PostType::class,
//            $request->getMethod(),
//            $request->request->all()
//        ));
//
//        return new Response(json_encode(['postId' => $post->getId(), 'searchQueryId' => $post->getQuery()->getId()]), 201);
    }
}
