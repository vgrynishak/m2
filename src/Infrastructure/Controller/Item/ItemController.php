<?php

namespace App\Infrastructure\Controller\Item;

use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Exception\Item\FailChangeItemPosition;
use App\Infrastructure\Parser\Item\ChangeItemPosition\ChangeItemPositionParserInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

class ItemController extends BaseController
{
    /**
     * @Rest\Put("/items/change-position")
     * @SWG\Put(
     *     operationId="Change Position Item",
     *     tags={"Item"},
     *     summary="Change Position Item",
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
     *              @SWG\Property(property="changeItemPositionRequest", type="object",
     *                  @SWG\Property(property="id", type="string", example="ac0cec75-b17d-4509-b15a-29621c41b18d"),
     *                  @SWG\Property(
     *                       property="newPosition",
     *                       type="integer",
     *                       example="2"
     *                  ),
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Item has been changed position"
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
     * @param ChangeItemPositionParserInterface $parser
     * @return View
     */
    public function changePosition(Request $request, ChangeItemPositionParserInterface $parser): ?View
    {
        try {
            $changeItemPositionCommand = $parser->parse($request);
            $this->handleMessage($changeItemPositionCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailChangeItemPosition | \Exception $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
