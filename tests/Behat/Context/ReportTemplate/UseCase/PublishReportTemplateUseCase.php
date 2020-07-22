<?php

namespace App\Tests\Behat\Context\ReportTemplate\UseCase;

use App\App\Command\ReportTemplate\PublishReportTemplateCommand;
use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\App\UseCase\ReportTemplate\PublishReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class PublishReportTemplateUseCase implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReportTemplateInterface */
    private $result;
    /** @var PublishReportTemplateCommandInterface */
    private $publishReportTemplateCommand;
    /** @var PublishReportTemplateUseCaseInterface */
    private $publishReportTemplateUseCase;

    /**
     * PublishReportTemplateUseCase constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param PublishReportTemplateUseCaseInterface $publishReportTemplateUseCase
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        PublishReportTemplateUseCaseInterface $publishReportTemplateUseCase
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->publishReportTemplateUseCase = $publishReportTemplateUseCase;
    }

    /**
     * @Given I'm set PublishReportTemplateCommandInterface with correct params
     */
    public function imSetPublishreporttemplatecommandinterfaceWithCorrectParams()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->publishReportTemplateCommand = new PublishReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            $user
        );
    }

    /**
     * @When I call PublishReportTemplateUseCase
     */
    public function iCallPublishreporttemplateusecase()
    {
        $this->result = $this->publishReportTemplateUseCase->publish($this->publishReportTemplateCommand);
    }

    /**
     * @Then I should get ReportTemplateInterface with published params
     */
    public function iShouldGetReporttemplateinterfaceWithPublishedParams()
    {
        if (!$this->result instanceof ReportTemplateInterface) {
            return false;
        }
        Assert::assertEquals($this->result->getStatus()->getId(), ReportTemplateStatus::PUBLISHED);
        Assert::assertEquals($this->result->getModifiedBy(), $this->publishReportTemplateCommand->getUser());
    }
}
