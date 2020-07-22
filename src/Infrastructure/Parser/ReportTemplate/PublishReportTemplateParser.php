<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\PublishReportTemplateCommand;
use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailPublishReportTemplateAction;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class PublishReportTemplateParser implements PublishReportTemplateParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * PublishReportTemplateParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return PublishReportTemplateCommandInterface
     * @throws FailPublishReportTemplateAction
     */
    public function parse(Request $request) : PublishReportTemplateCommandInterface
    {
        try {
            /** @var ReportTemplateId $reportTemplateId */
            $reportTemplateId = $request->get('reportTemplateId');
            if (!$reportTemplateId instanceof ReportTemplateId) {
                throw new InvalidArgumentException('ReportTemplate Id is required field');
            }
            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            return new PublishReportTemplateCommand($reportTemplateId, $user);
        } catch (InvalidArgumentException $exception) {
            throw new FailPublishReportTemplateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailPublishReportTemplateAction("Bad request. " . $exception->getMessage());
        }
    }
}
