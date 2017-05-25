<?php

namespace App\UI\Rest\Controller;

use App\Application\UseCase\Post\Request\CreatePost;
use App\Application\UseCase\Post\Request\FindPost;
use App\Infrastructure\Common\Exception\Form\FormException;
use App\Infrastructure\Common\Pagination\PaginationTrait;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\PaginatedRepresentation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends AbstractBusController
{
    use PaginationTrait;

    private $postQueryService;
    private $serializer;

    /**
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return PaginatedRepresentation
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerMaxPerPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1MaxPerPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     * @View(statusCode=200, serializerGroups={"Default", "Identifier", "Basic"})
     * @QueryParam(name="page", key="page", requirements="\d+", default=1, description="Page Number", strict=true, nullable=true)
     * @QueryParam(name="limit", key="limit", requirements="\d+", default=20, description="Item per page", strict=true, nullable=true)
     * @Get("/posts")
     */
    public function getPostsAction(Request $request, ParamFetcherInterface $paramFetcher) : PaginatedRepresentation
    {
        $findRequest = new FindPost($paramFetcher->all());
        return $this->getPagination(
            $this->handle($findRequest),
            $request->get('_route'),
            [],
            $findRequest->getLimit(),
            $findRequest->getPage()
        );
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
    public function createPostAction(Request $request)
    {
        try {
            $post = $this->handle(
                new CreatePost(
                    $request->request->all()
                )
            );
        } catch (FormException $exception) {
            return $exception->getForm();
        }
        return $post;
//        return $this->routeRedirectView('get_post', [ 'postId' => $post->id() ]);

//        $post = $this->commandBus->handle(new CreatePost(
//            PostType::class,
//            $request->getMethod(),
//            $request->request->all()
//        ));
//
//        return new Response(json_encode(['postId' => $post->getId(), 'searchQueryId' => $post->getQuery()->getId()]), 201);
    }
}
