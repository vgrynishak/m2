<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\ChangeSectionPositionCommand;
use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use App\Infrastructure\Exception\Section\FailChangeSectionPositionAction;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class ChangeSectionPositionParser implements ChangeSectionPositionParserInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * ChangeSectionPositionParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param Request $request
     * @return ChangeSectionPositionCommandInterface
     * @throws FailChangeSectionPositionAction
     */
    public function parse(Request $request): ChangeSectionPositionCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('changeSectionPositionRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['changeSectionPositionRequest'];

            if (!array_key_exists('id', $data)) {
                throw new InvalidArgumentException("Section Id is required field");
            }

            if (!array_key_exists('newPosition', $data)) {
                throw new InvalidArgumentException("newPosition is required field");
            }

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->getUserFromToken();

            /** @var ChangeSectionPositionCommandInterface $changeSectionPositionCommand */
            $changeSectionPositionCommand = new ChangeSectionPositionCommand(
                new SectionId($data['id']),
                $data['newPosition'],
                $user
            );

            return $changeSectionPositionCommand;
        } catch (InvalidArgumentException $exception) {
            throw new FailChangeSectionPositionAction("Bad request. " . $exception->getMessage());
        } catch (\Exception $exception) {
            throw new FailChangeSectionPositionAction("Bad request. " . $exception->getMessage());
        }
    }
}
