<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Command\ReportTemplate\GetByIdCommandInterface;
use App\App\Command\ReportTemplate\Validator\GetByIdValidatorInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Infrastructure\Exception\ReportTemplate\FailGetByIdAction;
use Exception;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;

class GetByIdCommandHandler implements MessageHandlerInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var GetByIdValidatorInterface */
    private $validator;

    /**
     * GetByIdCommandHandler constructor.
     * @param GetByIdValidatorInterface $validator
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     */
    public function __construct(
        GetByIdValidatorInterface $validator,
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
    ) {
        $this->validator = $validator;
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
    }

    /**
     * @param GetByIdCommandInterface $command
     * @return ReportTemplateInterface
     * @throws FailGetByIdAction
     */
    public function __invoke(GetByIdCommandInterface $command): ReportTemplateInterface
    {
        if (!$this->validator->validate($command)) {
            throw new FailGetByIdAction($this->validator->getFirstErrorMessage());
        }

        try {
            return $this->reportTemplateQueryRepository->find($command->getId());
        } catch (Exception $exception) {
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
