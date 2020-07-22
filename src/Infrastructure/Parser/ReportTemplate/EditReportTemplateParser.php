<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\EditReportTemplateCommand;
use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailEditReportTemplateAction;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class EditReportTemplateParser implements EditReportTemplateParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * EditReportTemplateParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return EditReportTemplateCommand
     * @throws FailEditReportTemplateAction
     */
    public function parse(Request $request): EditReportTemplateCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('editReportTemplateRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['editReportTemplateRequest'];

            $name = $data['name'] ?? null;
            if (!$name) {
                throw new InvalidArgumentException('Invalid Name');
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();
            /** @var ReportTemplateId $reportTemplateId */
            $reportTemplateId = $request->get('reportTemplateId');

            if (!$reportTemplateId instanceof ReportTemplateId) {
                throw new InvalidArgumentException('Report Template Id is required field');
            }

            /** @var EditReportTemplateCommandInterface $editReportTemplateCommand */
            $editReportTemplateCommand = new EditReportTemplateCommand($reportTemplateId, $user, $name);

            if (array_key_exists('description', $data)) {
                $editReportTemplateCommand->setDescription($data['description']);
            }

            return $editReportTemplateCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailEditReportTemplateAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailEditReportTemplateAction("Bad request. " . $exception->getMessage());
        }
    }
}
