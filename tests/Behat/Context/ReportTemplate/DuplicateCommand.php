<?php

namespace App\Tests\Behat\Context\ReportTemplate;

use App\Infrastructure\Exception\ReportTemplate\FailDuplicateAction;
use App\App\Command\ReportTemplate\DuplicateCommand as rtDuplicateCommand;
use App\Core\Model\User\User;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Connection;
use App\Core\Model\ReportTemplate\ReportTemplateId;

class DuplicateCommand implements Context
{
    use HandleTrait;

    /** @var string */
    private $reportTemplateParamId;
    /** @var JsonResponse */
    private $duplicateResponse;
    /** @var Connection */
    private $doctrineConnection;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepositoryInterface;

    /**
     * DuplicateCommand constructor.
     * @param MessageBusInterface $messageBus
     * @param Connection $connection
     * @param UserQueryRepositoryInterface $userQueryRepositoryInterface
     */
    public function __construct(
        MessageBusInterface $messageBus,
        Connection $connection,
        UserQueryRepositoryInterface $userQueryRepositoryInterface
    ) {
        $this->messageBus = $messageBus;
        $this->doctrineConnection = $connection;
        $this->userQueryRepositoryInterface = $userQueryRepositoryInterface;
    }

    /**
     * @param $id
     *
     * @Given ReportTemplate param id :arg1
     */
    public function reporttemplateParamId($id)
    {
        $this->reportTemplateParamId = $id;
    }

    /**
     * @When I call handle duplicate message Response
     */
    public function iCallHandleDuplicateMessageResponse()
    {
        try {
            /** @var User $userModel */
            $userModel = $this->userQueryRepositoryInterface->findByUsername('admin@test.com');
            /** @var rtDuplicateCommand $duplicateReportTemplateCommand */
            $duplicateReportTemplateCommand =
                new rtDuplicateCommand(new ReportTemplateId($this->reportTemplateParamId), $userModel);

            $this->doctrineConnection->beginTransaction();
            $this->duplicateResponse = new JsonResponse(
                $this->handle($duplicateReportTemplateCommand), Response::HTTP_OK
            );
            $this->doctrineConnection->rollBack();
        } catch (FailDuplicateAction $exception) {
            $this->duplicateResponse = new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) {
            $this->duplicateResponse = new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            $this->duplicateResponse = new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param $status
     *
     * @Then I should have report template result Response with status :arg1
     */
    public function iShouldHaveReportTemplateResultResponseWithStatus($status)
    {
        Assert::assertEquals($this->duplicateResponse->getStatusCode(), $status);
    }
}
