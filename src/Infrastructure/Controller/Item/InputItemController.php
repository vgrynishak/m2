<?php

namespace App\Infrastructure\Controller\Item;

use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Exception\Item\FailCreateInputItem;
use App\Infrastructure\Exception\Item\FailUpdateInputItem;
use App\Infrastructure\Parser\Item\InputItem\CreateInputItemParserInterface;
use App\Infrastructure\Parser\Item\InputItem\UpdateInputItemParserInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

class InputItemController extends BaseController
{
    /**
     * @Rest\POST("/items/input")
     * @SWG\Post(
     *     operationId="Create Input Item",
     *     tags={"Item"},
     *     summary="Create Input Item",
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
     * @param CreateInputItemParserInterface $parser
     * @return View
     */
    public function create(Request $request, CreateInputItemParserInterface $parser): ?View
    {
        try {
            $createInputItemCommand = $parser->parse($request);
            $this->handleMessage($createInputItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreateInputItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/items/input")
     * @SWG\Put(
     *     operationId="Update Input Item",
     *     tags={"Item"},
     *     summary="Update Input Item",
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
     * @param UpdateInputItemParserInterface $parser
     * @return View
     */
    public function update(Request $request, UpdateInputItemParserInterface $parser): ?View
    {
        try {
            $updateInputItemCommand = $parser->parse($request);
            $this->handleMessage($updateInputItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailUpdateInputItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
