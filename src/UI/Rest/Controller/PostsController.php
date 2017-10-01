<?php

namespace App\UI\Rest\Controller;

use App\Application\UseCase\Post\Request\CreatePost;
use App\Application\UseCase\Post\Request\FindPost;
use App\Application\UseCase\Post\Request\GetPost;
use App\Domain\Post\Model\Post as ModelPost;
use App\Infrastructure\Common\Exception\Form\FormException;
use App\Infrastructure\Common\Pagination\PaginationTrait;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\PaginatedRepresentation;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostsController
 * @package App\UI\Rest\Controller
 */
class PostsController extends AbstractBusController
{
    use PaginationTrait;

    /**
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return PaginatedRepresentation
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerMaxPerPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1MaxPerPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     * @View(
     *     statusCode=200,
     *     serializerGroups={"Default", "Identifier", "Basic"}
     * )
     * @QueryParam(
     *     name="page",
     *     key="page",
     *     requirements="\d+",
     *     default=1,
     *     description="Page Number",
     *     strict=true,
     *     nullable=true
     * )
     *
     * @QueryParam(
     *     name="limit",
     *     key="limit",
     *     requirements="\d+",
     *     default=20,
     *     description="Items per page",
     *     strict=true,
     *     nullable=true
     * )
     *
     * * @QueryParam(
     *     name="filterParam",
     *     nullable=true,
     *     strict=true,
     *     map=true,
     *     description="Keys to filter"
     * )
     **     requirements="(player.paragonPoints|player.battleTag|player.type|player.region|player.seasonal|player.gameType)",
     * @QueryParam(
     *     name="filterOp",
     *     nullable=true,
     *     requirements="(gt|gte|lt|lte|eq|like|between)",
     *     strict=true,
     *     map=true,
     *     description="Operators to filter"
     * )
     *
     * @QueryParam(
     *     name="filterValue",
     *     map=true,
     *     description="Values to filter"
     * )
     *
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
     * ApiDoc(
     *     resource = true,
     *     section="Post",
     *     description = "Gets a post for given identifier",
     *     output = "Application\Domain\Post\Model\Post",
     *     statusCodes = {
     *       200 = "Returned when successful",
     *       404 = "Returned when not found"
     *     }
     * )
     *
     * @View(statusCode=200, serializerGroups={"Default", "Identifier", "Basic"})
     * @Get("/posts/{postId}")
     *
     * @param string $postId
     *
     * @return ModelPost
     */
    public function getPostAction(string $postId): ModelPost
    {
        return $this->handle(new GetPost($postId));
    }

    /**
     * @param Request $request
     * @return ModelPost
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @View()
     * @Post("/posts")
     */
    public function createPostAction(Request $request): ModelPost
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
    }
}
