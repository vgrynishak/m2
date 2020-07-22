<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\Exception\InfoSource\FailGetInfoSourceListByDictionaryId;
use App\Infrastructure\Parser\InfoSource\InfoSourceListByDictionaryIdParserInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Exception;
use App\Infrastructure\Adapter\InfoSource\Full as InfoSourceFullAdapter;

class InfoSourceController extends BaseController
{
    /**
     * @Rest\Get("/info-source/by-dictionary-id/{dictionaryId}")
     * @ParamConverter(
     *     "dictionaryId",
     *      class="App\Core\Model\Item\InformationItem\Dictionary\DictionaryId",
     *      converter="dictionary_id.param_converter"
     * )
     *
     * @SWG\Get(
     *     operationId="Info Source list by Dictionary Id",
     *     tags={"Dictionary Info Source"},
     *     summary="Info Source list by Dictionary UUID",
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
     *         description="Example: 39234673-c21f-4126-9f73-b6e3f368cabb",
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
     *         description="Info Source list has been gotten by Device id"
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
     * @param InfoSourceListByDictionaryIdParserInterface $parser
     *
     * @return View | JsonResponse
     * @throws Exception
     */
    public function getInfoSourceByDeviceId(Request $request, InfoSourceListByDictionaryIdParserInterface $parser)
    {
        try {
            $command = $parser->parse($request);

            $fields = $this->handleMessage($command);

            return new View(InfoSourceFullAdapter::adaptList($fields), Response::HTTP_OK);
        } catch (FailGetInfoSourceListByDictionaryId $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            return new View(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
