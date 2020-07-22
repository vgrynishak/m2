<?php

namespace App\Infrastructure\Controller;

use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Infrastructure\Exception\Paragraph\FailChangeParagraphPositionAction;
use App\Infrastructure\Exception\Paragraph\FailCreateRootWithoutDevice;
use App\Infrastructure\Exception\Paragraph\FailDeleteParagraphAction;
use App\Infrastructure\Exception\Paragraph\FailEditAction;
use App\Infrastructure\Parser\Paragraph\CreateChildWithDeviceParserInterface;
use App\Infrastructure\Parser\Paragraph\ChangeParagraphPositionParserInterface;
use App\Infrastructure\Parser\Paragraph\CreateRootWithoutDeviceParserInterface;
use App\Infrastructure\Parser\Paragraph\DeleteParagraphParserInterface;
use App\Infrastructure\Parser\Paragraph\EditParagraphParserInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Security;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;
use App\Infrastructure\Parser\Paragraph\CreateRootWithDeviceParserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ParagraphController extends BaseController
{
    /**
     * @Rest\Post("/paragraphs/create-root-with-device")
     *
     * @param Request $request
     * @param CreateRootWithDeviceParserInterface $createRootWithDeviceParser
     * @return View
     *
     * @SWG\Post(
     *     operationId="Create root paragraph with device",
     *     tags={"Paragraph"},
     *     summary="Create root paragraph with device",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="createParagraphRequest", type="object",
     *                  @SWG\Property(property="id", type="string", example="ac0cec75-b17d-4509-b15a-29621c41b18d"),
     *                  @SWG\Property(
     *                       property="sectionId",
     *                       type="string",
     *                       example="5d199f62-7659-4258-b4ac-d93ae5a9740d"
     *                  ),
     *                  @SWG\Property(
     *                       property="title",
     *                       type="string",
     *                       example="Paragraph Title"
     *                  ),
     *                  @SWG\Property(
     *                       property="deviceId",
     *                       type="string",
     *                       example="e213abd6-577e-4526-b21b-415aa839f0c0"
     *                  ),
     *                  @SWG\Property(
     *                       property="filterId",
     *                       type="string",
     *                       example="3a45f743-424c-4839-a395-ead0cd2e70c3"
     *                  ),
     *                  @SWG\Property(
     *                       property="styleTemplateId",
     *                       type="string",
     *                       example="804b1bf2-36e1-4893-b383-d8c68c7336dd"
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="201",
     *         description="Root Paragraph with device has been created"
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
     */
    public function postCreateRootWithDeviceAction(
        Request $request,
        CreateRootWithDeviceParserInterface $createRootWithDeviceParser
    ) {
        try {
            $createRootWithDeviceCommand = $createRootWithDeviceParser->parse($request);
            $this->handleMessage($createRootWithDeviceCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreateAction $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/paragraphs/create-root-without-device")
     *
     * @param Request $request
     *
     * @param CreateRootWithoutDeviceParserInterface $createParagraphParser
     * @return View | JsonResponse
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     * @throws InvalidStyleTemplateIdException
     * @SWG\Post(
     *     operationId="Create root paragraph without device",
     *     tags={"Paragraph"},
     *     summary="Create root paragraph without device",
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
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="createParagraphRequest", type="object",
     *                  @SWG\Property(property="id", type="string", example="ac0cec75-b17d-4509-b15a-29621c41b18d"),
     *                  @SWG\Property(
     *                       property="sectionId",
     *                       type="string",
     *                       example="0dcf3e2a-6bf6-4446-9136-3ddcc84e5ac7"
     *                  ),
     *                  @SWG\Property(
     *                       property="title",
     *                       type="string",
     *                       example="Paragraph Title"
     *                  ),
     *                  @SWG\Property(
     *                       property="styleTemplateId",
     *                       type="string",
     *                       example="804b1bf2-36e1-4893-b383-d8c68c7336dd"
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="201",
     *         description="Root Paragraph without device has been created"
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
     */
    public function postCreateRootWithoutDeviceAction(
        Request $request,
        CreateRootWithoutDeviceParserInterface $createParagraphParser
    ) {
        try {
            /** @var CreateRootWithoutDeviceCommandInterface $createParagraphCommand */
            $createParagraphCommand = $createParagraphParser->parse($request);
            $this->handleMessage($createParagraphCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreateRootWithoutDevice $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/paragraphs/create-child-with-device")
     * @param Request $request
     * @param CreateChildWithDeviceParserInterface $createChildWithDeviceParser
     * @return View
     *
     * @SWG\Post(
     *     operationId="Create child paragraph with device",
     *     tags={"Paragraph"},
     *     summary="Create child paragraph with device",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="createParagraphRequest", type="object",
     *                  @SWG\Property(property="id", type="string", example="cf811ed6-aa03-41da-a2e8-f2e4c31b2bc0"),
     *                  @SWG\Property(
     *                       property="parentId",
     *                       type="string",
     *                       example="70df9ea7-4949-450e-b21a-9e5f1982e50c"
     *                  ),
     *                  @SWG\Property(
     *                       property="title",
     *                       type="string",
     *                       example="Child Paragraph Title"
     *                  ),
     *                  @SWG\Property(
     *                       property="deviceId",
     *                       type="string",
     *                       example="63bea125-46f1-4d59-b6ec-65000d13ac1f"
     *                  ),
     *                  @SWG\Property(
     *                       property="filterId",
     *                       type="string",
     *                       example="on_site"
     *                  ),
     *                  @SWG\Property(
     *                       property="styleTemplateId",
     *                       type="string",
     *                       example="3a45f743-424c-4839-a395-ead0cd2e70c3"
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="201",
     *         description="Child Paragraph with device has been created"
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
     */
    public function postCreateChildWithDeviceAction(
        Request $request,
        CreateChildWithDeviceParserInterface $createChildWithDeviceParser
    ) {
        try {
            /** @var CreateChildWithDeviceCommandInterface $createChildWithDeviceCommand */
            $createChildWithDeviceCommand = $createChildWithDeviceParser->parse($request);
            $this->handleMessage($createChildWithDeviceCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_CREATED);
        } catch (FailCreateAction $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/paragraphs/change-position")
     *
     * @SWG\Put(
     *     operationId="Change Paragraph position",
     *     tags={"Paragraph"},
     *     summary="Change Paragraph position",
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
     *          name="changeParagraphPositionRequest",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="changeParagraphPositionRequest", type="object",
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
     *         description="Paragraph position has been changed"
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
     * @param ChangeParagraphPositionParserInterface $changePositionParser
     *
     * @return View|JsonResponse
     * @throws Exception
     */
    public function putChangePositionAction(
        Request $request,
        ChangeParagraphPositionParserInterface $changePositionParser
    ) {
        try {
            /** @var ChangeParagraphPositionCommandInterface $changeParagraphPositionCommand */
            $changeParagraphPositionCommand = $changePositionParser->parse($request);

            return new View($this->handleMessage($changeParagraphPositionCommand    ), Response::HTTP_OK);
        } catch (FailChangeParagraphPositionAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/paragraphs/edit/{paragraphId}")
     * @ParamConverter(
     *     "paragraphId",
     *      class="App\Core\Model\Paragraph\ParagraphId",
     *      converter="paragraph_id.param_converter"
     * )
     *
     * @SWG\Put(
     *     operationId="edit paragraph",
     *     tags={"Paragraph"},
     *     summary="Edit paragraph by UUID",
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
     *         description="Example: 1dff1277-5609-49a2-9c09-ebcae35aba39",
     *         in="path",
     *         name="paragraphId",
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
     *              @SWG\Property(property="editParagraphRequest", type="object",
     *                 @SWG\Property(property="title", type="string", example="Edited Paragraph Title")
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Report template updated"
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
     * @param EditParagraphParserInterface $editParagraphParser
     * @return View|JsonResponse
     * @throws Exception
     */
    public function putEditAction(Request $request, EditParagraphParserInterface $editParagraphParser)
    {
        try {
            /** @var EditParagraphCommandInterface $editParagraphCommand */
            $editParagraphCommand = $editParagraphParser->parse($request);

            return new View($this->handleMessage($editParagraphCommand), Response::HTTP_OK);

        } catch (FailEditAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/paragraphs/delete/{paragraphId}")
     * @ParamConverter(
     *     "paragraphId",
     *     class="App\Core\Model\Paragraph\ParagraphId",
     *     converter="paragraph_id.param_converter"
     * )
     *
     * @param Request $request
     * @param DeleteParagraphParserInterface $parser
     * @return View | JsonResponse
     * @SWG\Delete(
     *     operationId="delete paragraph",
     *     tags={"Paragraph"},
     *     summary="Delete paragraph by paragraph UUid",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *         in="path",
     *         name="paragraphId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="204",
     *         description="Paragraph has been deleted"
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
    public function deleteAction(Request $request, DeleteParagraphParserInterface $parser)
    {
        try {
            /** @var DeleteParagraphCommandInterface $deleteCommand */
            $deleteCommand = $parser->parse($request);
            $this->handleMessage($deleteCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_NO_CONTENT);
        } catch (FailDeleteParagraphAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
