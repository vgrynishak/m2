<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\DuplicateCommand;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Core\Model\User\User;
use App\Infrastructure\Exception\ReportTemplate\FailDuplicateAction;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class Duplicate
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * Duplicate constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return DuplicateCommand
     * @throws FailDuplicateAction
     */
    public function parse(Request $request) : DuplicateCommand
    {
        try {
            /** @var ReportTemplateId $reportTemplateId */
            $reportTemplateId = $request->get('reportTemplateId');
            /** @var User $user */
            $user = $this->userQueryRepository->getUserFromToken();

            return new DuplicateCommand($reportTemplateId, $user);
        } catch (Exception $exception) {
            throw new FailDuplicateAction("Bad request");
        }
    }
}
