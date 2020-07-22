<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommand;
use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\User;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailDeleteReportTemplateAction;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class DeleteReportTemplateParser implements DeleteReportTemplateParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * DeleteById constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return DeleteReportTemplateCommandInterface
     * @throws FailDeleteReportTemplateAction
     */
    public function parse(Request $request) : DeleteReportTemplateCommandInterface
    {
        try {
            /** @var ReportTemplateId $reportTemplateId */
            $reportTemplateId = $request->get('reportTemplateId');
            if (!$reportTemplateId instanceof ReportTemplateId) {
                throw new InvalidArgumentException('Report Template Id is required field');
            }

            /** @var User $user */
            $user = $this->userQueryRepository->getUserFromToken();

            return new DeleteReportTemplateCommand($reportTemplateId, $user);
        } catch (InvalidArgumentException $exception) {
            throw new FailDeleteReportTemplateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailDeleteReportTemplateAction("Bad request. " . $exception->getMessage());
        }
    }
}
