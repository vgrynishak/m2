<?php

namespace App\Infrastructure\Controller\Item;

use App\Infrastructure\Adapter\Item\ItemCategory\Full as ItemCategoryAdapter;
use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Parser\Item\ItemCategory\ItemCategoryParserInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class ItemTypeController extends BaseController
{
    /**
     * @Rest\Get("/item-types/for-paragraph-with-device-grouped-by-categories")
     *
     * @SWG\Get(
     *     operationId="Get list item type grouped by category with device",
     *     tags={"ItemType"},
     *     summary="Get list item type grouped by category with device",
     *     produces={"application/json"},
     *      @SWG\Parameter(
     *         name="X-ACCESS-TOKEN",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="Bearer TOKEN",
     *         description="Authorization Token"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="List grouped by category"
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
     * @param ItemCategoryParserInterface $itemCategoryParser
     * @return View | JsonResponse
     */
    public function getItemTypesWithDevice(ItemCategoryParserInterface $itemCategoryParser)
    {
        try {
            $groupedByCategoryQuery = $itemCategoryParser->parse(true);
            $groups = $this->handleMessage($groupedByCategoryQuery);
            return new View(['getListItemTypesWithDeviceResponse' => ItemCategoryAdapter::adaptCollection($groups)]);
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/item-types/for-paragraph-without-device-grouped-by-categories")
     *
     * @SWG\Get(
     *     operationId="Get list item tepe grouped by category without device",
     *     tags={"ItemType"},
     *     summary="Get list item tepe grouped by category without device",
     *     produces={"application/json"},
     *      @SWG\Parameter(
     *         name="X-ACCESS-TOKEN",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="Bearer TOKEN",
     *         description="Authorization Token"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="List grouped by category"
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
     * @param ItemCategoryParserInterface $itemCategoryParser
     * @return View | JsonResponse
     */
    public function getItemTypesWithoutDevice(ItemCategoryParserInterface $itemCategoryParser)
    {
        try {
            $groupedByCategoryQuery = $itemCategoryParser->parse(false);
            $groups = $this->handleMessage($groupedByCategoryQuery);
            return new View(['getListItemTypesWithoutDeviceResponse' => ItemCategoryAdapter::adaptCollection($groups)]);
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
