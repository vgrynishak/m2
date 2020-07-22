<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommand;
use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\User;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailArchiveReportTemplateAction;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class ArchiveReportTemplateParser implements ArchiveReportTemplateParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * ArchiveReportTemplateParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return ArchiveReportTemplateCommandInterface
     * @throws FailArchiveReportTemplateAction
     */
    public function parse(Request $request): ArchiveReportTemplateCommandInterface
    {
        try {
            /** @var User $user */
            $user = $this->userQueryRepository->getUserFromToken();
            /** @var ReportTemplateId $reportTemplateId */
            $reportTemplateId = $request->get('reportTemplateId');

            if (!$reportTemplateId instanceof ReportTemplateId) {
                throw new InvalidArgumentException('Report Template Id is required field');
            }

            return new ArchiveReportTemplateCommand($reportTemplateId, $user);
        } catch (InvalidArgumentException $exception) {
            throw new FailArchiveReportTemplateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailArchiveReportTemplateAction("Bad request. " . $exception->getMessage());
        }
    }
}
