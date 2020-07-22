<?php

namespace App\Infrastructure\Controller\Item;

use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Exception\Item\FailCreateListItem;
use App\Infrastructure\Exception\Item\FailUpdateListItem;
use App\Infrastructure\Parser\Item\ListItem\CreateListItemParserInterface;
use App\Infrastructure\Parser\Item\ListItem\UpdateListItemParserInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

class ListItemController extends BaseController
{
    /**
     * @Rest\POST("/items/list")
     * @SWG\Post(
     *     operationId="Create List Item",
     *     tags={"Item"},
     *     summary="Create List Item",
     *     produces={"application/json"},
     *      @SWG\Parameter(
     *         name="X-ACCESS-TOKEN",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="Bearer TOKEN",
     *         description="Authorization Token"
     *     ),
     *     @SWG\Parameter(
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac1f",
     *         in="path",
     *         name="deviceId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="201",
     *         description="Item has been created"
     * )
     *
     * @SWG\Response(
     *         response="400",
     *         description="Bad request"
     * )
     *
     * @SWG\Response(
     *         response="401",
     *         description="JWT Token not found | Expired JWT Token"
     * )
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param CreateListItemParserInterface $parser
     * @return View
     */
    public function create(Request $request, CreateListItemParserInterface $parser): ?View
    {
        try {
            $createListItemCommand = $parser->parse($request);
            $this->handleMessage($createListItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreateListItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/items/list")
     * @SWG\Put(
     *     operationId="Update List Item",
     *     tags={"Item"},
     *     summary="Update List Item",
     *     produces={"application/json"},
     *      @SWG\Parameter(
     *         name="X-ACCESS-TOKEN",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="Bearer TOKEN",
     *         description="Authorization Token"
     *     ),
     *     @SWG\Parameter(
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac1f",
     *         in="path",
     *         name="deviceId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Item has been created"
     * )
     *
     * @SWG\Response(
     *         response="400",
     *         description="Bad request"
     * )
     *
     * @SWG\Response(
     *         response="401",
     *         description="JWT Token not found | Expired JWT Token"
     * )
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param UpdateListItemParserInterface $parser
     * @return View
     */
    public function update(Request $request, UpdateListItemParserInterface $parser): ?View
    {
        try {
            $updateListItemCommand = $parser->parse($request);
            $this->handleMessage($updateListItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailUpdateListItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
