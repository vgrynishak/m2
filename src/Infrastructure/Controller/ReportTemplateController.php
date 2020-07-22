<?php

namespace App\Infrastructure\Controller;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommand;
use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\GetByIdCommandInterface;
use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\App\Query\ReportTemplate\ReportTemplateQuery;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Infrastructure\Adapter\ReportTemplate\ShortForList;
use App\Infrastructure\Adapter\ReportTemplate\ShortForGetOneReportTemplate as ReportTemplateShortForGetOneAdapter;
use App\Infrastructure\Exception\ReportTemplate\FailArchiveReportTemplateAction;
use App\Infrastructure\Exception\ReportTemplate\FailDuplicateAction;
use App\Infrastructure\Exception\ReportTemplate\FailEditReportTemplateAction;
use App\Infrastructure\Exception\ReportTemplate\FailGetByIdAction;
use App\Infrastructure\Exception\ReportTemplate\FailPublishReportTemplateAction;
use App\Infrastructure\Parser\ReportTemplate\ArchiveReportTemplateParser;
use App\Infrastructure\Exception\ReportTemplate\FailDeleteReportTemplateAction;
use App\Infrastructure\Exception\ReportTemplate\FailGetListAction;
use App\Infrastructure\Parser\ReportTemplate\ArchiveReportTemplateParserInterface;
use App\Infrastructure\Parser\ReportTemplate\CreateReportTemplateParserInterface;
use App\Infrastructure\Parser\ReportTemplate\DeleteReportTemplateParserInterface;
use App\Infrastructure\Parser\ReportTemplate\Duplicate as DuplicateParser;
use App\Infrastructure\Parser\ReportTemplate\EditReportTemplateParserInterface;
use App\Infrastructure\Parser\ReportTemplate\GetByIdParserInterface;
use App\Infrastructure\Parser\ReportTemplate\GetByIdParserInterface as GetByIdParser;
use App\Infrastructure\Parser\ReportTemplate\GetListByServiceId as GetListByServiceIdParser;
use App\Infrastructure\Parser\ReportTemplate\PublishReportTemplateParserInterface;
use Exception;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class ReportTemplateController extends BaseController
{
    /**
     * @Rest\Post("/report-templates/create")
     *
     * @param Request $request
     *
     * @param CreateReportTemplateParserInterface $createReportTemplateParser
     *
     * @SWG\Post(
     *     operationId="report template create",
     *     tags={"Report Template"},
     *     summary="ReportTemplate create",
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
     *              @SWG\Property(property="createReportTemplateRequest", type="object",
     *                  @SWG\Property(property="id", type="string", example="ac0cec75-b17d-4509-b15a-29621c41b18d"),
     *                  @SWG\Property(
     *                       property="deviceId",
     *                       type="string",
     *                       example="0dcf3e2a-6bf6-4446-9136-3ddcc84e5ac7"
     *                  ),
     *                  @SWG\Property(
     *                       property="serviceId",
     *                       type="string",
     *                       example="05f0ba98-50a2-40d4-94b1-60f1c4453450"
     *                  ),
     *                  @SWG\Property(property="name", type="string", example="Fire Alarm System Inspection"),
     *                  @SWG\Property(property="description", type="string", example="Fire Alarm System desciption")
     *              )
     *          )
     *      )
     * )
     *
     * @SWG\Response(
     *         response="201",
     *         description="Report template has been created"
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
     * @return View | JsonResponse
     * @throws Exception
     */
    public function postCreateAction(
        Request $request,
        CreateReportTemplateParserInterface $createReportTemplateParser
    ) {
        try {
            /** @var CreateReportTemplateCommandInterface $reportTemplateAggregateCommand */
            $reportTemplateAggregateCommand = $createReportTemplateParser->parse($request);

            return new View($this->handleMessage($reportTemplateAggregateCommand), Response::HTTP_CREATED);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/report-templates/list-by-service/{serviceId}")
     * @ParamConverter("serviceId",class="App\Core\Model\Service\ServiceId", converter="service_id.param_converter")
     *
     * @SWG\Get(
     *     operationId="report templates list",
     *     tags={"Report Template"},
     *     summary="Get report templates list by Service UUid",
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
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *         in="path",
     *         name="serviceId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Report templates list have been returned"
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
     * @param GetListByServiceIdParser $getListByServiceIdParser
     *
     * @return View | JsonResponse
     * @throws Exception
     */
    public function getListByServiceAction(Request $request, GetListByServiceIdParser $getListByServiceIdParser)
    {
        try {
            /** @var ReportTemplateQuery $reportTemplateQuery */
            $reportTemplateQuery = $getListByServiceIdParser->parse($request);
            /** @var ReportTemplate[] $rtList */
            $rtList = $this->handleMessage($reportTemplateQuery);

            return new View(ShortForList::adaptList($rtList), Response::HTTP_OK);
        } catch (FailGetListAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/report-templates/delete/{reportTemplateId}")
     * @ParamConverter("reportTemplateId", class="App\Core\Model\ReportTemplate\ReportTemplateId", converter="report_template_id.param_converter")
     *
     * @param Request $request
     * @param DeleteReportTemplateParserInterface $deleteByIdParser
     * @return View | JsonResponse
     * @SWG\Delete(
     *     operationId="delete report template",
     *     tags={"Report Template"},
     *     summary="Delete report template by report template UUid",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *         in="path",
     *         name="reportTemplateId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="204",
     *         description="Report template has been deleted"
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
    public function deleteAction(Request $request, DeleteReportTemplateParserInterface $deleteByIdParser)
    {
        try {
            /** @var DeleteReportTemplateCommandInterface $deleteReportTemplateCommand */
            $deleteReportTemplateCommand = $deleteByIdParser->parse($request);
            $this->handleMessage($deleteReportTemplateCommand);

            return new View(['message' => 'ok'], JsonResponse::HTTP_NO_CONTENT);
        } catch (FailDeleteReportTemplateAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/report-templates/archive/{reportTemplateId}")
     *
     * @ParamConverter(
     *     "reportTemplateId",
     *      class="App\Core\Model\ReportTemplate\ReportTemplateId",
     *      converter="report_template_id.param_converter"
     * )
     * @param ArchiveReportTemplateParserInterface $archiveReportTemplateParser
     * @param Request $request
     *
     * @SWG\Put(
     *     operationId="archive report template",
     *     tags={"Report Template"},
     *     summary="Archive report templates by UUid",
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
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *         in="path",
     *         name="reportTemplateId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Report template archived"
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
     * @return View
     * @throws Exception
     */
    public function putArchiveAction(
        Request $request,
        ArchiveReportTemplateParserInterface $archiveReportTemplateParser
    ) {
        try {
            /** @var ArchiveReportTemplateCommandInterface $archiveReportTemplateCommand */
            $archiveReportTemplateCommand = $archiveReportTemplateParser->parse($request);
            $this->handleMessage($archiveReportTemplateCommand);
            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailArchiveReportTemplateAction $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/report-templates/publish/{reportTemplateId}")
     *
     * @ParamConverter("reportTemplateId", class="App\Core\Model\ReportTemplate\ReportTemplateId", converter="report_template_id.param_converter")
     *
     * @param Request $request
     * @param PublishReportTemplateParserInterface $publishParser
     * @return View|JsonResponse
     *
     * @SWG\Put(
     *     operationId="report template publish",
     *     tags={"Report Template"},
     *     summary="Publish Report Template ",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="reportTemplateId",
     *          in="path",
     *          description="ID of report template that needs to be updated
     *          Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *          required=true,
     *          type="string",
     *          format="string"
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Report template has been published"
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
    public function putPublish(Request $request, PublishReportTemplateParserInterface $publishParser)
    {
        try {
            /** @var PublishReportTemplateCommandInterface $publishReportTemplateCommand */
            $publishReportTemplateCommand = $publishParser->parse($request);

            return new View($this->handleMessage($publishReportTemplateCommand), Response::HTTP_OK);
        } catch (FailPublishReportTemplateAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/report-templates/duplicate/{reportTemplateId}")
     *
     * @ParamConverter(
     *     "reportTemplateId",
     *     class="App\Core\Model\ReportTemplate\ReportTemplateId",
     *     converter="report_template_id.param_converter"
     * )
     *
     * @param Request $request
     * @param DuplicateParser $duplicateParser
     * @return View|JsonResponse
     *
     * @SWG\Post(
     *     operationId="report template duplicate",
     *     tags={"Report Template"},
     *     summary="Duplicate Report Template ",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="reportTemplateId",
     *          in="path",
     *          description="ID of report template that needs to be duplicate Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *          required=true,
     *          type="string",
     *          format="string"
     *      )
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Report template has been duplicated"
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
    public function postDuplicate(Request $request, DuplicateParser $duplicateParser)
    {
        try {
            /** @var DuplicateParser $duplicateReportTemplateCommand */
            $duplicateReportTemplateCommand = $duplicateParser->parse($request);

            return new View($this->handleMessage($duplicateReportTemplateCommand), Response::HTTP_OK);
        } catch (FailDuplicateAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/report-templates/edit/{reportTemplateId}")
     *
     * @ParamConverter(
     *     "reportTemplateId",
     *      class="App\Core\Model\ReportTemplate\ReportTemplateId",
     *      converter="report_template_id.param_converter"
     * )
     *
     * @param Request $request
     * @param EditReportTemplateParserInterface $editReportTemplateParser
     * @return View
     *
     * @SWG\Put(
     *     operationId="edit report template",
     *     tags={"Report Template"},
     *     summary="Edit report templates by UUID",
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
     *         description="Example: 0bd45b9e-2b9b-4ae5-a60b-96d04cf189a9",
     *         in="path",
     *         name="reportTemplateId",
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
     *              @SWG\Property(property="editReportTemplateRequest", type="object",
     *                 @SWG\Property(property="name", type="string", example="Edited Report Template Name"),
     *                 @SWG\Property(property="description", type="string", example="For second building")
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
     */
    public function putEditAction(Request $request, EditReportTemplateParserInterface $editReportTemplateParser)
    {
        try {
            /** @var EditReportTemplateCommandInterface $editReportTemplateCommand */
            $editReportTemplateCommand = $editReportTemplateParser->parse($request);

            $this->handleMessage($editReportTemplateCommand);
            return new View(['message' => 'ok'], JsonResponse::HTTP_OK);
        } catch (FailEditReportTemplateAction $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/report-templates/{reportTemplateId}")
     * @ParamConverter(
     *     "reportTemplateId",
     *      class="App\Core\Model\ReportTemplate\ReportTemplateId",
     *      converter="report_template_id.param_converter"
     * )
     *
     * @SWG\Get(
     *     operationId="report template by Id",
     *     tags={"Report Template"},
     *     summary="Get report template by UUid",
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
     *         description="Example: 63bea125-46f1-4d59-b6ec-65000d13ac23",
     *         in="path",
     *         name="reportTemplateId",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     * )
     *
     * @SWG\Response(
     *         response="200",
     *         description="Report template has been gotten by ID"
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
     * @param GetByIdParser $parser
     *
     * @return View | JsonResponse
     * @throws Exception
     */
    public function getReportTemplate(Request $request, GetByIdParserInterface $parser)
    {
        try {
            /** @var GetByIdCommandInterface $getByIdCommand */
            $getByIdCommand = $parser->parse($request);
            /** @var ReportTemplateInterface $reportTemplate */
            $reportTemplate = $this->handleMessage($getByIdCommand);

            return new View(ReportTemplateShortForGetOneAdapter::adapt($reportTemplate), Response::HTTP_OK);
        } catch (FailGetByIdAction $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
