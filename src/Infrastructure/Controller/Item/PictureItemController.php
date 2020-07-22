<?php

namespace App\Infrastructure\Controller\Item;

use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Exception\Item\FailCreatePictureItem;
use App\Infrastructure\Exception\Item\FailUpdatePictureItem;
use App\Infrastructure\Parser\Item\PictureItem\CreatePictureItemParserInterface;
use App\Infrastructure\Parser\Item\PictureItem\UpdatePictureItemParserInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

class PictureItemController extends BaseController
{

    /**
     * @Rest\POST("/items/picture")
     * @SWG\Post(
     *     operationId="Create Picture Item",
     *     tags={"Item"},
     *     summary="Create Picture Item",
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
     *              @SWG\Property(property="createPictureItem", type="object",
     *                  @SWG\Property(property="id", type="string", example="ac0cec75-b17d-4509-b15a-29621c41b18d"),
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
     *                       example="photo / signature"
     *                  ),
     *                  @SWG\Property(
     *                       property="NFPAref",
     *                       type="string",
     *                       example="1"
     *                  ),
     *                  @SWG\Property(
     *                       property="required",
     *                       type="boolean",
     *                       example=true
     *                  ),
     *                  @SWG\Property(
     *                       property="remembered",
     *                       type="boolean",
     *                       example=false
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
     * @param Request $request
     * @param CreatePictureItemParserInterface $parser
     * @return View
     */
    public function create(Request $request, CreatePictureItemParserInterface $parser)
    {
        try {
            $createPictureItemCommand = $parser->parse($request);
            $this->handleMessage($createPictureItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreatePictureItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\PUT("/items/picture")
     * @SWG\Put(
     *     operationId="Update Picture Item",
     *     tags={"Item"},
     *     summary="Update Picture Item",
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
     *              @SWG\Property(property="updatePictureItem", type="object",
     *                  @SWG\Property(property="id", type="string", example="ac0cec75-b17d-4509-b15a-29621c41b18d"),
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
     *                       example="photo / signature"
     *                  ),
     *                  @SWG\Property(
     *                       property="NFPAref",
     *                       type="string",
     *                       example="1"
     *                  ),
     *                  @SWG\Property(
     *                       property="required",
     *                       type="boolean",
     *                       example=true
     *                  ),
     *                  @SWG\Property(
     *                       property="remembered",
     *                       type="boolean",
     *                       example=false
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
     * @param Request $request
     * @param UpdatePictureItemParserInterface $parser
     * @return View
     */
    public function update(Request $request, UpdatePictureItemParserInterface $parser)
    {
        try {
            $updatePictureItemCommand = $parser->parse($request);
            $this->handleMessage($updatePictureItemCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailUpdatePictureItem | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}