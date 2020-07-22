<?php

namespace App\Tests\Behat\Context\ReportTemplate;

use App\Core\Model\Exception\InvalidServiceIdException;
use App\Infrastructure\Exception\ReportTemplate\FailGetListAction;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Infrastructure\Parser\ReportTemplate\GetListByServiceId as GetListByServiceIdParser;
use App\Core\Model\Service\ServiceId;

class GetListByServiceIdQuery implements Context
{
    use HandleTrait;

    /** @var string */
    private $serviceParamId;
    /** @var JsonResponse */
    private $listResponse;
    /** @var GetListByServiceIdParser */
    private $getListByServiceIdParser;

    /**
     * GetListByServiceIdQuery constructor.
     * @param MessageBusInterface $messageBus
     * @param GetListByServiceIdParser $getListByServiceIdParser
     */
    public function __construct(MessageBusInterface $messageBus, GetListByServiceIdParser $getListByServiceIdParser)
    {
        $this->messageBus = $messageBus;
        $this->getListByServiceIdParser = $getListByServiceIdParser;
    }

    /**
     * @param $serviceParamId
     *
     * @Given Service param id :arg1
     */
    public function serviceParamId($serviceParamId)
    {
        $this->serviceParamId = $serviceParamId;
    }

    /**
     * @When I call handle list message Response
     *
     * @throws Exception
     */
    public function iCallHandleListMessageResponse()
    {
        try {
            $request = new Request(['serviceId' => new ServiceId($this->serviceParamId)]);

            $reportTemplateQuery = $this->getListByServiceIdParser->parse($request);
            $this->listResponse = new JsonResponse($this->handle($reportTemplateQuery), Response::HTTP_OK);
        } catch (FailGetListAction | InvalidServiceIdException $exception) {
            $this->listResponse = new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param $status
     *
     * @Then I should have report templates list Response with status :arg1
     */
    public function iShouldHaveReportTemplatesListResponseWithStatus($status)
    {
        Assert::assertEquals($this->listResponse->getStatusCode(), $status);
    }
}
