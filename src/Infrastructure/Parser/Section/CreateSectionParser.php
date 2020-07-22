<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\CreateSectionCommand;
use App\App\Command\Section\CreateSectionCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use DateTime;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Exception\Section\FailCreateSectionAction;

class CreateSectionParser implements CreateSectionParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateSectionParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return CreateSectionCommandInterface
     * @throws FailCreateSectionAction
     */
    public function parse(Request $request): CreateSectionCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('createSectionRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['createSectionRequest'];

            if (!array_key_exists('sectionId', $data)) {
                throw new InvalidArgumentException("Section Id is required field");
            }

            if (!array_key_exists('reportTemplateId', $data)) {
                throw new InvalidArgumentException("ReportTemplate Id is required field");
            }

            $title = $data['title'] ?? null;

            if (!$title) {
                throw new InvalidArgumentException('Invalid Title');
            }
            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var CreateSectionCommandInterface $createSectionCommand */
            $createSectionCommand = new CreateSectionCommand(
                new SectionId($data['sectionId']),
                new ReportTemplateId($data['reportTemplateId']),
                $title
            );

            $createSectionCommand->setCreatedAt(new DateTime());
            $createSectionCommand->setCreatedBy($user);

            return $createSectionCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailCreateSectionAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailCreateSectionAction("Bad request. " . $exception->getMessage());
        }
    }
}
