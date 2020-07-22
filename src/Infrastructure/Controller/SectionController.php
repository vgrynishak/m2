<?php

namespace App\Infrastructure\Controller;

use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\App\Command\Section\CreateSectionCommandInterface;
use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Command\Section\EditSectionCommandInterface;
use App\Infrastructure\Exception\Section\FailChangeSectionPositionAction;
use App\Infrastructure\Exception\Section\FailCreateSectionAction;
use App\Infrastructure\Exception\Section\FailDeleteSectionAction;
use App\Infrastructure\Exception\Section\FailEditSectionAction;
use App\Infrastructure\Parser\Section\ChangeSectionPositionParserInterface;
use App\Infrastructure\Parser\Section\CreateSectionParserInterface;
use App\Infrastructure\Parser\Section\DeleteSectionParserInterface;
use App\Infrastructure\Parser\Section\EditSectionParserInterface;
use FOS\RestBundle\View\View;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SectionController extends BaseController
{
    /**
     * @Rest\Post("/sections/create")
     *
     * @SWG\Post(
     *     operationId="Section create",
     *     tags={"Section"},
     *     summary="Section create",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="X-ACCESS-TOKEN",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="Bearer TOKEN",
     *         description="Authorization Token"
     *     ),
     *     @SWG\Parameter(
     *          name="createSectionRequest",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="createSectionRequest", type="object",
     *                  @SWG\Property(
     *                      property="reportTemplateId",
     *                      type="string",
     *                      example="ac0cec75-b17d-4509-b15a-29621c41b18d"),
     *                  @SWG\Property(
     *                      property="sectionId",
     *                      type="string",
     *                      example="7501dca9-9a92-487a-8cf7-5dd872fd8064"),
     *                  @SWG\Property(property="title", type="string", example="Fire Inspection Title")
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="201",
     *         description="Section has been created"
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
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param CreateSectionParserInterface $createSectionParser
     *
     * @return View
     */
    public function postCreateAction(Request $request, CreateSectionParserInterface $createSectionParser)
    {
        try {
            /** @var CreateSectionCommandInterface $createSectionCommand */
            $createSectionCommand = $createSectionParser->parse($request);
            $this->handleMessage($createSectionCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreateSectionAction $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/sections/change-position")
     *
     * @SWG\Put(
     *     operationId="Change Section position",
     *     tags={"Section"},
     *     summary="Change Section position",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="X-ACCESS-TOKEN",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="Bearer TOKEN",
     *         description="Authorization Token"
     *     ),
     *     @SWG\Parameter(
     *          name="changeSectionPositionRequest",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="changeSectionPositionRequest", type="object",
     *                  @SWG\Property(
     *                      property="id",
     *                      type="string",
     *                      example="7501dca9-9a92-487a-8cf7-5dd872fd8064"),
     *                  @SWG\Property(
     *                      property="newPosition",
     *                      type="string",
     *                      example="2")
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Section position has been changed"
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
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param ChangeSectionPositionParserInterface $changePositionParser
     *
     * @return View|JsonResponse
     * @throws Exception
     */
    public function putChangePositionAction(
        Request $request,
        ChangeSectionPositionParserInterface $changePositionParser
    ) {
        try {
            /** @var ChangeSectionPositionCommandInterface $changeSectionPositionCommand */
            $changeSectionPositionCommand = $changePositionParser->parse($request);

            return new View($this->handleMessage($changeSectionPositionCommand), Response::HTTP_OK);
        } catch (FailChangeSectionPositionAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/sections/edit")
     *
     * @SWG\Put(
     *     operationId="Edit Section",
     *     tags={"Section"},
     *     summary="Edit Section",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="X-ACCESS-TOKEN",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="Bearer TOKEN",
     *         description="Authorization Token"
     *     ),
     *     @SWG\Parameter(
     *          name="changeSectionPositionRequest",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="editSectionRequest", type="object",
     *                  @SWG\Property(
     *                      property="id",
     *                      type="string",
     *                      example="7501dca9-9a92-487a-8cf7-5dd872fd8064"),
     *                  @SWG\Property(
     *                      property="title",
     *                      type="string",
     *                      example="new_title")
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Section has been changed"
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
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param EditSectionParserInterface $editSectionParser
     *
     * @return View|JsonResponse
     * @throws Exception
     */
    public function putEditAction(
        Request $request,
        EditSectionParserInterface $editSectionParser
    ) {
        try {
            /** @var EditSectionCommandInterface $editSectionCommand */
            $editSectionCommand = $editSectionParser->parse($request);

            return new View($this->handleMessage($editSectionCommand), Response::HTTP_OK);
        } catch (FailEditSectionAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/sections/delete/{sectionId}")
     * @ParamConverter("sectionId", class="App\Core\Model\Section\SectionId", converter="section_id.param_converter")
     *
     * @param Request $request
     * @param DeleteSectionParserInterface $parser
     * @return View | JsonResponse
     * @SWG\Delete(
     *     operationId="delete section",
     *     tags={"Section"},
     *     summary="Delete section by section UUid",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *         in="path",
     *         name="sectionId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="204",
     *         description="Section has been deleted"
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
     *
     * @Security(name="Bearer")
     */
    public function deleteAction(Request $request, DeleteSectionParserInterface $parser)
    {
        try {
            /** @var DeleteSectionCommandInterface $deleteSectionCommand */
            $deleteSectionCommand = $parser->parse($request);
            $this->handleMessage($deleteSectionCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_NO_CONTENT);
        } catch (FailDeleteSectionAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
