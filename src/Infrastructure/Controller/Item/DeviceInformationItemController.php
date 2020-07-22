<?php

namespace App\Infrastructure\Controller\Item;

use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Exception\Item\FailCreateDeviceInformationItem;
use App\Infrastructure\Exception\Item\FailUpdateDeviceInformationItem;
use App\Infrastructure\Parser\Item\DeviceInformationItem\CreateDeviceInformationItemParserInterface;
use App\Infrastructure\Parser\Item\DeviceInformationItem\UpdateDeviceInformationItemParserInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

class DeviceInformationItemController extends BaseController
{
    /**
     * @Rest\POST("/items/device-information")
     * @SWG\Post(
     *     operationId="Create DeviceInformation Item",
     *     tags={"Item"},
     *     summary="Create DeviceInformation Item",
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
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="createDeviceInformationItem",
     *                  type="object",
     *                  @SWG\Property(
     *                      property="infoSource",
     *                      type="object",
     *                      @SWG\Property(
     *                          property="infoSourceid",
     *                          type="string",
     *                          example="backflow_make"
     *                      )
     *                  ),
     *                  @SWG\Property(
     *                       property="id",
     *                       type="string",
     *                       example="ac0cec75-b17d-4509-b15a-29621c41b18d"
     *                  ),
     *                  @SWG\Property(
     *                       property="paragraphId",
     *                       type="string",
     *                       example="5d199f62-7659-4258-b4ac-d93ae5a9740d"
     *                  ),
     *                  @SWG\Property(
     *                       property="label",
     *                       type="string",
     *                       example="Item label"
     *                  ),
     *                  @SWG\Property(
     *                       property="itemTypeId",
     *                       type="string",
     *                       example="information_device_related"
     *                  ),
     *                  @SWG\Property(
     *                       property="printable",
     *                       type="boolean",
     *                       example=true
     *                  ),
     *              )
     *          )
     *      )
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
     *
     * @param Request $request
     * @param CreateDeviceInformationItemParserInterface $parser
     * @return View
     */
    public function create(Request $request, CreateDeviceInformationItemParserInterface $parser): ?View
    {
        try {
            $createDeviceInformationItemCommand = $parser->parse($request);
            $this->handleMessage($createDeviceInformationItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreateDeviceInformationItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/items/device-information")
     * @SWG\Put(
     *     operationId="Update DeviceInformation Item",
     *     tags={"Item"},
     *     summary="Update DeviceInformation Item",
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
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="updateUpdateDeviceInformationItem",
     *                  type="object",
     *                  @SWG\Property(
     *                      property="infoSource",
     *                      type="object",
     *                      @SWG\Property(
     *                          property="infoSourceid",
     *                          type="string",
     *                          example="backflow_size"
     *                      )
     *                  ),
     *                  @SWG\Property(
     *                       property="id",
     *                       type="string",
     *                       example="ac0cec75-b17d-4509-b15a-29621c41b18d"
     *                  ),
     *                  @SWG\Property(
     *                       property="paragraphId",
     *                       type="string",
     *                       example="5d199f62-7659-4258-b4ac-d93ae5a9740d"
     *                  ),
     *                  @SWG\Property(
     *                       property="label",
     *                       type="string",
     *                       example="Item label"
     *                  ),
     *                  @SWG\Property(
     *                       property="itemTypeId",
     *                       type="string",
     *                       example="information_device_related"
     *                  ),
     *                  @SWG\Property(
     *                       property="printable",
     *                       type="boolean",
     *                       example=true
     *                  ),
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Item has been updated"
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
     *
     * @param Request $request
     * @param UpdateDeviceInformationItemParserInterface $parser
     * @return View
     */
    public function update(Request $request, UpdateDeviceInformationItemParserInterface $parser): ?View
    {
        try {
            $updateDeviceInformationItemCommand = $parser->parse($request);
            $this->handleMessage($updateDeviceInformationItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailUpdateDeviceInformationItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
