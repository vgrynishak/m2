<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\EditSectionCommand;
use App\App\Command\Section\EditSectionCommandInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Section\FailEditSectionAction;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Exception;

class EditSectionParser implements EditSectionParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * EditSectionParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return EditSectionCommandInterface
     * @throws FailEditSectionAction
     */
    public function parse(Request $request): EditSectionCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('editSectionRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['editSectionRequest'];

            if (!array_key_exists('id', $data)) {
                throw new InvalidArgumentException("Section Id is required field");
            }

            if (!array_key_exists('title', $data)) {
                throw new InvalidArgumentException("Title is required field");
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var EditSectionCommandInterface $editSectionCommand */
            $editSectionCommand = new EditSectionCommand(
                new SectionId($data['id']),
                $data['title'],
                $user
            );

            return $editSectionCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailEditSectionAction("Bad request. " . $exception->getMessage());
        } catch (Exception $exception) {
            throw new FailEditSectionAction("Bad request. " . $exception->getMessage());
        }
    }
}
