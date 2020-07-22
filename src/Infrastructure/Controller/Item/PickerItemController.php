<?php

namespace App\Infrastructure\Controller\Item;

use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Exception\Item\FailCreatePickerItem;
use App\Infrastructure\Exception\Item\FailUpdatePickerItem;
use App\Infrastructure\Parser\Item\PickerItem\CreatePickerItemParserInterface;
use App\Infrastructure\Parser\Item\PickerItem\UpdatePickerItemParserInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

class PickerItemController extends BaseController
{
    /**
     * @Rest\POST("/items/picker")
     * @SWG\Post(
     *     operationId="Create Picker Item",
     *     tags={"Item"},
     *     summary="Create Picker Item",
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
     * @param CreatePickerItemParserInterface $parser
     * @return View
     */
    public function create(Request $request, CreatePickerItemParserInterface $parser): ?View
    {
        try {
            $createPickerItemCommand = $parser->parse($request);
            $this->handleMessage($createPickerItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreatePickerItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/items/picker")
     * @SWG\Put(
     *     operationId="Update Picker Item",
     *     tags={"Item"},
     *     summary="Update Picker Item",
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
     * @param UpdatePickerItemParserInterface $parser
     * @return View
     */
    public function update(Request $request, UpdatePickerItemParserInterface $parser): ?View
    {
        try {
            $updatePickerItemCommand = $parser->parse($request);
            $this->handleMessage($updatePickerItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailUpdatePickerItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
