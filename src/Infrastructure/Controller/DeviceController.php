<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\Adapter\Group\Full as GroupAdapter;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use App\Infrastructure\Parser\Device\ChildrenDeviceParserInterface;
use App\Infrastructure\Parser\Device\RootDeviceParserInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;

class DeviceController extends BaseController
{
    /**
     * @Rest\POST("/devices/list-for-root-paragraph/{deviceId}")
     * @ParamConverter(
     *     "deviceId",
     *      class="App\Core\Model\Device\DeviceId",
     *      converter="device_id.param_converter"
     * )
     * @SWG\Post(
     *     operationId="Get list for root paragraph action",
     *     tags={"Device"},
     *     summary="Get list for root paragraph",
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
     *         description="List Group For Root paragraph"
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
     * @param RootDeviceParserInterface $rootDeviceParser
     * @return View | JsonResponse
     */
    public function getListForRootParagraphAction(Request $request, RootDeviceParserInterface $rootDeviceParser)
    {
        try {
            $findByRootDeviceQuery = $rootDeviceParser->parse($request);
            $groups = $this->handleMessage($findByRootDeviceQuery);
            return new View(GroupAdapter::adaptCollection($groups));
        } catch (FailGetListDevice | \Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\POST("/devices/list-for-children-paragraph/{deviceId}")
     * @ParamConverter(
     *     "deviceId",
     *      class="App\Core\Model\Device\DeviceId",
     *      converter="device_id.param_converter"
     * )
     * @SWG\Post(
     *     operationId="Get list for children paragraph action",
     *     tags={"Device"},
     *     summary="Get list for children paragraph",
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
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="getListForChildrenParagraph",
     *                  type="object",
     *                  @SWG\Property(
     *                      property="groupId",
     *                      type="string",
     *                      example="related_to_inspected_device/every_on_site_device"
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="List Group For Children paragraph"
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
     * @param ChildrenDeviceParserInterface $childrenDeviceParser
     * @return View | JsonResponse
     */
    public function getListForChildrenParagraphAction(
        Request $request,
        ChildrenDeviceParserInterface $childrenDeviceParser
    ) {
        try {
            $findByChildrenDeviceQuery = $childrenDeviceParser->parse($request);
            $groups = $this->handleMessage($findByChildrenDeviceQuery);
            return new View(GroupAdapter::adaptCollection($groups));
        } catch (FailGetListDevice | \Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/mother")
     */
    public function getMotger()
    {
        echo "hello Lesia Ivanivna\n";die;
    }
}
