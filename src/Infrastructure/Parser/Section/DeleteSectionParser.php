<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\DeleteSectionCommand;
use App\App\Command\Section\DeleteSectionCommandInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Section\FailDeleteSectionAction;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Exception;

class DeleteSectionParser implements DeleteSectionParserInterface
{
    /** @var UserQueryRepositoryInterface  */
    private $userQueryRepository;

    /**
     * DeleteSectionCommandParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return DeleteSectionCommandInterface
     * @throws FailDeleteSectionAction
     */
    public function parse(Request $request): DeleteSectionCommandInterface
    {
        try {
            /** @var SectionId $sectionId */
            $sectionId = $request->get('sectionId');
            if (!$sectionId instanceof SectionId) {
                throw new InvalidArgumentException('Section Id is required field');
            }
            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var DeleteSectionCommandInterface $deleteSectionCommand */
            $deleteSectionCommand = new DeleteSectionCommand($sectionId, $user);

            return $deleteSectionCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailDeleteSectionAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailDeleteSectionAction("Bad request. " . $exception->getMessage());
        }
    }
}
